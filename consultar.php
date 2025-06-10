<?php
$cpf = $_GET['cpf'] ?? '';

if (!$cpf) {
  echo "<script>alert('CPF não informado.'); window.location.href = 'index.html';</script>";
  exit;
}

$api = "https://magmadatahub.com/api.php?token=d129896ec839f47542bb85b64db8d0469ef29cd6ecb7f453bbd2c5dff1482162&cpf={$cpf}";
$response = @file_get_contents($api);

if (!$response) {
  echo "<script>alert('Erro ao consultar a API.'); window.location.href = 'index.html';</script>";
  exit;
}

$data = json_decode($response, true);

// Validação mínima: precisa ter 'nome'
if (!isset($data['nome']) || empty($data['nome'])) {
  echo "<script>alert('CPF não encontrado ou inválido.'); window.location.href = 'index.html';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="refresh" content="1;url=consulta/index.html">
  <title>Validando CPF...</title>
</head>
<body>
  <script>
    localStorage.setItem("nome", <?= json_encode($data['nome']) ?>);
    localStorage.setItem("cpf", <?= json_encode($data['cpf'] ?? $cpf) ?>);
    localStorage.setItem("nascimento", <?= json_encode($data['nascimento'] ?? '') ?>);
    localStorage.setItem("mae", <?= json_encode($data['nome_mae'] ?? '') ?>);
    localStorage.setItem("sexo", <?= json_encode($data['sexo'] ?? '') ?>);
  </script>

  <p style="font-family: sans-serif; text-align: center; margin-top: 20%;">
    Aguarde..
  </p>
</body>
</html>
