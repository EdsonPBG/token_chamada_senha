function painelPaciente () {
    fetch('index.php?page=painel-paciente-dados')
        .then(response => {
            if (!response.ok) {
                // Lança um erro se a resposta HTTP não for bem-sucedida
                throw new Error('Erro na rede ou servidor ' + response.statusText);
            }
            return response.json();
        })

        .then(data => {
            const tokenAtual = data.atendimento?.numero_token || "Nenhum paciente em atendimento";
            document.getElementById('atendimento-token').textContent = tokenAtual;

            const listaEspera = document.getElementById('lista-espera')
            listaEspera.innerHTML = "";

            data.espera.forEach(token => {
                const li = document.createElement('li');

                li.textContent = token.numero_token + '  ' + token.nome_paciente;
                
                listaEspera.appendChild(li);
            });
        })
        .catch(error => console.error('Erro:', error));
}

setInterval(painelPaciente, 5000);
painelPaciente()