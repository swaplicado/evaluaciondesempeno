function llenar() {
    var select = document.getElementById("colaborador"); // Obtener el elemento select por su ID
    var valorSeleccionado = select.value;

    if(valorSeleccionado == "0"){
        swal("Error", "Se tiene que seleccionar a un colaborador", "warning");
    }else{
        var json = document.getElementById("global").value;
        json = JSON.parse(json);
        
        var idABuscar = parseInt(valorSeleccionado);
        var registroEncontrado = json.find(function(json) {
            return json.id_global_user === idABuscar;
        });

        if( typeof registroEncontrado !== 'undfined'){
            document.getElementById('us').value = registroEncontrado.username;
            document.getElementById('fus').value = registroEncontrado.username;
            var nombres = separarNombre(registroEncontrado.full_name);
            document.getElementById('name').value = nombres[1];
            document.getElementById('fname').value = nombres[1];
            document.getElementById('apellidos').value = nombres[0];
            document.getElementById('fapellidos').value = nombres[0];
            document.getElementById('numEmpl').value = registroEncontrado.employee_num;
            document.getElementById('fnumEmpl').value = registroEncontrado.employee_num;
            document.getElementById('email').value = registroEncontrado.email;
            document.getElementById('femail').value = registroEncontrado.email;
            document.getElementById('fpass').value = registroEncontrado.password;
            document.getElementById('fglobal').value = registroEncontrado.id_global_user;

            document.getElementById('guardar').removeAttribute('disabled');
            document.getElementById('dept').removeAttribute('disabled');
            document.getElementById("colaborador").setAttribute('disabled', 'disabled');
            document.getElementById("seleccionar").setAttribute('disabled', 'disabled');
        }else{
            swal("Error", "Se tiene que seleccionar a un colaborador", "warning");
        }
    }

    function separarNombre(full_name){
        var nombres = [];
        nombres = full_name.split(",");
        return nombres;
    }
}