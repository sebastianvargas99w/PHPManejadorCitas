<?php
/*
include_once (dirname(__FILE__)).'/../GestorCitas/Citas/cita-class.php';
include_once (dirname(__FILE__)).'/../GestorCitas/Citas/profesional-class.php';
include_once (dirname(__FILE__)).'/../GestorCitas/Citas/paciente-class.php';
*/

require_once (dirname(__FILE__)).'/../GestorCitas/Citas/consultar-citas-function.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Citas/profesional-class.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Login/usuario-class.php';




session_start();

class cajaBlancaConsultarCitasTest extends  PHPUnit\Framework\TestCase
{
    protected $cedula;
    protected $idProfesional;
    protected $usuario;
    public function setUp(): void
    {
        $this->citas = new Cita();
        $this->profesional = new Profesional();
        $this->usuario = new Usuario();


        /*Primer set de datos */
        $this->usuario->crearUsuario("123456580","profesional",5,"activo","password");
        $this->citas->crearPaciente("1011101110","Juan","Perez Oso","888888880");
        $this->profesional->agregarProfesional($this->usuario->obtenerId(123456580),"Luke");
        $this->citas->crearCita("2032-11-25 14:14:00", $this->usuario->obtenerId(123456580),"1011101110");

        /*Segundo set de datos*/
        $this->usuario->crearUsuario("1414141410","profesional",5,"activo","password");
        $this->citas->crearPaciente("1515151515","Maria","Perez Oso","888888880");
        $this->profesional->agregarProfesional($this->usuario->obtenerId(1414141410),"Ian");
        $this->citas->crearCita("2032-11-25 14:14:00", $this->usuario->obtenerId(1414141410),"1515151515");
        $this->citas->crearCita("2031-11-25 14:14:00", $this->usuario->obtenerId(1414141410),"1515151515");

        /*Tercer de datos */
        $this->usuario->crearUsuario("1234123400","profesional",5,"activo","password");
        $this->profesional->agregarProfesional($this->usuario->obtenerId(1234123400),"Marlen");

    }

    //todo llenar fecha inicial y fecha inicial para pruebas de citas por rango de tiempo
    public function llenarPost($cedulaParam, $idProfesionalparam, $fechaInicial, $FechaFinal){

        $_POST = array('idProfesional' => $idProfesionalparam, 
        'cedula' => $cedulaParam,
        'fechaInicio' => $fechaInicial,
        'fechaFinal' => $FechaFinal
        );
    }


    /**
    * Sección de prueba para el consultar citas por rango de fecha
    */

