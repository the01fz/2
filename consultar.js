export default async function handler(req, res) {
  const { cpf } = req.query;

  if (!cpf) {
    return res.status(400).json({ erro: 'CPF não informado.' });
  }

  const cleanCpf = cpf.replace(/\D/g, '');
  const api = `https://magmadatahub.com/api.php?token=d129896ec839f47542bb85b64db8d0469ef29cd6ecb7f453bbd2c5dff1482162&cpf=${cleanCpf}`;

  try {
    const response = await fetch(api);
    const data = await response.json();

    if (!data.nome) {
      return res.status(404).json({ erro: 'CPF não encontrado ou inválido.' });
    }

    return res.status(200).json({
      nome: data.nome || data['NOME'] || '',
      cpf: data.cpf || cleanCpf,
      nascimento: data.nascimento || data['NASC'] || '',
      nome_mae: data.nome_mae || data['NOME_MAE'] || '',
      sexo: data.sexo || data['SEXO'] || ''
    });

  } catch (e) {
    return res.status(500).json({ erro: 'Erro ao consultar a API.' });
  }
}