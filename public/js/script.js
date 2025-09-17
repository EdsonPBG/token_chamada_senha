function painelPaciente () {
    fetch('index.php?page=painel-paciente-dados')
        .then(response => response.json())
        .then(data => {

            const tokenAtual = data.atendimento?.token || "Nenhum paciente em atendimento";
            document.getElementById('token-atendimento').textContent = tokenAtual;

            const listaEspera = document.getElementById('lista-espera')
            listaEspera.innerHTML = "";

            data.espera.forEach(token => {
                const li = document.createElement('li');
                li.textContent = token.token;
                listaEspera.appendChild(li);
            });
        })
        .catch(error => console.error('Erro:', error));
}

setInterval(painelPaciente, 5000);
painelPaciente()