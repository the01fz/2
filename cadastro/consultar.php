<?php
header('Content-Type: application/json');

if (!isset($_GET['cpf'])) {
    echo json_encode(["status" => 400, "erro" => "CPF não enviado"]);
    exit;
}

$cpf = preg_replace('/[^0-9]/', '', $_GET['cpf']);
$token = 'd129896ec839f47542bb85b64db8d0469ef29cd6ecb7f453bbd2c5dff1482162';
$url = "https://magmadatahub.com/api.php?token=$token&cpf=$cpf";

// Requisição cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Log da resposta bruta da API
file_put_contents('log_api.txt', $response);

if ($httpCode === 200 && $response) {
    $data = json_decode($response, true);

    echo json_encode([
        "status" => 200,
        "data" => [
            "sexo" => $data['SEXO'] ?? '',
            "nome_mae" => $data['NOME_MAE'] ?? '',
            "nascimento" => $data['NASC'] ?? '',
            "nome" => $data['nome'] ?? $data['NOME'] ?? $data['NOME COMPLETO'] ?? ''

        ]
    ]);
} else {
    echo json_encode(["status" => $httpCode, "erro" => "Erro ao consultar a API"]);
}
?>
