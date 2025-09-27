<?php 
require_once __DIR__ . '/../service/tokenService.php';
require_once __DIR__ . '/../database/connection.db.php';

class ControllerRecepcao {

     public static function gerar($nome, $telefone, $email, $nascimento) { 
        $conn = ConnectionDB::getConnection();
        $resultado = TokenService::gerarSenha($conn, $nome, $telefone, $email, $nascimento);

        if($resultado['sucesso']) {
            header('Location: index.php?page=recepcao&sucesso=' . urlencode("Senha: {$resultado['token']} Nome: {$resultado['nome']}"));
            exit();
        } else {
            header('Location: index.php?page=recepcao&erro=' . urlencode($resultado['erro']));
            exit();
        }
    }

    public static function chamar() {
        $conn = ConnectionDB::getConnection();
        $resultado = tokenService::AtualizarStatusToken($conn ,"Em espera", "Em atendimento");

        if($resultado['sucesso']) {
            header('Location: index.php?page=recepcao');
            exit();
        } else {
            header('Location: index.php?page=recepcao&erro=' . urlencode($resultado['erro']));
            exit();
        }
    }

    public static function finalizar() {
        $conn = ConnectionDB::getConnection();
        $resultado = tokenService::AtualizarStatusToken($conn, "Em atendimento", "Atendido");

        if($resultado['sucesso']) {
            header('Location: index.php?page=recepcao&sucesso=' . urlencode("Atendimento a Senha: {$resultado['token']} finalizado"));
            exit();
        } else {
            header('Location: index.php?page=recepcao&erro=' . urlencode($resultado['erro']));
            exit();
        }
    }
}