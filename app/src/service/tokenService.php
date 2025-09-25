<?php
require_once __DIR__ . '/../database/connection.db.php';

class TokenService { 
    // Classe publica de gerar senha
    public static function GerarSenha($conn, $nome_paciente, $telefone_paciente, $email_paciente, $data_nascimento) {
        $conn = ConnectionDB::getConnection();

        try {
            $conn->beginTransaction(); // Inicia uma transação 
            $stmt_paciente = $conn->prepare("INSERT INTO pacientes (nome_paciente, telefone_paciente, email_paciente, data_nascimento, data_cadastro) VALUES (?, ?, ?, ?, NOW())");
            $stmt_paciente->execute([$nome_paciente, $telefone_paciente, $email_paciente, $data_nascimento]);

            $id_paciente = $conn->lastInsertId(); //Pega o ultimo id inserido
            $numero_token = 'P-' . $id_paciente; 

            $stmt_token = $conn->prepare("INSERT INTO tokens (numero_token, id_paciente, status, data_criacao) VALUES (?,?,?, NOW())");
            $stmt_token->execute([$numero_token, $id_paciente, 'Em espera']);

            $conn->commit(); //Quando todas as operações são concluidas com sucesso
            return ["sucesso" => true, "token" => $numero_token, "nome" => $nome_paciente];

        } 
        catch (PDOExceptio $e) {
            $conn->rollBack(); //Quando nenhuma delas é concluida
            return ["sucesso" => false, "erro" => "Erro ao gerar senha: " . $e->getMessage()];
        }
    }

    public static function AtualizarStatusToken($conn, $status_atual, $status_novo) { //Cria uma função com 3 parametros que chama o paciente e finaliza o atendimento
        try {
            $conn->beginTransaction();
            $stmt_select = $conn->prepare("SELECT numero_token FROM tokens WHERE status = ? ORDER BY data_criacao ASC LIMIT 1");
            $stmt_select->execute([$status_atual]);
            $token_a_atualizar = $stmt_select->fetch(PDO::FETCH_ASSOC);

                if ($token_a_atualizar) { //se for true
                        $numero_token = $token_a_atualizar['numero_token'];
                        $stmt_update = $conn->prepare("UPDATE tokens SET status = ? WHERE numero_token = ?");
                        $stmt_update->execute([$status_novo, $numero_token]);

                        $conn->commit();//QUando todas as operações são concluidas
                        return ["sucesso" => true, "token" => $numero_token];
                    } else { //se for false
                        $conn->rollBack();
                        return ["sucesso" => false, "erro" => "Nenhum paciente encontrado."];
                    }
        } catch (PDOException $e) {
            $conn->rollBack();
            return ["sucesso" => false, "erro" => "Erro: " . $e->getMessage()];
        }
    }

    public static function buscarPorStatus ($conn, $status) {
        try {
            $stmt = $conn->prepare("SELECT t.numero_token, t.status, p.nome_paciente 
                                    FROM tokens AS t INNER JOIN pacientes AS p ON t.id_paciente = p.id_paciente 
                                    WHERE t.status = :status ORDER BY t.numero_token ASC");
                                    
            $stmt->bindValue(':status', $status); // Associa o parâmetro de forma segura para evitar SQL Injection
            $stmt->execute();

            if($status === 'Em atendimento'){
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            // Em caso de erro no banco de dados, retorna uma mensagem
            return ['erro' => "Erro ao buscar tokens: " . $e->getMessage()];
        }
    }
}