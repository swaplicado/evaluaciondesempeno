function aprobar(id_eval) {
    // recuperar comentario
    var nombre = "comentarios";
    nombre = nombre.concat(id_eval);
    var comentarios = document.getElementById(nombre).value;
    var anio = 2021;

    // nombres para poder bloquear botones
    var icomentario = "#comentarios"
    var iapro = "#apro";
    var irecha = "#recha";
    var icanc = "#cancel";
    var idesbloquear = "#desbloquear";
    var iini = "#ini";
    var irecalif = "#recalif";

    icomentario = icomentario.concat(id_eval);
    iapro = iapro.concat(id_eval);
    irecha = irecha.concat(id_eval);
    icanc = icanc.concat(id_eval);
    idesbloquear = idesbloquear.concat(id_eval);
    iini = iini.concat(id_eval);
    irecalif = irecalif.concat(id_eval);


    // nombres de los select de calificaciones
    var nombreArreglo = "arreglo"
    nombreArreglo = nombreArreglo.concat(id_eval);
    var arreglo = document.getElementById(nombreArreglo).value;
    arreglo = arreglo.split(',');

    var arrNum = [];
    var arrCal = [];
    // recuperar objetivo y calificación
    var sinCalificar = 0;
    for (var i = 0; arreglo.length > i; i = i + 1) {
        var numObj = arreglo[i].replace('calificacion_nueva', '');
        var califObj = document.getElementById(arreglo[i]).value;

        if (califObj == 0) {
            sinCalificar = 1;
        }

        document.getElementById(arreglo[i]).setAttribute('disabled', true);
        // arreglo con id de objetivo

        arrNum[i] = numObj;

        //arreglo con calificación objetivo

        arrCal[i] = califObj;


    }
    // recuperar score

    var nombreScore = "sinr"
    var nombreRedondeo = "total"

    nombreScore = nombreScore.concat(id_eval);
    nombreRedondeo = nombreRedondeo.concat(id_eval);

    var score = document.getElementById(nombreScore).value;
    var score_redondeado = document.getElementById(nombreRedondeo).value;

    if (sinCalificar == 1) {
        Swal.fire("Error", "No se puede dejar objetivos sin calificar", "warning");
    } else {
        $.ajax({
            type: 'post',
            url: 'evalaprove',
            data: { 'id_empleado': id_eval, 'anio': anio, 'comentario': comentarios, 'arrNum': arrNum, 'arrCal': arrCal, 'score': score, 'score_redondeado': score_redondeado },

            success: function(data) {
                Swal.fire("Evaluado", "La evaluación se realizó correctamente", "success");
                $(icomentario).attr('readonly', true);
                $(iapro).attr('disabled', true);
                $(irecha).attr('disabled', true);
                $(icanc).attr('disabled', true);
                $(idesbloquear).attr('disabled', true);
                $(iini).attr('disabled', true);
                $(irecalif).attr('disabled', true);

            },
        });
    }
}

function rechazar(id_eval) {
    var anio = 2021;
    var comentarios = document.getElementById(nombre).value;

    var icomentario = "#comentarios"
    var iapro = "#apro";
    var irecha = "#recha";
    var icanc = "#cancel";
    var idesbloquear = "#desbloquear";
    var iini = "#ini";
    var irecalif = "#recalif";

    icomentario = icomentario.concat(id_eval);
    iapro = iapro.concat(id_eval);
    irecha = irecha.concat(id_eval);
    icanc = icanc.concat(id_eval);
    idesbloquear = idesbloquear.concat(id_eval);
    iini = iini.concat(id_eval);
    irecalif = irecalif.concat(id_eval);

    $(icomentario).attr('readonly', true);
    $(iapro).attr('disabled', true);
    $(irecha).attr('disabled', true);
    $(icanc).attr('disabled', true);
    $(idesbloquear).attr('disabled', true);
    $(iini).attr('disabled', true);
    $(irecalif).attr('disabled', true);

    var nombreArreglo = "arreglo"
    nombreArreglo = nombreArreglo.concat(id_eval);
    var arreglo = document.getElementById(nombreArreglo).value;
    arreglo = arreglo.split(',');

    for (var i = 0; arreglo.length > i; i = i + 1) {
        document.getElementById(arreglo[i]).setAttribute('disabled', true);

    }

    $.ajax({
        type: 'post',
        url: 'evalrefuse',
        data: { 'id_evaluacion': id_eval, 'anio': anio, 'comentario': comentarios },

        success: function(data) {
            $(icomentario).attr('disabled', true);
            $(iapro).attr('disabled', true);
            $(irecha).attr('disabled', true);
            Swal.fire("Rechazado", "La evaluacion se rechazo", "success");


        },
    });
}

