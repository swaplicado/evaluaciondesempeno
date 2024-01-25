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
                setTimeout(() => { document.location.reload(); }, 2000);
            },
            error: function(data) {
                var response = JSON.parse(data.responseText);
                var table = $('#indicators').DataTable();
                var rows = table.rows().data().toArray();
                var lista = '<ul>';
                for (var i = 0; i < response.objectives.length; i++){
                    let index = findObjective(rows, response.objectives[i]);
                    if(index[0]){
                        let ruta = routeEdit.replace(/id/g, rows[index[1]][5]);
                        lista += '<li style="text-align: left;">'
                            + '<div class="custom-list">'
                            + '<a href="' + ruta + '" class="btn btn-primary buttonToSwal" id="edicion" title="Modificar este registro">'
                            +     '<i class="fa fa-fw fa-wrench"></i>'
                            + '</a>&nbsp;&nbsp;'
                            + rows[index[1]][0] + ' - ' + response.objectives[i] + '</div></li>';
                    }else{
                        lista += '<li><div class="custom-list">' + response.objectives[i] + '</div></li>';
                    }
                }
                lista += '</ul>';
                Swal.fire({
                    title: "<strong>" + response.error + "</strong>",
                    icon: "error",
                    html: lista + '<br>' + '<b>Recuerda que al enviar los objetivos, estos deben tener un comentario.</b>',
                });
            }
        });
    }
}

function findObjective(array, objective) {
    for (var i = 0; i < array.length; i++) {
        for (var j = 0; j < array[i].length; j++) { 
            if (array[i][j] == objective) {
                return [true, i, j];
            }
        }
    }
    return [false, -1, -1];
}