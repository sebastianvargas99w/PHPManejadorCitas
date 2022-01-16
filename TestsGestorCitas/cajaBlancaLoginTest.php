<?php
require_once (dirname(__FILE__)).'/../GestorCitas/Login/login-function.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Login/Login.php';
require_once (dirname(__FILE__)).'/../GestorCitas/Login/usuario-class.php';
session_start();

class cajaBlancaLoginTest extends  PHPUnit\Framework\TestCase
{
    protected $cedula;
    protected $contrasena;
    public function setUp(): void
    {
        $this->usuarioActivo = new Usuario();
        $this->usuarioBloqueado = new Usuario();

        $this->usuarioActivo->crearUsuario("122222222","profesional",5,"activo","password");
        $this->usuarioBloqueado->crearUsuario("133333333", "profesional", 0, "bloqueado", "password");

    }

    public function llenarPost($cedulaParam, $contrasenaParam){

        $_POST = array("cedula" => $cedulaParam, 
        "contrasena" => $contrasenaParam);
    }

    /** @test */
    public function loginExitosoTest()
    {
        $cedula = '122222222';
        $contrasena = 'password';
        $this->llenarPost($cedula, $contrasena);
        controladorLogin();
        $resultado = $_SESSION["logeo"];
        $this->assertEquals(1, $resultado);
    }   

    /** @test */
    public function loginIncorrectoTest()
    {
        $cedula = '122222222';
        $contrasena = 'incorrect_password';
        $this->llenarPost($cedula, $contrasena);
        controladorLogin();
        $resultado = $_SESSION["logeo"];
        $this->assertEquals(2, $resultado);
    }   

    /** @test */
    public function loginBloqueadoTest()
    {
        $cedula = '133333333';
        $contrasena = 'password';
        $this->llenarPost($cedula, $contrasena);
        controladorLogin();
        $resultado = $_SESSION["logeo"];
        $this->assertEquals(3, $resultado);
    }   

    public function tearDown(): void
    {
        $this->usuarioActivo->eliminarUsuario("122222222");
        $this->usuarioBloqueado->eliminarUsuario("133333333");
        
    }
}
?>