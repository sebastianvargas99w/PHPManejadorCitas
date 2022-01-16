<?php
require_once (dirname(__FILE__)).'/../login/connect.php';
class Profesional {
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
    Esta función se utiliza para que los desarrollador creen profesionales
    */
	/**
	* @codeCoverageIgnore
	*/
    function agregarProfesional($id,$nombre) {
      if(!$this->existeProfesional($id)) {
        $sql = "INSERT INTO Profesional (id,nombre) VALUES ('{$id}','{$nombre}');";
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if (mysqli_query($this->conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
      }else{
        echo "Error: Profesional ya existe";
      }
    }



    /*
    Devuelve el nombre del profesional con el id ingresado
    */
    function obtenerNombre($id) {
      if($this->existeProfesional($id)){
        $sql = "SELECT nombre FROM Profesional WHERE id = '{$id}';";
        $resultado = mysqli_query($this->conn, $sql);
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        $data = "";
        while ($fila = mysqli_fetch_row($resultado)) {
          $data = $fila[0];
        }
        return $data;
      }
    }

    /*
    Verifica si ya exite un profesional con el id ingresado.
     */
    function existeProfesional($id){
        $sql = "SELECT id FROM Profesional WHERE id = '{$id}';";
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

      
    /*
    función de desarrollador para eliminar un cédula
     */
	/**
	* @codeCoverageIgnore
	*/
    function eliminarProfesional($id){
      if($this->existeProfesional($id)){
        $sql = "DELETE FROM Profesional WHERE id = '{$id}';";
        if (mysqli_query($this->conn, $sql)) {
          echo "New record created successfully";
          return true;
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
      }
      return false;
    }

    function obtenerProfesionales(){
      $sql = "SELECT * FROM Profesional ;";
      $resultado = mysqli_query($this->conn, $sql);
      if (!$this->conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      $profesionales = array();
      while ($row = mysqli_fetch_row($resultado)) {
        $profesionales[] = array(
          'id' => $row[0],
          'nombre' => $row[1],
        );
      }
      return $profesionales;
    }    
}
?>
