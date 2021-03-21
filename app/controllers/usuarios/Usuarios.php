<?php 

    namespace App\controllers\usuarios;
    use Fx\Functions;
    use Fx\Validations;
    use App\models\usuarios\UsuariosModel;
    
class Usuarios{

        /**
         * Función para validar el método correcto y el tipo de petición 
         * @access public 
         * @param string @param array
         * @return object
         */
        public function validarTipoPeticion(string $metodo = NULL, string $tipo = NULL,  array $data = NULL ){

            switch ($tipo) {
                case 'insert':
                    if(!Functions::post($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->registrarUsuario($data);
                    break;

                case 'update':
                    if(!Functions::put($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->actualizarUsuario($data);
                    break;

                case 'delete':
                    if(!Functions::delete($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->eliminarUsuario($data);
                    break;

                case 'one':
                    if(!Functions::get($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->obtenerUsuario($data);
                    break;
                case 'all':
                    if(!Functions::get($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->obtenerTodos();
                    break;
                default:
                    # code...
                    break;
            }
        
        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a insertar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function registrarUsuario(array $data){
            $registrarusuario = new UsuariosModel;
            Validations::validar_email( $data['email'] );
            Validations::validar_pass( $data['contrasena'] );
            
            $registrarusuario->setNombre( $data['nombre']);
            $registrarusuario->setEmail($data['email']);
            $registrarusuario->setContrasena($data['contrasena']);
            $registrarusuario->setTelefono_movil($data['telefono_movil']);
            $registrarusuario->setRol($data['rol']);
            $registrarusuario->setFecha_creacion($data['fecha_creacion']);
            $registrarusuario->setEstado($data['estado']);

            if($response =  $registrarusuario->existe("email", $registrarusuario->getEmail())){
                Functions::error_response('¡El usuario ya  existe en la base de datos!', 200);
                die();
            }
            $response = $registrarusuario->registrarUsuario();
            
            if(!$response){
                Functions::error_response('¡Error registrando el usuario!', 400);
                die();
            }
            $data = [
                "id" => $response
            ];
            Functions::response('¡Usuario registrado con Éxito!', 200, $data);
            die();
        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a actualizar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function actualizarUsuario(array $data){
            $actualizar = new UsuariosModel;
            if(!isset($data['id'])){
                Functions::error_response('¡Error, se debe envíar un id valido para actualizar!', 400);
            }else{
                $actualizar->setId( $data['id']);
            }

            if(!isset($data['nombre'])){
                $actualizar->setNombre(NULL);
            }else{
                $actualizar->setNombre( $data['nombre']);
            }

            if(!isset($data['email'])){

                $actualizar->setEmail(NULL);
            }else{
                Validations::validar_email($data['email']);
                $actualizar->setEmail($data['email']);

            }

            if(!isset($data['contrasena'])){
                $actualizar->setContrasena(NULL);
            }else{
                if(!Validations::validar_pass($data['contrasena'])){
                    return;
                }
                $actualizar->setContrasena($data['contrasena']);
            }

            if(!isset($data['telefono_movil'])){
                $actualizar->setTelefono_movil(NULL);
            }else{
                $actualizar->setTelefono_movil($data['telefono_movil']);

            }
            $response = $actualizar->actualizarUsuario();
            
            if(!$response){
                Functions::error_response('¡Error registrando el usuario!', 400);
                die();
            }
            $data = [
                "ok" => true
            ];
            Functions::response('¡Usuario Actualizado!', 200, $data);
            die();
        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a Eliminar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function eliminarUsuario(array $data){
            $eliminar = new UsuariosModel;
            if(!isset($data['id'])){
                Functions::error_response('¡Error, se debe envíar un id valido para eliminar!', 400);
            }else{
                $eliminar->setId( $data['id']);
            }

            $response = $eliminar->eliminarUsuario();
            $data = [
                "ok" => $response
            ];
            Functions::response('¡Usuario eliminado con Éxito!', 200, $data);
            die();

        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos  para obtener un usuario
         * @access public 
         * @param string @param array
         * @return object
         */
        public function obtenerUsuario(array $data){
            $obtener = new UsuariosModel;
            if(!isset($data['email'])){
                Functions::error_response('¡Debe enviar un email para buscar usuario!', 400);
            }else{
                $obtener->setEmail( $data['email']);
            }
            
            $response = $obtener->obtenerUsuario();
            $data = [
                "data" => $response
            ];
            Functions::response('¡Éxito, usuario encontrado!', 200, $data);
            die();

        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos para obtener todos los usuarios
         * @access public 
         * @param string @param array
         * @return object
         */
        public function obtenerTodos(){
            $obtener = new UsuariosModel;
            $response = $obtener->obtenerTodos();
            $data = [
                "data" => $response
            ];
            Functions::response('¡Éxito, lista de usuarios cargada!', 200, $data);
            die();

        }

        

    }