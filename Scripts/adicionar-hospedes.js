document.getElementById("form-adicionar-hospede").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita o comportamento padrão do formulário

   
    const formData = new FormData(this);

    
    fetch("http://localhost/Sistema_de_hotel/Backend/adicionar_hospede.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); 
        
        this.reset();
        
    })
    .catch(error => console.error("Erro ao adicionar hóspede:", error));
});
