<?php

class ConteudoPainel {
    public function renderHead () {
        $html = <<<HTML
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/painel.css">
    <title>Painel de Atendimento</title>
</head>
<body>
HTML;
        return $html;
    }

    public function renderBody () {
        $html = <<<HTML
<h1>Próximo a ser atendido(a):</h1>
<div id="atendimento-container">
    <div id="atendimento-token">Nenhum paciente em atendimento</div>
</div>
    
<h2>Em espera:</h2>
<ul id="lista-espera" class="lista_espera">

</ul>

<script src="js/script.js"></script>
</body>
</html>
HTML;
        return $html;
    }
}