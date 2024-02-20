$(document).ready(function() {
    $("#indicators").on('submit', '.form-eliminar', function() {
        event.preventDefault();
        const form = $(this);
        swal.fire({
            title: '¿Está seguro que desea eliminar el registro?',
            text: "¡Esta acción no se puede deshacer!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Continuar',
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxRequest(form);
            }
        });
    });
    $("#indicators").on('click', '.editar', function() {
        event.preventDefault();
        const form = $(this);
        swal.fire({
            title: '¿Está seguro que desea editar este objetivo?',
            text: "Al tener calificación si se edita se perderá",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Continuar',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = form[0].href;
            }
        });
    });

    function ajaxRequest(form) {
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(respuesta) {
                if (respuesta.mensaje == "ok") {
                    form.parents('tr').remove();
                } else {}
            },
            error: function() {

            }
        });
    }
});