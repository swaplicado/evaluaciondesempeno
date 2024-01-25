@extends('adminlte::page')

@section('title', 'Evaluación desempeño ' . $year)

@section('content_header')
    <link rel="shortcut icon" href="{{ asset('favicons/icono.png') }}" />
    <h1><b>Evaluación de desempeño.</b> </h1>
    @if($tipo == 1)
        <h5>La fecha limite es <b>{{$limite}}</b>, faltan {{$diferencia}} días para que se cierre la evaluación.</h5>   
    @elseif($tipo == 2)
        <h5>La fecha limite es <b>{{$limite}}</b>, hoy es cierre la evaluación.</h5> 
    @else
        <h5>La fecha limite fue <b>{{$limite}}</b>.</h5> 
    @endif
@stop

@section('content')
    <p><b>TI (Identificación de talento)</b></p>
    <p>En AETH el desarrollo de nuestros colaboradores es muy importante, por ello la identificación de nuestro talento es un paso fundamental en este proceso pues nos ayudará a enfocar los esfuerzos hacia nuestra gente.</p>
    <p>Con el objetivo de realizar ejercicios de identificación de talento de este año, solicitamos tu participación para evaluar los siguientes aspectos:</p>
    <ul>
        <li>Comportamiento de nuestros pilares de cultura.</li>
        <li>Aspiraciones de carrera.</li>
        <li>Grupo de talento al que deben de pertenecer tus colaboradores basado en tu experiencia.</li>
    </ul>
    <p><b>Nuestros inversionistas:</b></p>
    <ul>
        <li>Prioridad: Impulsar el crecimiento rentable</li>
    </ul>
    <p><b>Nuestros clientes:</b></p>
    <ul>
        <li>Prioridad: Ofrecer una experiencia extraordinaria para nuestros clientes</li>
    </ul>
    <p><b>Nuestros colaboradores:</b></p>
    <ul>
        <li>Prioridad: Adoptar nuestros pilares culturales.</li>
        <li>KPIs: GPTW. Encuesta de cultura</li>
    </ul>
    <p><b>Nuestros comunidad:</b></p>
    <ul>
        <li>Prioridad: Construir reputación en nuestras comunidades a nivel nacional y regional</li>
    </ul>
    <p><b>Objetivo Organizacional {{$anio}}</b></p>
    <p>Impulsar el crecimiento rentable (EBITDA)</p>
    <p><b>Misión:</b></p>
    <p>Producir aceites especiales de origen vegetal, para satisfacer las necesidades especificas del mercado nacional e internacional, promoviendo el desarrollo de la agricultura nacional; cumpliendo las necesidades de nuestros colaboradores y otorgando rentabilidad a los accionistas.</p>
    <p><b>Visión:</b></p>
    <p>Ser la empresa lider en extracción de aceites especiales de origen vegetal y pastas proteicas, utilizando materia prima nacional e impulsando el campo agricola mexicano, logrando proporcionar al mercado los mejores productos en nuestro ramo, cumpliendo así las expectativas del cliente.</p>
    <p><b>Competencias organizacionales:</b></p>
    <p><b>1. Orientación al logro:</b></p>
    <p>Es la tendencia al logro de resultados, fijando en primer lugar, metas desafiantes por encima de los estándares, mejorando y manteniendo altos niveles de rendimiento, en el marco de las estrategias de la organización.</p>
    <p><b>2. Comunicación institucional:</b></p>
    <p>Capacidad para mejorar las relaciones tanto internas como externas, permitir el flujo de información por los canales pertinentes hacia todos los niveles de la organización y contribuir con la visibilidad de la institución.</p>
    <p><b>3. Impacto e influencia:</b></p>
    <p>Es el deseo de producir un impacto o efecto determinado sobre los demás. Ya sea persuadirlos, convencerlos, influir en ellos o impresionarlos, con el fin de lograr que ejecuten determinadas acciones.</p>
    <p><b>4. Actitud de servicio:</b></p>
    <p>Es la disposición que mostramos hacia ciertas situaciones, influye para realizar nuestras actividades y nos permite facilitar u obstaculizar nuestro camino.</p>
    <p><b>5. Trabajo en equipo:</b></p>
    <p>Capacidad de trabajar de forma integrada entre grupos y equipos de trabajo multidisciplinarios, a través de la cohesión de todos los recursos materiales y tecnológicos para conseguir  objetivos comunes a toda la organización, que tributen a una mayor generación de valor y por ende a un desempeño superior    </p>
    <p><b>6. Negociación:</b></p>
    <p>Es un proceso en el que varias partes interaccionan con el propósito de llegar a un acuerdo que implique la mejora en la gestión o la solución de un conflicto.</p>
    <p><b>7. Formación y aprendizaje:</b></p>
    <p>Es el conocimiento que no se limita a los años de educación formal, sino que por el contrario, plantea que el aprendizaje debe darse permanentemente de acuerdo a situaciones o eventos nuevos que generen experiencia.</p>
    <p><b>8. Innovación:</b></p>
    <p>Se considerara como la creación o el mejoramiento de procesos, productos y servicios para ser comercializados, satisfaciendo los gustos y necesidades de los clientes, y obteniendo beneficios empresariales, con la finalidad de alcanzar un valor agregado siendo competitivos e impactar en la sociedad.</p>
    <p><b>9. Orientación a la calidad:</b></p>
    <p>Disposición de la organización para generar soluciones con un enfoque al cliente y de calidad total, tanto para los procesos como para los productos, mediante la integración de los sistemas de gestión empresarial, la búsqueda permanente de la disminución de las no conformidades y la generación de valor.</p>
    <p><b>10. Foco en el consumidor y cliente:</b></p>
    <p>El enfoque consiste en satisfacer las necesidades de los clientes, incluyendo también las expectativas:
        <ul>
            <li>Conocer con exactitud, quiénes son nuestros clientes</li>
            <li>Verificar qué conocemos con claridad lo que el cliente necesita y desea</li>
            <li>Comprobar la satisfacción del cliente</li>
            <li>Conseguir que toda la organización conozca las necesidades y requerimientos del cliente.</li>
        </ul>     
    </p>
    <p><b>Con qué me comprometo:</b></p>
    <p>Con el apoyo de tu jefe inmediato, define al menos 4 objetivos de tu puesto, coloca la ponderación correspondiente (Tiene que sumar 100%) y asegúrate que se encuentren alineados a la estrategia del área.</p>
    <p><b>Este año tus objetivos son SIMple:</b></p>
    <ul>
        <li><b>(S)</b> Specific- Específicos- Responde a la pregunta <b>¿Qué, Cómo y Cuándo lo vas hacer?</b></li>
        <li><b>(I)</b>Important- Importante-Asegúrate que tus objetivos se encuentren alineados a los objetivos de tu jefe inmediato <b>¿Para qué?</b></li>
        <li><b>(M)</b>Measurable- Medibles- Es la manera en que sabrás si el objetivo se cumplió <b>¿Cómo lo vas a medir?</b></li>
    </ul>
    <p><b>Métrica de medición de evaluación del 1 al 4: </b></p>
    <ul>
        <li>1. No cumplió</li>
        <li>2. Cumplió algunos objetivos- Se realizará plan de mejora </li>
        <li>3. Cumplió los objetivos de su área y su equipo alcanzo objetivos y desarrollo personal- continua desarrollo de planes y proyectos</li>
        <li>4. Supero expectativas e implemento más proyectos de los establecidos</li>    
    </ul>    
         
    <p> </p>



    
    
    
@stop

@section('css')
    
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('message'))
     <script>
         msg = "<?php echo session('message'); ?>";
         myIcon = "<?php echo session('icon'); ?>";

         Swal.fire({
             icon: myIcon,
             title: msg
         });
     </script>
 @endif
@stop