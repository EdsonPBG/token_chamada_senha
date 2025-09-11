<?php
require_once __DIR__ . '/../service/tokenService.php';
require_once __DIR__ . '/../database/connection.db.php';

$conn = ConnectionDB::getConnection();
$resultado = tokenService::AtualizarStatusToken($conn, "Em atendimento", "Atendido");

    if($resultado['sucesso']) {
        header('Location: recepcao.php?sucesso=' . urldecode("Atendimento ao paciente {$resultado['token']} finalizado"));
        exit();
    } else {
        header('Location: recepcao.php?erro=' . urldecode($resultado['erro']));
        exit();
    }