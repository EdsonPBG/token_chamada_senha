<?php
require_once __DIR__ . '/../database/connection.db.php';
$conn = ConnectionDB::getConnection();

// Busca o token "Em atendimento" se houver e armazena no $token_atendimento
$stmt_atendimento = $conn->prepare("SELECT numero_token FROM tokens WHERE status = 'Em atendimento' ORDER BY data_criacao DESC LIMIT 1");
$stmt_atendimento->execute();
$token_atendimento = $stmt_atendimento->fetch(PDO::FETCH_ASSOC);

// Busca o token "Em espera" e armazena no $tokens_espera
$stmt_espera = $conn->prepare("SELECT numero_token FROM tokens WHERE status = 'Em espera' ORDER BY data_criacao ASC LIMIT 10");
$stmt_espera->execute();
$tokens_espera = $stmt_espera->fetchall(PDO::FETCH_COLUMN, 0);
?>