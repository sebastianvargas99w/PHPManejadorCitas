<?php
require_once (dirname(__FILE__)).'/../GestorCitas/Citas/cita-class.php';
class RegistrarCitaTest extends  PHPUnit\Framework\TestCase
{
    protected $cita;
    public function setUp(): void
    {
        $this->cita = new Cita();
        $this->cita->crearPaciente("116900860","Juan","Vainas", "88888888"); //$cedula,$nombre,$apellidos, $telefono
        $this->cita->crearCita("2025-11-18 13:31",1,"116900860");
    }

    /** @test */
    public function nuevaCitaEnFechaYHoraReservada()
    {
        $this->assertFalse( $this->cita->verificarFechaCita("2025-11-18 13:31:00"));
    }

    /** @test */
    public function nuevaCitaEnFechaYHoraLibre()
    {
        $this->assertTrue( $this->cita->verificarFechaCita("2025-11-18 13:32:00"));
    }

    /** @test */
    public function nuevaCitaEnFechaYHoraEnElPasado()
    {
        $this->assertfalse( $this->cita->verificarFechaCitaFutura("2020-11-18 13:32:00"));
    }

    /** @test */
    public function nuevaCitaEnFechaYHoraEnFechaProxima()
    {
        $this->assertTrue( $this->cita->verificarFechaCitaFutura("2025-11-18 13:32:00"));
    }

    /** @test */
    public function nuevaCitaConCedulaPacienteExistente()
    {
        $this->assertTrue( $this->cita->pacienteExiste("116900860"));
    }

    /** @test */
    public function nuevaCitaConCedulaPacienteNueva()
    {
        $this->assertFalse( $this->cita->pacienteExiste("1111111111"));
    }

    /** @test */
    public function nuevaCitaConIdProfesionalValido()
    {
        $this->assertTrue( $this->cita->profesionalExiste(1));
    }

    /** @test */
    public function nuevaCitaConIdProfesionaInvalido()
    {
        $this->assertFalse( $this->cita->profesionalExiste(0));
    }

    public function tearDown(): void
    {
        $this->cita->eliminarPaciente("116900860");
    }
}
?>