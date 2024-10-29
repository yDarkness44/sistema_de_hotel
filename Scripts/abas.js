function abrirAba(nomeAba) {
   
    var abas = document.getElementsByClassName("conteudo-aba");
    for (var i = 0; i < abas.length; i++) {
        abas[i].style.display = "none";
    }

    
    document.getElementById(nomeAba).style.display = "block";
}
