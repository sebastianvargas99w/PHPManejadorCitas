<?php
require_once (dirname(__FILE__)).'/../GestorCitas/Citas/cita-function.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Citas/profesional-class.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Login/usuario-class.php';
session_start();
class cajaBlancaRegistrarCitaTest extends  PHPUnit\Framework\TestCase
{
    protected $citas;
    protected $profesional;
    protected $usuario;
    public function setUp(): void
    {
        $this->citas = new Cita();
        $this->profesional = new Profesional();
        $this->usuario = new Usuario();
        $this->usuario->crearUsuario("12345658","profesional",5,"activo","password");
        $this->citas->crearPaciente("101110111","Juan","Perez Oso","88888888");
        $this->profesional->agregarProfesional($this->usuario->obtenerId(12345658),"Luke");
        $this->citas->crearCita("2032-11-25 14:14:00", $this->usuario->obtenerId(12345658),"101110111");

    }

    public function llenarPost($horaCita, $fechaCita, $idProfesional, $cedula){

        $_POST = array('hora_cita' => $horaCita, 
        'fecha_cita' => $fechaCita,
        'idProfesional' => $idProfesional,
        'cedula' => $cedula);
    }
   
    /** @test */
    public function pacienteNoExistePrueba()
    {
        //2021-11-25 13:14:0013:14
        $this->llenarPost("13:14","2030-11-25", $this->usuario->obtenerId(12345658),"101110333");
        controladorRegistrarCita();
        $this->assertTrue($_SESSION["mensaje"] === 2);
    }

    /** @test */
    public function profesionalNoExistePrueba()
    {
        $this->llenarPost("13:14","2030-11-25", $this->usuario->obtenerId(12345060),"101110111");
        controladorRegistrarCita();
        $this->assertTrue($_SESSION["mensaje"] === 3);
    }

    /** @test */
    public function fechaNoFutura()
    {
        $this->llenarPost("13:14","2000-11-25", $this->usuario->obtenerId(12345658),"101110111");
        controladorRegistrarCita();
        $this->assertTrue($_SESSION["mensaje"] === 4);      
    }

    /*
    Corresponde al if 
        if(!$nuevaCita->verificarFechaCita($fecha)){
            $_SESSION["mensaje"] = 5; //Se esta intentando programar cita en una fecha ya reservada
        }
     */
    /** @test */
    public function hayTraslape()
    {
        $this->llenarPost("14:14","2032-11-25",$this->usuario->obtenerId(12345658),"101110111");
        controladorRegistrarCita();
        $this->assertTrue($_SESSION["mensaje"] === 5);
    }

    /** @test */
    public function citaCreadaExitosamente()
    {
        $this->llenarPost("14:14","2024-11-25",$this->usuario->obtenerId(12345658),"101110111");
        controladorRegistrarCita();
        $this->assertTrue($_SESSION["mensaje"] === 1);
    }

    public function tearDown(): void
    {
        $this->citas->eliminarCita("101110111", $this->usuario->obtenerId(12345658));
        $this->profesional->eliminarProfesional($this->usuario->obtenerId(12345658));
        $this->usuario->eliminarUsuario("12345658");
        $this->citas->eliminarPaciente("101110111");
    }
}
?>