function recalif(id_eval) {
    var icomentario = "#comentarios"
    var iapro = "#apro";
    var irecha = "#recha";
    var icanc = "#cancel";
    var idesbloquear = "#desbloquear";
    var iini = "#ini";
    var irecalif = "#recalif";

    icomentario = icomentario.concat(id_eval);
    iapro = iapro.concat(id_eval);
    irecha = irecha.concat(id_eval);
    icanc = icanc.concat(id_eval);
    idesbloquear = idesbloquear.concat(id_eval);
    iini = iini.concat(id_eval);
    irecalif = irecalif.concat(id_eval);

    $(icomentario).attr('readonly', false);
    $(iapro).attr('disabled', false);
    $(irecha).attr('disabled', true);
    $(icanc).attr('disabled', false);
    $(idesbloquear).attr('disabled', true);
    $(iini).attr('disabled', true);
    $(irecalif).attr('disabled', true);

    var nombreArreglo = "arreglo"
    nombreArreglo = nombreArreglo.concat(id_eval);
    var arreglo = document.getElementById(nombreArreglo).value;
    arreglo = arreglo.split(',');

    for (var i = 0; arreglo.length > i; i = i + 1) {
        document.getElementById(arreglo[i]).removeAttribute('disabled', true);

    }

}

function can(id_eval) {
    var icomentario = "#comentarios"
    var iapro = "#apro";
    var irecha = "#recha";
    var icanc = "#cancel";
    var idesbloquear = "#desbloquear";
    var iini = "#ini";
    var irecalif = "#recalif";
    var iscore = "havescore";

    icomentario = icomentario.concat(id_eval);
    iapro = iapro.concat(id_eval);
    irecha = irecha.concat(id_eval);
    icanc = icanc.concat(id_eval);
    idesbloquear = idesbloquear.concat(id_eval);
    iini = iini.concat(id_eval);
    irecalif = irecalif.concat(id_eval);
    iscore = iscore.concat(id_eval);


    var havescore = document.getElementById(iscore).value;

    $(icomentario).attr('readonly', true);
    $(iapro).attr('disabled', true);
    $(irecha).attr('disabled', true);
    $(icanc).attr('disabled', true);
    $(idesbloquear).attr('disabled', false);

    if (havescore == 0) {
        $(irecalif).attr('disabled', true);
        $(iini).attr('disabled', false);
    } else {
        $(iini).attr('disabled', true);
        $(irecalif).attr('disabled', false);
    }

    var nombreArreglo = "arreglo"
    nombreArreglo = nombreArreglo.concat(id_eval);
    var arreglo = document.getElementById(nombreArreglo).value;
    arreglo = arreglo.split(',');

    for (var i = 0; arreglo.length > i; i = i + 1) {
        document.getElementById(arreglo[i]).setAttribute('disabled', true);

    }


}

function desblo(id_eval) {
    var icomentario = "#comentarios"
    var iapro = "#apro";
    var irecha = "#recha";
    var icanc = "#cancel";
    var idesbloquear = "#desbloquear";
    var iini = "#ini";
    var irecalif = "#recalif";

    icomentario = icomentario.concat(id_eval);
    iapro = iapro.concat(id_eval);
    irecha = irecha.concat(id_eval);
    icanc = icanc.concat(id_eval);
    idesbloquear = idesbloquear.concat(id_eval);
    iini = iini.concat(id_eval);
    irecalif = irecalif.concat(id_eval);

    $(icomentario).attr('readonly', false);
    $(iapro).attr('disabled', true);
    $(irecha).attr('disabled', false);
    $(icanc).attr('disabled', false);
    $(idesbloquear).attr('disabled', true);
    $(irecalif).attr('disabled', true);
    $(iini).attr('disabled', true);

    var nombreArreglo = "arreglo"
    nombreArreglo = nombreArreglo.concat(id_eval);
    var arreglo = document.getElementById(nombreArreglo).value;
    arreglo = arreglo.split(',');

    for (var i = 0; arreglo.length > i; i = i + 1) {
        document.getElementById(arreglo[i]).removeAttribute('disabled', true);

    }
}