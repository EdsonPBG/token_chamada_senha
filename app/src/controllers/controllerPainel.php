<?php

require_once __DIR__ . '/../database/connection.db.php';
require_once __DIR__ . '/../service/tokenService.php';

class ControllerPainel {
    public static function getStatusPainel () { // A FUNÇÃO BUSCA O STATUS ATUAL DO PAINEL E RETORNA APENAS EM FORMATO JSON

        $conn = ConnectionDB::getConnection();
        $token_espera = tokenService::buscarPorStatus($conn, "Em espera");
        $token_atendimento = tokenService::buscarPorStatus($conn, "Em atendimento");

        header ('Content-type: application/json');
            echo json_encode([
                'atendimento' => $token_atendimento,
                'espera' => $token_espera
            ]);
            exit();
    }
}