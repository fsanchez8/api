<?php 

    namespace App\controllers\comentarios;
    use Fx\Functions;
    use Fx\Validations;
    use App\models\comentarios\ComentariosModel;
use Exception;
use JsonT\Jasonwt;
class Comentarios{

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
                    $this->registrarComentario($data);
                    break;

                case 'update':
                    if(!Functions::put($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->actualizarComentario($data);
                    break;

                case 'delete':
                    if(!Functions::delete($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->eliminarComentario($data);
                    break;

                case 'one':
                    if(!Functions::get($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    // $this->obtenerComentario($data);
                    break;
                case 'all':
                    if(!Functions::get($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->obtenerTodosComentarios($data);
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
        public function registrarComentario(array $data){
            $registrarcomentario = new ComentariosModel;
            
            try {
                Jasonwt::Check($data['tokken']);
                $registrarcomentario->setId_post( $data['id_post']);
                $registrarcomentario->setComentario(strtolower($data['comentario']));
                $registrarcomentario->setFecha_creacion($data['fecha_creacion']);
                $registrarcomentario->setEstado($data['estado']);

                $response = $registrarcomentario->registrarComentario();
                
                if(!$response){
                    Functions::error_response('¡Error registrando el comentario!', 400);
                    die();
                }

                $data = [
                    "id" => $response
                ];
                Functions::response('¡Éxito, comentario registrado!', 200, $data);
                die();
            } catch (Exception $th) {
                Functions::error_response('¡Tokken expirado o invalido!', 400);
            }

            
        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a actualizar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function actualizarComentario(array $data){
            $actualizar = new ComentariosModel;

            try {
                Jasonwt::Check($data['tokken']);
                $actualizar->setId( $data['id']);
                $actualizar->setComentario(strtolower($data['comentario']));
                $response = $actualizar->actualizarComentario();
                
                if(!$response){
                    Functions::error_response('¡Error actualizando el comentario!', 400);
                    die();
                }

                $data = [
                    "id" => $response
                ];
                Functions::response('¡Éxito, comentario Actualizado!', 200, $data);
                die();
            } catch (Exception $th) {
                Functions::error_response('¡Tokken expirado o invalido!', 400);
            }
        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a Eliminar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function eliminarComentario(array $data){
            $eliminar = new ComentariosModel;
            if(!isset($data['id'])){
                Functions::error_response('¡Error, se debe envíar un id valido para eliminar!', 400);
            }else{
                $eliminar->setId( $data['id']);
            }

            $response = $eliminar->eliminarComentario();
            $data = [
                "ok" => $response
            ];
            Functions::response('¡Comentario eliminado con Éxito!', 200, $data);
            die();

        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos  para obtener un usuario
         * @access public 
         * @param string @param array
         * @return object
         */
        public function obtenerComentario(array $data){
            

        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos para obtener todos los usuarios
         * @access public 
         * @param string @param array
         * @return object
         */
        public function obtenerTodosComentarios(array $data){
            $obtener = new ComentariosModel;
            $id = $data['id'];  
            $response = $obtener->obtenerTodosComentarios($id);
            $data = [
                "data" => $response
            ];
            Functions::response('¡Éxito, lista de usuarios cargada!', 200, $data);
            die();

        }

        

    }