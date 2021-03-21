<?php 

    namespace App\controllers\categorias;
    use Fx\Functions;
    use Fx\Validations;
    use App\models\categorias\CategoriasModel;
    
class Categorias{

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
                    $this->registrarCategoria($data);
                    break;

                case 'update':
                    if(!Functions::put($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->actualizarCategoria($data);
                    break;

                case 'delete':
                    if(!Functions::delete($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->incativarCategoria($data);
                    break;

                case 'one':
                    if(!Functions::get($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->obtenerCategoria($data);
                    break;
                case 'all':
                    if(!Functions::get($metodo)){
                        return Functions::error_response('¡Método enviado para el consumo, incorrecto!', 405);
                    }
                    $this->obtenerTodasCategorias($data);
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
        public function registrarCategoria(array $data){
            $registrarcategoria = new CategoriasModel;
            
            $registrarcategoria->setNombre( strtolower($data['nombre']));
            $registrarcategoria->setFecha_creacion( $data['fecha_creacion']);
            $registrarcategoria->setEstado($data['estado']);

            if($response =  $registrarcategoria->existe("nombre", $registrarcategoria->getNombre())){
                $categoria = $registrarcategoria->getNombre();
                Functions::error_response("¡la categoría ($categoria) ya existe en la base de datos!", 200);
                die();
            }

            $response = $registrarcategoria->registrarCategoria();
            
            if(!$response){
                Functions::error_response('¡Error registrando la categoría!', 400);
                die();
            }
            $data = [
                "id" => $response
            ];
            Functions::response('¡Categoría registrada con Éxito!', 200, $data);
            die();
        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a actualizar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function actualizarCategoria(array $data){
            $actualizar = new CategoriasModel;
            if(!isset($data['id'])){
                Functions::error_response('¡Error, se debe envíar un id valido para actualizar!', 400);
            }else{
                $actualizar->setId( $data['id']);
            }

            if(!isset($data['nombre'])){
                Functions::error_response('¡No se detectaron cambios para Actualizar!', 200);
            }else{
                $actualizar->setNombre( strtolower($data['nombre']) );
            }

            $response = $actualizar->actualizarCategoria();
            
            if(!$response){
                Functions::error_response('¡Error actualizando la categoría!', 400);
                die();
            }
            $data = [
                "data" => true
            ];
            Functions::response('¡Categoría Actualizada!', 200, $data);
            die();
        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos a Eliminar  
         * @access public 
         * @param string @param array
         * @return object
         */
        public function incativarCategoria(array $data){
            $eliminar = new CategoriasModel;
            if(!isset($data['id'])){
                Functions::error_response('¡Error, se debe envíar un id valido para incativar!', 400);
            }else{
                $eliminar->setId( $data['id']);
            }
            $eliminar->setEstado($data['estado']);
            $response = $eliminar->incativarCategoria();
            $data = [
                "ok" => $response
            ];
            Functions::response('¡Categoría bloqueada!', 200, $data);
            die();

        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos  para obtener un usuario
         * @access public 
         * @param string @param array
         * @return object
         */
        public function obtenerCategoria(array $data){
            $obtener = new CategoriasModel;
            if(!isset($data['nombre'])){
                Functions::error_response('¡Debe enviar un nombre para buscar una categoría!', 400);
            }else{
                $obtener->setNombre( strtolower($data['nombre']));
            }
            
            $response = $obtener->obtenerCategoria();
            $data = [
                "data" => $response
            ];
            Functions::response('', 200, $data);
            die();

        }

        /**
         * Función para  validar la data y llamar el modelo y pasarle los datos para obtener todos los usuarios
         * @access public 
         * @param string @param array
         * @return object
         */
        public function obtenerTodasCategorias(array $data = NULL){
            $obtener = new CategoriasModel;
            if(isset($data['limit'])){
                $limit = $data['limit'];
            }else{
                $limit = NULL;
            }
            $response = $obtener->obtenerTodasCategorias($limit);
            Functions::response('¡Éxito, lista de usuarios cargada!', 200, $response);
            die();

        }

        

    }