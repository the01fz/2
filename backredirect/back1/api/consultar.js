export default async function handler(req, res) {
  const { cpf } = req.query;

  if (!cpf) {
    return res.status(400).json({ status: 400, erro: "CPF não enviado" });
  }

  const cleanCpf = cpf.replace(/\D/g, '');
  const token = 'd129896ec839f47542bb85b64db8d0469ef29cd6ecb7f453bbd2c5dff1482162';
  const url = `https://magmadatahub.com/api.php?token=${token}&cpf=${cleanCpf}`;

  try {
    const response = await fetch(url);
    const data = await response.json();

    return res.status(200).json({
      status: 200,
      data: {
        sexo: data['SEXO'] || '',
        nome_mae: data['NOME_MAE'] || '',
        nascimento: data['NASC'] || '',
        nome: data['nome'] || data['NOME'] || data['NOME COMPLETO'] || ''
      }
    });
  } catch (err) {
    return res.status(500).json({ status: 500, erro: "Erro ao consultar a API" });
  }
}
