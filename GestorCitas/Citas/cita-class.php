<?php
require_once (dirname(__FILE__)).'/../login/connect.php';

class Cita {
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
    Esta función se utiliza para que los desarrollador creen citas
    */
    function crearCita($fecha,$idProfesional,$cedula  ) {

        $sql = "INSERT INTO citas (fecha,idProfesional,cedulaPaciente) VALUES ('{$fecha}','{$idProfesional}','{$cedula}');";
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if (mysqli_query($this->conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
        
    }

    /**
     * Registrar pacientes se usa en:
     * -registrar citas 
     * -pruebas de registrar citas
     * -controlador de registrar paciente
     */
    function crearPaciente($cedula,$nombre,$apellidos, $telefono  ) {

      $sql = "INSERT INTO  Paciente(cedula, nombre, apellidos, telefono)
      VALUES ('{$cedula}','{$nombre}','{$apellidos}', {$telefono});";
      if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
      }
      if (mysqli_query($this->conn, $sql)) {
          echo "New record created successfully";
      } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
      }
  }

    //todo:documentar
    function verificarFechaCita($fecha) {
        $sql = "SELECT fecha FROM citas WHERE fecha = '{$fecha}';";
        $resultado = mysqli_query($this->conn, $sql);
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        
        $data = 0;
        while ($fila = mysqli_fetch_row($resultado)) {
          $data = $fila[0];
        }
        //echo ($fecha), "\n";
        //echo ($data), "\n";
        if($data === $fecha){//fecha duplicada
            //echo ("Fechas iguales"), "\n";
          return false;
        }else{
            return true;
        }
    }

    /**
     * @codeCoverageIgnore
     */
    function eliminarPaciente($cedula){
      $sql = "DELETE FROM Paciente WHERE cedula = '{$cedula}';";
      if (mysqli_query($this->conn, $sql)) {
        echo "New record created successfully";
        return true;
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
      }
      return false;
    }

    /**
     * @codeCoverageIgnore
     */
    function eliminarCita($cedulaPaciente, $idProfesional){
      $sql = "DELETE FROM Citas WHERE cedulaPaciente = '{$cedulaPaciente}' and
                                      idProfesional = '{$idProfesional}';";
      if (mysqli_query($this->conn, $sql)) {
        echo "New record created successfully";
        return true;
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
      }
      return false;
    }

    function verificarFechaCitaFutura($fecha) {
        
        $data = date("Y-m-d h:i");
        
        echo ($fecha), "\n";
        echo ($data), "\n";
        if($data < $fecha){//fecha duplicada
            echo ("Hora posible"), "\n";
          return true;
        }else{
            echo ("Hora en el pasado"), "\n";
            return false;
        }
    }

    function profesionalExiste($id) {
      $sql = "SELECT id FROM profesional WHERE id = '{$id}';";
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
        }else{
            return false;
        }
    }

    function pacienteExiste($cedula) {
      $sql = "SELECT cedula FROM paciente WHERE cedula = '{$cedula}';";
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
        }else{
            return false;
        }
    }
    /*
      Esta función retorna un array con las citas que coincidan con la cedula, si
      el campo cedula esta vacio retorna todas las citas.
    */ 
    function buscaCitasCedula($cedula,$idProfesional, $fechaInicio='', $fechaFinal='') {
      
      if($cedula != ""){
        if($this->pacienteExiste($cedula)){
          $sql = "SELECT * FROM Citas WHERE cedulaPaciente = '{$cedula}' and idProfesional ='{$idProfesional}' ";
        }else{
          return false;
        }
      }else{
        $sql = "SELECT * FROM Citas WHERE idProfesional ='{$idProfesional}' ";
      }

      $fecha='';
      if($fechaInicio != "" && $fechaFinal != "" ){
        $fecha=" AND  fecha between  '{$fechaInicio}' AND  '{$fechaFinal}' ";
        $sql=$sql.$fecha;
      }else{
        if($fechaInicio == "" && $fechaFinal !=""){
          $fecha=" AND fecha <= '{$fechaFinal}'";
          $sql=$sql.$fecha;

        }else{
            if($fechaInicio != "" && $fechaFinal ==""){
              $fecha=" AND fecha >= '{$fechaInicio}'";
              $sql=$sql.$fecha;
            }
        }
      }


      $sql=$sql.';';
      $resultado = mysqli_query($this->conn, $sql);
      if (!$this->conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      $citas = array();
      while ($row = mysqli_fetch_row($resultado)) {
        $fechaHora = explode(" ", $row[1]);
        $citas[] = array(
          'id' => $row[0],
          'fecha' => $fechaHora[0],
          'hora' =>  $fechaHora[1],
          'idProfesional' => $row[2],
          'cedulaPaciente' => $row[3],
        );
      }
      return $citas;
    }

}
?>
