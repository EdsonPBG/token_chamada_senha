<?php

$mensagem = $_GET['sucesso'] ?? $_GET['erro'] ?? '';

$pagina = new ConteudoRecepcao($mensagem);
echo $pagina->renderHead();
echo $pagina->renderBody(); 