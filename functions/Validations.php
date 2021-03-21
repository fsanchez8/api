<?php 

    namespace Fx;
    use Fx\Functions;
    
    class Validations {

        /**
         * Función para validar un usuario 
         * @access public 
         * @param string
         * @return true | @return Object
         */
        public function validar_usuario(string $usuario){
            $min = strlen( $usuario);
            $max = strlen( $usuario);

            if($min < 5 ){
                return Functions::error_response("¡El nombre de usuario ( $usuario ) debe tener como mínimo 5 caracteres!", 200);
            }

            if($max > 15 ){
                return Functions::error_response("¡El nombre de usuario ( $usuario ) debe tener como máximo 15 caracteres!", 200);
            }

            if (!preg_match('`[a-z]`',$usuario)){
                return Functions::error_response("¡El nombre de usuario ( $usuario ) debe tener como mínimo una minuscula!", 200);
            }

            if (!preg_match('`[A-Z]`', $usuario)){
                return Functions::error_response("¡El nombre de usuario ( $usuario ) debe tener como mínimo una mayuscula!", 200);
            }
            
            if (preg_match('`[0-9]`', $usuario)){
                return Functions::error_response("¡El nombre de usuario ( $usuario ) No debe tener números!", 200);
            }

            if (preg_match('`[!@#$&*.<>¡,]`', $usuario)){
                return Functions::error_response("¡El nombre de usuario ( $usuario ) No debe tener caracteres especiales !", 200);
            }

            return true;
        }


        /**
         * Función para validar que la contraseña cumpla con los parametros establecidos en la regla de negocio
         * @access public 
         * @param string
         * @return Object | @return bolean
         */
        public function validar_pass(string $contrasena){
            $min = strlen($contrasena);
            $max = strlen($contrasena);

            if( $min  < 5 ){
                return Functions::error_response("¡La contraseña de usuario ( $contrasena ) debe tener como mínimo 5 caracteres!", 200);
            }
            
            if( $max > 15 ){
                return Functions::error_response("¡La contraseña de usuario ( $contrasena ) debe tener como máximo 15 caracteres!", 200);
            }

            if (!preg_match('`[a-z]`',$contrasena)){
                return Functions::error_response("¡La contraseña de usuario ( $contrasena ) debe tener como mínimo una minuscula!", 200);
            }

            if (!preg_match('`[A-Z]`', $contrasena)){
                return Functions::error_response("¡La contraseña de usuario ( $contrasena ) debe tener como mínimo una mayuscula!", 200);
            }

            if (!preg_match('`[0-9]`', $contrasena)){
                return Functions::error_response("¡La contraseña de usuario ( $contrasena ) debe tener como mínimo un número!", 200);
            }

            if (!preg_match('`[!@#$&*.<>¡]`', $contrasena)){
                return Functions::error_response("¡La contraseña de usuario ( $contrasena ) debe tener como mínimo un caracter especial !", 200);
            }

            return true;
        }
        
        /**
         * Función para validar que  sea un correo electronico válido
         * @access public 
         * @param string
         * @return Object | @return true
         */
        public  function validar_email(string $email){
            if(!preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email)){
                return Functions::error_response("¡El formato del correo ( $email ) no es valido !", 200);
                die();
            }
            return true;
        }

    }
