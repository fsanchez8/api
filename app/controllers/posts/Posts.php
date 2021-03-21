<?php 

    namespace App\controllers\posts;
    use Fx\Functions;
    use Fx\Validations;
    use App\models\posts\PostModel;
    use Exception;
    use JsonT\Jasonwt;
    
class Posts{

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
                    $this->registrarPost($data);
                    break;

                case 'update':
                    if(!Functions::put($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->actualizarPost($data);
                    break;

                case 'delete':
                    if(!Functions::delete($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->anularPost($data);
                    break;

                case 'one':
                    if(!Functions::get($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->obtenerPost($data);
                    break;
                case 'all':
                    if(!Functions::get($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->obtenerTodosPost($data);
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
        public function registrarPost(array $data){
            
            try {
                $registrarpost = new PostModel;
                    if(Jasonwt::Check($data['tokken'])){                   
                        $slug = Functions::crear_slug( strtolower($data['titulo']) );
                        $registrarpost->setId_categoria($data['id_categoria']);
                        $registrarpost->setId_usuario($data['id_usuario']);
                        $registrarpost->setTitulo($data['titulo']);
                        $registrarpost->setSlug($slug);
                        $registrarpost->setTexto_corto($data['text_corto']);
                        $registrarpost->setTexto_largo($data['texto_largo']);
                        $registrarpost->setUrl_imagen($data['url_imagen']);
                        $registrarpost->setFecha_creacion($data['fecha_creacion']);
                        $registrarpost->setEstado($data['estado']);
                        $response = $registrarpost->registrarPost();

                        $data = [
                            "data" => $response
                        ];
                        Functions::response('¡Éxito, post creado!', 200, $data);
                        die();
                    }
            
                } catch (Exception $th) {
                    return Functions::error_response('¡No esta autorizado para realizar esta acción!', 400);
                }

        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a actualizar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function actualizarPost(array $data){
            try {
                $actualizar = new PostModel;
                    if(Jasonwt::Check($data['tokken'])){                   
                        $slug = Functions::crear_slug( strtolower($data['titulo']) );
                        $actualizar->setId($data['id']);
                        $actualizar->setTitulo(strtolower($data['titulo']));
                        $actualizar->setSlug($slug);
                        $actualizar->setTexto_corto(strtolower($data['texto_corto']));
                        $actualizar->setTexto_largo(strtolower($data['texto_largo']));
                        $response = $actualizar->actualizarPost();

                        $data = [
                            "data" => $response
                        ];
                        Functions::response('¡Éxito, post actualizado!', 200, $data);
                        die();
                    }
            
                } catch (Exception $th) {
                    return Functions::error_response('¡No esta autorizado para realizar esta acción!', 400);
                }

        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a Eliminar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function anularPost(array $data){
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
        public function obtenerPost(array $data){
            $obtener = new PostModel;
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
        public function obtenerTodosPost(array $data = NULL){
            $obtener = new PostModel;
            $limit = $data['limit'];
            $response = $obtener->obtenerTodosPost($limit);

            Functions::response('¡Éxito, lista de post cargada!', 200, $response);
            die();

        }

        

    }