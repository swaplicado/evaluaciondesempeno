function evaluar(evaluacion, objetivo) {
    // sacar valor que se tiene como total

    var nombreTotal = "sinr";
    nombreTotal = nombreTotal.concat(evaluacion);
    var califTotal = document.getElementById(nombreTotal).value;

    //sacar calificación anterior
    var nombreAnterior = "calificacion_anterior";
    nombreAnterior = nombreAnterior.concat(objetivo);
    var califAnterior = document.getElementById(nombreAnterior).value;

    // conformar nombre de ponderación
    var nombrePonderacion = "pon";
    nombrePonderacion = nombrePonderacion.concat(objetivo);
    var ponderacion = document.getElementById(nombrePonderacion).value;
    ponderacion = ponderacion / 100;

    // sacar la cifra que se le restara al total para tener el total antes de este objetivo
    califAnterior = califAnterior * ponderacion;

    // total sin este objetivo
    var TotalsinObjetivo = califTotal - califAnterior;

    //sacar calificacion nueva
    var nombreNueva = "calificacion_nueva";
    nombreNueva = nombreNueva.concat(objetivo);
    var califNueva = document.getElementById(nombreNueva).value;

    //cambiar la calificación anterior por la nueva
    document.getElementById(nombreAnterior).value = califNueva;

    //ponderar la calificacion nueva
    califNueva = califNueva * ponderacion;
    //colocar visible la calificación ponderada
    var nombreCalifpon = "calificacion_pon";
    nombreCalifpon = nombreCalifpon.concat(objetivo);
    document.getElementById(nombreCalifpon).value = califNueva.toFixed(1);

    // sumamos el total antes del objetivo con la nueva calificacion
    TotalsinObjetivo = TotalsinObjetivo + califNueva;


    //Redondear la calificacion

    var Totalredondeado = Math.round(TotalsinObjetivo);
    var nombreTotalredondeado = "total";
    nombreTotalredondeado = nombreTotalredondeado.concat(evaluacion);
    document.getElementById(nombreTotalredondeado).value = Totalredondeado;

    //colocar nombre de calificación
    var nombreCampo = "califnombre";
    nombreCampo = nombreCampo.concat(evaluacion);
    switch (Totalredondeado) {
        case 1:
            document.getElementById(nombreCampo).value = "No cumplió";
            break;
        case 2:
            document.getElementById(nombreCampo).value = "Cumplió algunos objetivos";
            break;
        case 3:
            document.getElementById(nombreCampo).value = "Cumplió los objetivos de su área y su equipo alcanzó objetivos y desarrollo personal";
            break;
        case 4:
            document.getElementById(nombreCampo).value = "Superó expectativas e implementó más proyectos de los establecidos";
            break;
        case 0:
            document.getElementById(nombreCampo).value = "Sin calificación";
            break;
    }

    //Redondear a un solo decimal para calificacion sin redondeo
    TotalsinObjetivo = TotalsinObjetivo.toFixed(1);
    document.getElementById(nombreTotal).value = TotalsinObjetivo;
}