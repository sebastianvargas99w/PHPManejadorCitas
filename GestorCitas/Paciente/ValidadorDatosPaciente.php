<?php
    class ValidadorDatosPaciente {
        // @codeCoverageIgnoreStart
        function __construct() {
          }

        function __destruct() {
        }
        // @codeCoverageIgnoreEnd

        function cedulaEsValida(string $cedula) {
            $esValido = null;
            $patron = '/^[1-9]{1}+([0-9]){8,14}$/';
            if(preg_match_all($patron, $cedula) === 1) {
                $esValido = true;
            }
            else {
                $esValido = false;
            }
            return  $esValido;
        }

        function nombreEsValido(string $nombre) {
            $len = strlen($nombre);
            $esValido = null;
            if($len >= 3 && $len <= 30) {
                $esValido = true;
            }
            else {
                $esValido = false;
            }
            return $esValido;
        }

        function apellidoEsValido(string $apellido) {
            $len = strlen($apellido);
            $esValido = null;
            if($len >= 3 && $len <= 50) {
                $esValido = true;
            }
            else {
                $esValido = false;
            }
            return $esValido;
        }

        function telefonoEsValido(string $telefono) {
            $esValido = null;
            $patron = '/[0-9]{3,30}/';
            if(preg_match_all($patron, $telefono) === 1) {
                $esValido = true;
            }
            else {
                $esValido = false;
            }
            return  $esValido;
        }

        function inicioMayuscula(string $palabra) {
            $primeraLetra = mb_strtoupper(mb_substr($palabra, 0, 1, 'UTF-8'),  'UTF-8');
            $nuevaPalabra = substr_replace($palabra, $primeraLetra, 0, 1);
            return  $nuevaPalabra;
        } 

    }
?>