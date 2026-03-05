function toggleOtro(select, idContenedor) {
    const contenedor = document.getElementById(idContenedor);
    const inputInterno = contenedor.querySelector('input, textarea');

    if (select.value === "Otro" || select.value === "otra_marca") {
        contenedor.style.display = "block";
        inputInterno.required = true;
        inputInterno.focus();
    } else {
        contenedor.style.display = "none";
        inputInterno.required = false;
    }
}

document.querySelector('input[name="otra_marca_texto"]').addEventListener('input', function (e) {
    const valor = e.target.value.toLowerCase();
    if (valor.includes('apple') || valor.includes('mac')) {
        alert('Lo sentimos, por el momento no trabajamos con la arquitectura de Apple.');
        e.target.value = '';
    }
});