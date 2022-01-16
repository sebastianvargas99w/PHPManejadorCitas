<?php
require_once (dirname(__FILE__)).'/../GestorCitas/Login/usuario-class.php';
class LoginTest extends  PHPUnit\Framework\TestCase
{
    protected $usuario;
    public function setUp(): void
    {
        $this->usuario = new Usuario();
        $this->usuario->crearUsuario("12345678","secretaria",3,"activo","password");
    }

    /** @test */
    public function loginCredencialesCorrectas()
    {
        $this->assertTrue( $this->usuario->revisarCredenciales("12345678","password"));
    }
    /** @test */
    public function loginCredencialesInCorrectas()
    {
        $this->assertFalse( $this->usuario->revisarCredenciales("12345678","passwordIncorrecta"));
    }
    /** @test */
    public function existeCedula()
    {
        $this->assertFalse( $this->usuario->existeUsuario("11111111"));
    }
    /** @test */
    public function usuarioBloqueadoconExito()
    {
        $this->usuario->bloquearUsuario("12345678");
        $this->assertFalse( $this->usuario->usuarioDesbloqueado("12345678"));
        $this->usuario->desbloquearUsuario("12345678");
    }
    /** @test */
    public function usuarioBloqueadoHaceLogin()
    {
        $this->usuario->bloquearUsuario("12345678");
        $this->assertFalse( $this->usuario->permisoIngresar("12345678","password"));
       
    }

    /** @test */
    public function usuarioDesbloqueadoHaceLogin()
    {
        $this->usuario->bloquearUsuario("12345678");
        $this->usuario->desbloquearUsuario("12345678");
        $this->assertTrue( $this->usuario->permisoIngresar("12345678","password"));
    }

    public function tearDown(): void
    {
        $this->usuario->eliminarUsuario("12345678");
    }
}
?>