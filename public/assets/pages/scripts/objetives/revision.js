function agregar() {
    var ponderacion = document.getElementById("ponderacion").value;

    if (ponderacion < 100) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La suma de los objetivos es ' + ponderacion + '% que es menor al 100%',
        })
    } else if (ponderacion > 100) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La suma de los objetivos es ' + ponderacion + '% que es mayor al 100%',
        })
    } else if (ponderacion == 100) {
        var id_empleado = document.getElementById("id_empleado").value;
        var anio = document.getElementById("anio").value;
        var evaluacion = document.getElementById("evaluacion").value;

        $.ajax({
            type: 'post',
            url: 'objetive/guardar',
            data: { 'id_empleado': id_empleado, 'anio': anio, 'evaluacion': evaluacion },

            success: function(data) {
                Swal.fire("Enviado", "Los objetivos se enviaron con exito", "success");
                $('#crear').attr('disabled', true);
                $('#enviar').attr('disabled', true);

            },
        });
    }
}