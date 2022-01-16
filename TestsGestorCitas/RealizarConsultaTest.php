<?php
require_once (dirname(__FILE__)).'/../GestorCitas/Citas/cita-class.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Citas/profesional-class.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Login/usuario-class.php';
class RealizarConsultaTest extends  PHPUnit\Framework\TestCase
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
        $this->citas->crearPaciente("101120111","Lucas","Perez Oso","88888888");
        $this->profesional->agregarProfesional($this->usuario->obtenerId(12345658),"Luke");
        $this->citas->crearCita("17/11/21",$this->usuario->obtenerId(12345658),"101110111");
        $this->citas->crearCita("02/11/21",$this->usuario->obtenerId(12345658),"101110111");
        $this->citas->crearCita("15/11/21",$this->usuario->obtenerId(12345658),"101120111");
    }


    /** @test */
    public function buscarCitasConCedulaYProfesional()
    {
        $this->assertCount(2, $this->citas->buscaCitasCedula("101110111",$this->usuario->obtenerId(12345658)));
    }
    
    /** @test */
    public function buscarCitasSinCedulaYProfesional()
    {
        $this->assertCount(3, $this->citas->buscaCitasCedula("",$this->usuario->obtenerId(12345658)));
    }

    /** @test */
    public function existeCedulaCliente()
    {
        $this->assertTrue( $this->citas->pacienteExiste("101110111"));
    }

    /** @test */
    public function retornaTodosLosProfesionales()
    {
        $this->assertTrue($this->profesional->obtenerProfesionales() >= 1);
    }


    public function tearDown(): void
    {
        $this->citas->eliminarCita("101110111", $this->usuario->obtenerId(12345658));
        $this->citas->eliminarCita("101120111", $this->usuario->obtenerId(12345658));
        $this->profesional->eliminarProfesional($this->usuario->obtenerId(12345658));
        $this->usuario->eliminarUsuario("12345658");
        $this->usuario->eliminarUsuario("123456897");
        $this->citas->eliminarPaciente("101110111");
    }
}
?>