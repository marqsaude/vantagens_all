var wrapper = document.getElementById("signature-pad"),
    clearButton = wrapper.querySelector("[data-action=clear]"),
    backButton = wrapper.querySelector("[data-action=back]"),
    savePNGButton = wrapper.querySelector("[data-action=save-png]"),
    //saveSVGButton = wrapper.querySelector("[data-action=save-svg]"),
    canvas = wrapper.querySelector("canvas"),
    signaturePad;

// Adjust canvas coordinate space taking into account pixel ratio,
// to make it look crisp on mobile devices.
// This also causes canvas to be cleared.
function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

signaturePad = new SignaturePad(canvas);

backButton.textContent = "Voltar";
backButton.addEventListener("click", function (event) {
    window.location.href = getUrlController() + "/gog/cartao-marq/add-cliente";
});

clearButton.textContent = "Limpar";
clearButton.addEventListener("click", function (event) {
    signaturePad.clear();
});

savePNGButton.textContent = "Próximo";
savePNGButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
        alert("É necessario assinar antes de prosseguir.");
    } else {
        if(confirm("Confirma assinatura?")) {
            //console.debug(signaturePad.toDataURL());
            moveFile(signaturePad.toDataURL());
           //window.open(signaturePad.toDataURL());
            //moveFile(old);
        }
    }
});

function moveFile(fileUri) {
    var array = {"file":fileUri};
    //alert("oiiiaaa");
    //if(detectmob()==false){
        //window.open(signaturePad.toDataURL('image/svg+xml'));
        ajaxPost(funcaoMoveFile, array, "/assinatura/ajax-assina/", "/gog");
    //}

}

var funcaoMoveFile = function(json){
    if (json != false) {

    }
};

function detectmob() {
    var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    return isMobile;
}

/*saveSVGButton.addEventListener("click", function (event) {
    if (signaturePad.isEmpty()) {
        alert("Please provide signature first.");
    } else {
        window.open(signaturePad.toDataURL('image/svg+xml'));
    }
});*/