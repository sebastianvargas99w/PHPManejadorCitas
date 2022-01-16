<?php
require_once (dirname(__FILE__)).'/../GestorCitas/Paciente/controlador-registrar-paciente.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Citas/cita-class.php';
session_start();
class cajaBlancaRegistrarPacienteTest extends  PHPUnit\Framework\TestCase
{
    protected $citas;
    public function setUp(): void
    {
      $this->citas = new Cita();
      $this->citas->crearPaciente("401110111","Lourdes","Perez","88888888");
    }

    public function llenarPost($nombre, $apellido, $telefono, $cedula){
      $_POST = array('nombre' => $nombre, 
      'apellido' => $apellido,
      'telefono' => $telefono,
      'cedula' => $cedula);
    }
   
    /** @test */
    public function cedulaEsInvalidaPrueba()
    {
      $this->llenarPost("Luis","Martinez", "88888888","001011101");
      ControladorRegistrarPaciente();
      $this->assertTrue($_SESSION["mensajePaciente"] === 'La cédula ingresada no es válida.');
    }

    /** @test */
    public function nombreEsInvalidoPrueba()
    {
      $this->llenarPost("Ju","Martinez", "88888888","303330333");
      ControladorRegistrarPaciente();
      $this->assertTrue($_SESSION["mensajePaciente"] === 'El nombre ingresado no es válido');
    }

    /** @test */
    public function apellidoEsInvalidoPrueba()
    {
      $this->llenarPost("Juan","Ma", "88888888","303330333");
      ControladorRegistrarPaciente();
      $this->assertTrue($_SESSION["mensajePaciente"] === 'El apellido ingresado no es válido');
    }

    /** @test */
    public function telefonoEsInvalidoPrueba()
    {
      $this->llenarPost("Juan","Martinez", "88","303330333");
      ControladorRegistrarPaciente();
      $this->assertTrue($_SESSION["mensajePaciente"] === 'El telefono ingresado no es válido');
    }

    /** @test */
    public function PacienteYaExistePrueba()
    {
      $this->llenarPost("Lourdes","Perez", "88888888","401110111");
      ControladorRegistrarPaciente();
      $this->assertTrue($_SESSION["mensajePaciente"] === 'El paciente ya está registrado.');
    }

    /** @test */
    public function PacienteCreadoExitosamente()
    {
      $this->llenarPost("Juan","Martinez", "88888888","303330333");
      ControladorRegistrarPaciente();
      $this->assertTrue($_SESSION["mensajePaciente"] === '¡El Paciente fue registrado exitosamente!');
    }
    

    public function tearDown(): void
    {
        $this->citas->eliminarPaciente("401110111");
        $this->citas->eliminarPaciente("303330333");
    }
}
?>