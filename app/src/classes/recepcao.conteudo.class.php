<?php

class ConteudoRecepcao {

    private $mensagem;

    public function __construct($mensagem = '') { // RECEBE A MENSAGEM PARA UTILIZAR NO ALERTA
        $this->mensagem = $mensagem;
    }

    public function renderHead () {

    $html = <<<HTML
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="css/style.css">
    <title>Painel da Recepção</title>
</head>
<body>
HTML;
        return $html; 
    }

    public function renderBody () {
    $html = <<<HTML
    
<script> 
    function exibirMensagem() { // exibe a mensagem de alerta apos gerar senha e finalizar

    const mensagem = "{$this->mensagem}";

    if(mensagem !== "") {
        alert(mensagem);
    }
}

    exibirMensagem();
</script>

<div class="form-container"> 
<h1>Novo Paciente</h1>

<form method="POST" action="index.php?action=gerar">
    <label for="nome_paciente">Nome do Paciente:</label>
    <input type="text" id="nome_paciente" name="nome_paciente" required>

    <label for="telefone_paciente">Telefone do Paciente:</label>
    <input type="tel" id="telefone_paciente" name="telefone_paciente" required>

    <label for="email_paciente">Email do Paciente:</label>
    <input type="text" id="email_paciente" name="email_paciente" required>

    <label for="data_nascimento">Data de Nascimento:</label>
    <input type="date" id="data_nascimento" name="data_nascimento" required>

    <button type="submit">Gerar Senha</button>
</form>
</div>

<div class="chamar-container">
    <h1>Chamar Paciente</h1>
    <form action="index.php?action=chamar" method="POST">
    <button type="submit">Chamar Próximo Paciente</button>
    </form>
</div>

<div class="finalizar-container">
    <h1>Finalizar Atendimento</h1>
    <form action="index.php?action=finalizar" method="POST">
    <button type="submit">Finalizar Atendimento</button>
    </form>
</div>
</body>
</html>
HTML;
            return $html;
    }
}