    /** @test */
    public function consultarCitasPorRangoFechasTest()
    {
     
        $cedulaPaciente = '';
        $idProfesional = $this->usuario->obtenerId(1414141410);
        $fechaInicial = '2020-11-25 14:14:00';
        $FechaFinal = '2040-11-25 14:14:00';
        $nombreProfesional = 'Ian';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) >= 2);
        
    }

    /** @test */
    public function rangoDeFechaInvalidoaTest()
    {
        $cedulaPaciente = '1515151515';
        $idProfesional = $this->usuario->obtenerId(1414141410);
        $fechaInicial = '2040-11-25 14:14:00';
        $FechaFinal = '2020-11-25 14:14:00';
        $nombreProfesional = 'Ian';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) == 0);
        
    }

    /** @test */
    public function diaMayorFechaInvalida()
    {
        $cedulaPaciente = '1515151515';
        $idProfesional = $this->usuario->obtenerId(1414141410);
        $fechaInicial = '2032-11-26 14:14:00';
        $FechaFinal = '2032-11-25 14:14:00';
        $nombreProfesional = 'Ian';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) == 0);
        
    }   

    /** @test */
    public function mesMayorFechaInvalidaTest()
    {
        $cedulaPaciente = '1515151515';
        $idProfesional = $this->usuario->obtenerId(1414141410);
        $fechaInicial = '2032-12-25 14:14:00';
        $FechaFinal = '2032-11-25 14:14:00';
        $nombreProfesional = 'Ian';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) == 0);
        
    }
    
    /** @test */
    public function fechaIgualACitaTest()
    {
        $cedulaPaciente = '1515151515';
        $idProfesional = $this->usuario->obtenerId(1414141410);
        $fechaInicial = '2032-11-25 14:14:00';
        $FechaFinal = '2032-11-25 14:14:00';
        $nombreProfesional = 'Ian';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) == 1);
        
    }


    /**
     * Seccion de pruebas para el consultar citas por nombre de profesional
     */

    /** @test */
    public function consultarProfesionalVariasCitasTest()
    {
     
        $cedulaPaciente = '1515151515';
        $idProfesional = $this->usuario->obtenerId(1414141410);
        $fechaInicial = '2030-11-25 14:14:00';
        $FechaFinal = '2033-11-25 14:14:00';
        $nombreProfesional = 'Ian';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) >= 2);
        
    }   

    /** @test */
    public function consultarProfesionalUnaCitaTest()
    {  
        $cedulaPaciente = '1011101110';
        $idProfesional = $this->usuario->obtenerId(123456580);
        $fechaInicial = '2030-11-25 14:14:00';
        $FechaFinal = '2033-11-25 14:14:00';
        $nombreProfesional = 'Luke';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) == 1);   
    }  

    /** @test */
    public function consultarProfesionalSinCitaTest()
    {
        $cedulaPaciente = '';
        $idProfesional = $this->usuario->obtenerId(1234123400);
        $fechaInicial = '';
        $FechaFinal = '';
        $nombreProfesional = 'Marlen';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) == 0);
    }


    /** @test */
    public function consultarProfesionalUnacitaSinCedulaPacienteTest()
    {
        $cedulaPaciente = '';
        $idProfesional = $this->usuario->obtenerId(123456580);
        $fechaInicial = '';
        $FechaFinal = '';
        $nombreProfesional = 'Luke';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) == 1);
    }

    /** @test */
    public function consultarProfesionalUnacitaConCedulaPacienteTest()
    {
        $cedulaPaciente = '1011101110';
        $idProfesional = $this->usuario->obtenerId(123456580);
        $fechaInicial = '';
        $FechaFinal = '';
        $nombreProfesional = 'Luke';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) == 1);
    }

    /** @test */
    public function consultarProfesionalVariascitasSinCedulaPacienteTest()
    {
        $cedulaPaciente = '';
        $idProfesional = $this->usuario->obtenerId(1414141410);
        $fechaInicial = '';
        $FechaFinal = '';
        $nombreProfesional = 'Ian';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) >= 2);
    }

    /** @test */
    public function consultarProfesionalVariascitasConCedulaPacienteTest()
    {
        $cedulaPaciente = '1515151515';
        $idProfesional = $this->usuario->obtenerId(1414141410);
        $fechaInicial = '';
        $FechaFinal = '';
        $nombreProfesional = 'Ian';
        $this->llenarPost($cedulaPaciente, $idProfesional, $fechaInicial, $FechaFinal);
        $stringEsperado = $nombreProfesional;
        $resultado = controladorConsultarCitas();
        $this->assertTrue(substr_count($resultado, $nombreProfesional ) >= 2);
    }

    public function tearDown(): void
    {
        /* Se elimina el primer set de datos */
        
        $this->citas->eliminarCita("1011101110", $this->usuario->obtenerId(123456580));
        $this->profesional->eliminarProfesional($this->usuario->obtenerId(123456580));
        $this->usuario->eliminarUsuario("123456580");
        $this->citas->eliminarPaciente("1011101110");
        
        /* Se elimina el segundo set de datos */
        $this->citas->eliminarCita("1515151515", $this->usuario->obtenerId(1414141410));
        $this->profesional->eliminarProfesional($this->usuario->obtenerId(1414141410));
        $this->citas->eliminarPaciente("1515151515");
        $this->usuario->eliminarUsuario("1414141410");

        /*  Se elimina el tercer set de datos*/
        $this->profesional->eliminarProfesional($this->usuario->obtenerId(1234123400));
        $this->usuario->eliminarUsuario("1234123400");
        
    }
}
?>