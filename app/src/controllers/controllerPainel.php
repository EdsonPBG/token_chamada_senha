<?php

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../service/tokenService.php';

class ControllerPainel {
    public static function getStatusPainel () {
        $conn = ConnectionDB::getConnection();

        $token_atendimento = tokenService::AtualizarStatusToken($conn, "Em atendimento");
        $token_espera = tokenService::AtualizarStatusToken($conn, "Em espera");

        header ('Content-type: application/json');
            echo json_encode([
                'atendimento' => $token_atendimento,
                'espera' => $token_espera
            ]);
            exit();
    }
}