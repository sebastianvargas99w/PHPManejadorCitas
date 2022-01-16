<?php
require_once (dirname(__FILE__)).'/../login/connect.php';
class Paciente {
    public $conn;
    /*
    Constructor de la clase que inicia la conexion
     */
    function __construct(){
      $conector = new Connect();
      $this->conn = $conector->connectar();
    }

    /*
    Destructor de la clase que inicia la conexión
     */
    function __destruct(){
      $this->conn -> close();
    }

    /*
    Devuelve el nombre del paciente con la cedula ingresada
    */
    function obtenerNombre($cedula) {
      if($this->existePaciente($cedula)){
        $sql = "SELECT nombre FROM Paciente WHERE cedula = '{$cedula}';";
        $resultado = mysqli_query($this->conn, $sql);
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        $data = 0;
        while ($fila = mysqli_fetch_row($resultado)) {
          $data = $fila[0];
        }
        return $data;
      }
    }

    /*
    Devuelve el número de telefono del paciente con la cedula ingresada
    */
    function obtenerTelefono($cedula) {
        if($this->existePaciente($cedula)){
          $sql = "SELECT telefono FROM Paciente WHERE cedula = '{$cedula}';";
          $resultado = mysqli_query($this->conn, $sql);
          if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
          }
          $data = 0;
          while ($fila = mysqli_fetch_row($resultado)) {
            $data = $fila[0];
          }
          return $data;
        }
      }

    /*
    Verifica si ya existe un paciente con la cédula ingresada.
     */
    function existePaciente($cedula){
        $sql = "SELECT cedula FROM Paciente WHERE cedula = '{$cedula}';";
        $resultado = mysqli_query($this->conn, $sql);
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        $data = 0;
        while ($fila = mysqli_fetch_row($resultado)) {
          $data = $fila[0];
        }
        if($data){
          return true;
        }
        return false;
      }
  
  
}
?>
