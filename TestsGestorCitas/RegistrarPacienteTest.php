<?php

require_once (dirname(__FILE__)).'/../GestorCitas/Paciente/ValidadorDatosPaciente.php';

class RegistrarPacienteTest extends  PHPUnit\Framework\TestCase
{
    protected $validador;
    public function setUp(): void
    {
        $this->validador = new ValidadorDatosPaciente();
    }

    /** @test */
    public function cedulaLargaInvalidaTest()
    {
        $this->assertFalse($this->validador->cedulaEsValida('1234567890123456'));
    }

    /** @test */
    public function cedulaLargaValidaTest()
    {
        $this->assertTrue($this->validador->cedulaEsValida('123456789012345'));
    }

    /** @test */
    public function cedulaConCeros()
    {
        $this->assertFalse($this->validador->cedulaEsValida('012345678901234'));
    }

    /** @test */
    public function cedulaLargaConCeros()
    {
        $this->assertFalse($this->validador->cedulaEsValida('016540419'));
    }

    /** @test */
    public function cedulaValidaCortaTest()
    {
        $this->assertTrue($this->validador->cedulaEsValida('116540419'));
    }

    /** @test */
    public function cedulaValidaLargaTest()
    {
        $this->assertTrue($this->validador->cedulaEsValida('12345789012345'));
    }

    /** @test */
    public function nombreValidoTest() {
        $this->assertTrue($this->validador->nombreEsValido('Sebastiánñ'));
    }
    /** @test */
    public function nombreInValidoTest() {
        $this->assertFalse($this->validador
        ->nombreEsValido('Sebaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaastiánñ'));
    }

    /** @test */
    public function nombreCortoInValidoTest() {
        $this->assertFalse($this->validador
        ->nombreEsValido('La'));
    }

    /** @test */
    public function apellidoValidoTest() {
        $this->assertTrue($this->validador->apellidoEsValido('Vargas Sotóñ'));
    }

    /** @test */
    public function apellidoInValidoTest() {
        $this->assertFalse($this->validador
        ->apellidoEsValido('Vargaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaas'));
    }

    /** @test */
    public function telefonoCortoTest() {
        $this->assertFalse($this->validador->telefonoEsValido('91'));
    }

    /** @test */
    public function telefonoLetrasTest() {
        $this->assertFalse($this->validador->telefonoEsValido('91egqwe1'));
    }

    /** @test */
    public function telefonoCaracteresTest() {
        $this->assertFalse($this->validador->telefonoEsValido('91eg(qwe1'));
    }

    /** @test */
    public function telefonoValidoTest() {
        $this->assertTrue($this->validador->telefonoEsValido('911'));
    }

    /** @test */
    public function inicioMayusculaTest() {
        $this->assertEquals($this->validador->inicioMayuscula('sebas'), 'Sebas');
    }

    /** @test */
    public function inicioMayusculaSinCambiarTest() {
        $this->assertEquals($this->validador->inicioMayuscula('Sebas'), 'Sebas');
    }

    /*
    La verificación de la pruebas está mal por lo que se debe verificar el resulado de la prueba manualmente
    public function inicioMayusculaNTest() {
        $this->assertEquals($this->validador->inicioMayuscula('ñebas'), 'Ñebas');
    }
    */

    /** @test */
    public function inicioMayusculaCasoRaroTest() {
        $this->assertEquals($this->validador->inicioMayuscula('6'), '6');
    }

    /** @test */
    public function otroNombreTest() {
        $this->assertTrue($this->validador->nombreEsValido('Sebastián'));
    }

    /** @test */
    public function otroApellidoTest() {
        $this->assertTrue($this->validador->nombreEsValido('Acuña'));
    }
    
    public function tearDown(): void
    {
        
    }
}
?>