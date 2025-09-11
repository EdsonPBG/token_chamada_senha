<?php 
require_once __DIR__ . '/../service/tokenService.php';
require_once __DIR__ . '/../database/connection.db.php';

$conn = ConnectionDB::getConnection();
$resultado = tokenService::AtualizarStatusToken($conn, "Em atendimento","Atendido");

    if($resultado['sucesso']) {
        header('Location: painel-paciente.php');
        exit();
    } else {
        header('Location: recepcao.php?erro=' . urlencode($resultado['erro']));
        exit();
    }