// Função para carregar a lista de hóspedes
function carregarHospedes() {
    fetch("http://localhost/Sistema_de_hotel/Backend/listar_hospedes.php")
        .then(response => response.json())
        .then(data => {
            const hospedesList = document.getElementById("hospedes-list");
            hospedesList.innerHTML = ""; // Limpa a lista

            data.forEach(hospede => {
                const listItem = document.createElement("li");
                listItem.textContent = `${hospede.nome} - Telefone: ${hospede.telefone} - Quarto: ${hospede.quarto}`;

                // Botão de remoção
                const removeButton = document.createElement("button");
                removeButton.textContent = "✖";
                removeButton.style.marginLeft = "10px";
                removeButton.onclick = function() {
                    removerHospede(hospede.id);
                };

                listItem.appendChild(removeButton);
                hospedesList.appendChild(listItem);
            });
        })
        .catch(error => console.error("Erro ao carregar hóspedes:", error));
}

// Função para remover um hóspede
function removerHospede(id) {
    fetch("http://localhost/Sistema_de_hotel/Backend/remover_hospede.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${id}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Mostra mensagem de sucesso ou erro
        carregarHospedes(); // Recarrega a lista de hóspedes
    })
    .catch(error => console.error("Erro ao remover hóspede:", error));
}

// Carregar a lista de hóspedes ao abrir a aba
document.addEventListener("DOMContentLoaded", carregarHospedes);
