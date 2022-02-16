function ponderacion(porcentaje) {
    var ponderacion = document.getElementById("suma").value;
    var suma = parseInt(ponderacion) + parseInt(porcentaje);

    if (suma > 100) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La ponderacion sería ' + suma + '% que es mayor al 100%',
        })
        document.getElementById("weighing").value = "";
    }
}