<?php
session_start();

require_once __DIR__ . '/../app/src/database/connection.db.php';
require_once __DIR__ . '/../app/src/controllers/controllerRecepcao.php';
require_once __DIR__ . '/../app/src/controllers/controllerPainel.php';
require_once __DIR__ . '/../app/src/classes/painel.conteudo.class.php';
require_once __DIR__ . '/../app/src/classes/recepcao.conteudo.class.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'gerar':
                $nome_paciente = $_POST['nome_paciente'] ?? '';
                $telefone_paciente = $_POST['telefone_paciente'] ?? '';
                $email_paciente = $_POST['email_paciente'] ?? '';
                $data_nascimento = $_POST['data_nascimento'] ?? '';
                ControllerRecepcao::gerar($nome_paciente, $telefone_paciente, $email_paciente, $data_nascimento);
            break;

            case 'chamar':
                ControllerRecepcao::chamar();
            break;

            case 'finalizar':
                ControllerRecepcao::finalizar();
            break;

            default: 
                header('Location: index.php?page=recepcao');
                exit();
        }
    }

    $page = $_GET['page'] ?? 'recepcao';
    $mensagem = $_GET['sucesso'] ?? $_GET['erro'] ?? '';

    switch ($page) {
        case 'recepcao':
            $pagina = new ConteudoRecepcao($mensagem);
            echo $pagina->renderHead();
            echo $pagina->renderBody();
        break;

        case 'painel-paciente':
            $painel = new ConteudoPainel();
            echo $painel->renderHead();
            echo $painel->renderBody();
        break;

        case 'painel-paciente-dados':
        ControllerPainel::getStatusPainel();
        break;

        default:
            echo "404 - PAGINA NÃO ENCONTRADA";
        break;
    }