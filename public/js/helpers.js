async function hablar(texto) {
    let utter = await new SpeechSynthesisUtterance();
    utter.lang = "es-ES";
    utter.text = texto;
    utter.volume = 0.7;
    return await window.speechSynthesis.speak(utter);
}

function notificacion(mensaje, tipo = "success") {

    var backgroundColor = tipo == "success" 
        ? "linear-gradient(to right, #00b09b, #96c93d)" 
        : "linear-gradient(to right, #00b09b, #96c93d)" ;
 
    Toastify({
        text: mensaje,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
          background: backgroundColor,
        },
        onClick: function(){}
    }).showToast();

}