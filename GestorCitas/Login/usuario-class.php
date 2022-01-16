<?php
include_once 'connect.php';
class Usuario {
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
    Esta función se utiliza para que los desarrollador creen usuarios
    */
    /**
    * @codeCoverageIgnore
    */
    function crearUsuario($cedula,$rol,$intentos,$estado,$clave) {
      if(!$this->existeUsuario($cedula)) {
        $password = password_hash($clave, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Usuario (cedula,rol,intentos,estado,clave) VALUES ('{$cedula}','{$rol}','{$intentos}','{$estado}','{$password}');";
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if (mysqli_query($this->conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
      }else{
        echo "Error: usuario ya existe";
      }
    }

    /*
    Verifica si ya exite un usuario con la cédula ingresada.
     */
    function existeUsuario($cedula){
      $sql = "SELECT cedula FROM Usuario WHERE cedula = '{$cedula}';";
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
    Consulta a la base de datos si los credenciales si el usuario ingresó correctamente las credenciales
    */
    function revisarCredenciales($cedula,$clave){
      if($this->existeUsuario($cedula)){
        $sql = "SELECT clave FROM Usuario WHERE cedula = '{$cedula}';";
        $resultado = mysqli_query($this->conn, $sql);
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        $data = 0;
        while ($fila = mysqli_fetch_row($resultado)) {
          $data = $fila[0];
        }

        if(password_verify($clave, $data)){
          return true;
        }
      }
      return false;
    }

    /*
    Bloquea un usuario para que no pueda ingresar al sistema, esta función se llama cuando
    el usuario falló la contraseña 5 veces e intenta ingresar una sexta vez.
     */
    function bloquearUsuario($cedula){
      if($this->existeUsuario($cedula)){
        $id = $this->obtenerId($cedula);
        $sql = "UPDATE Usuario SET estado='bloqueado' WHERE id = '{$id}';";
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        if (mysqli_query($this->conn, $sql)) {
          echo "New record created successfully";
          return true;
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
      }
      return false;
    }

    /*
    Esta función se utiliza por los desarrolladores para desbloquear un usuario de la base de datos
    To do: si se quiere utilizar esta función en producción es necesario realizar todas las consultas en 
    un procedimiento almacenada para asegurar la atomicidad
     */
	/**
	* @codeCoverageIgnore
	*/
    function desbloquearUsuario($cedula){
      if($this->existeUsuario($cedula)){
        $id = $this->obtenerId($cedula);
        $sql = "UPDATE Usuario SET estado='activo' WHERE id = '{$id}';";
        $sql2 = "UPDATE Usuario SET intentos='5' WHERE id = '{$id}';";
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        if (mysqli_query($this->conn, $sql)) {
          echo "New record created successfully";
          if (mysqli_query($this->conn, $sql2)) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql2 . "<br>" . mysqli_error($this->conn);
            return false;
          }
          return true;
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
      }
      return false;
    }

    /*
    Consulta si el usuario tiene permiso para ingresar al sistema.
     */
    function permisoIngresar($cedula,$clave){
      if($this->existeUsuario($cedula)){
        if($this->revisarCredenciales($cedula,$clave)){
          if($this->usuarioDesbloqueado($cedula)){
            return true;
          }
        }
      }
      return false;
    }
    /*Revisa si el usuario esta desbloqueado*/
    function usuarioDesbloqueado($cedula){
      if($this->existeUsuario($cedula)){
        $sql = "SELECT estado FROM Usuario WHERE cedula = '{$cedula}';";
        $resultado = mysqli_query($this->conn, $sql);
        if (!$this->conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        $data = 0;
        while ($fila = mysqli_fetch_row($resultado)) {
          $data = $fila[0];
        }
        if($data === "activo"){
          return true;
        }
      }
      return false;
    }

    /*
    función de desarrollador para eliminar un cédula
     */
	/**
	* @codeCoverageIgnore
	*/
    function eliminarUsuario($cedula){
      if($this->existeUsuario($cedula)){
        $id = $this->obtenerId($cedula);
        $sql = "DELETE FROM Usuario WHERE id = '{$id}';";
        if (mysqli_query($this->conn, $sql)) {
          echo "New record created successfully";
          return true;
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
      }
      return false;
    }

    /*
    Devuelve la cantidad de intentos que tiene un usuario
    */
    function obtenerIntentos($cedula) {
      if($this->existeUsuario($cedula)){
        $sql = "SELECT intentos FROM Usuario WHERE cedula = '{$cedula}';";
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
    Reduce la cantidad de intento que tiene un usuario para ingresar su contraseña, esta función
    se llama después de que el usuario de equivoca.
    */
    function reducirIntento($cedula){
      if($this->existeUsuario($cedula)){
        $intentos = $this->obtenerIntentos($cedula) - 1;
        if($intentos<0){
          $intentos = 0;
        }
        $id = $this->obtenerId($cedula);
        $sql = "UPDATE Usuario SET intentos={$intentos} WHERE id = '{$id}';";
        if (mysqli_query($this->conn, $sql)) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
        if($intentos == '0'){
          $this->bloquearUsuario($cedula);
        }
      }
    }

    /*
    Devuelve el id del usuario con una cédula
    */
    /**
     * @codeCoverageIgnore
     */
    function obtenerId($cedula){
      if($this->existeUsuario($cedula)){
        $sql = "SELECT id FROM Usuario WHERE cedula = '{$cedula}';";
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
    Reinicia la cantidad de intento (los vuelve a poner en 5), 
    esta función se llama cuando el usuario ingresa a su usuario.
    */
    function resetIntentos($cedula){
      if($this->existeUsuario($cedula)){
        $id = $this->obtenerId($cedula);
        $sql = "UPDATE Usuario SET intentos='5' WHERE id = '{$id}';";
        if (mysqli_query($this->conn, $sql)) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
        }
      }
    }
}
?>
