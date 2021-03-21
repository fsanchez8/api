<?php 

    namespace Route;
    use Route\EnrutadorAPI;
    use App\controllers\defaults\Defaults;
    use Fx\Functions;
    use App\controllers\auth\Auth;
    use App\controllers\usuarios\Usuarios;
    use App\controllers\categorias\Categorias;
    use App\controllers\posts\Posts;
    use App\controllers\comentarios\Comentarios;
    class Router {

        
        protected $uri = [];
        
        private $endpoint= array(
            'login',
            'usuarios',
            'categorias',
            'comentarios',
            'likes',
            'posts'

        );

        /**
         * Método construnctor de la clase
         * 
         */
        public function load(){
            if($_ENV['API']){
                $this->api();
            }else{
                $this->app();
            }
        }

        /**
         * Get the value of uri
         * @access public 
         * @param null
         * @return void
         */ 
        public function getUri(){
            return $this->uri;
        }

        /**
         * Set the value of uri
         * @access public
         * @param string
         * @return  self
         */ 
        public function setUri($uri){
            $this->uri = $uri;
            return $this;
        }
        

        /**
         * Función para iniciar la API
         * @access  public
         * 
         */
        public function api(){
            $rute = EnrutadorAPI::Uri();
            $this->loadEndPoint($rute);
        }

        /**
         * Función para iniciar la APP
         * @access  public
         * 
         */
        public function app(){
            echo "en proceso de desarrollo FS";
        }

        /**
         * Función para cargar el endpoint solicitado
         * @access  public
         * @param string
         * @return void
         */
        public function loadEndPoint( array $endpoint){
            if(isset($endpoint['controller'])){
                if($endpoint['controller'] === 'default'){
                    $default =  new Defaults;
                    $default->defaultViews("Documentacion");
                }else if(isset($endpoint['controller'])){
                    if(in_array($endpoint['controller'], $this->endpoint )){
                            /**validar en este punto el permiso para acceder al endpoin */
                            if(!isset($endpoint['params'])){
                                $param = [
                                    "controller" => $endpoint['controller'],
                                ];
                            }else{
                                $param = [
                                    "controller" => $endpoint['controller'],
                                    "type"       => $endpoint['params'],
                                    "id"         => $endpoint['id']
                                ];
                            }
                            $this->processEndpoint($endpoint['controller'], $param);
                    }else{
                        Functions::error_response('¡La ruta solicitada no existe!', 404);
                    }
                }
            }
        }

        /**
         * Función para procesar el endpoint solicitado y la data recibida
         * @access  public
         * @param string 
         * @return void
         */
        public function processEndpoint(string $endpoint, array $param = null){
            Functions::header_json_utf8();

            if(in_array($param['controller'], $this->endpoint)){
                
            }

            switch ($param['controller']) {
                case 'login':
                            if( Functions::post($_SERVER['REQUEST_METHOD']) ){
                                $data = $this->request();
                                Auth::auth($data['usuario'], $data['contrasena']);
            
                            }else{
                                Functions::error_response('¡Método enviado para el consumo incorrecto!', 405);
                            }
                    break;
                case 'usuarios':
                            if(!isset($param['type'])){
                                Functions::error_response('¡Parametros enviados para el consumo insuficientes!', 400);
                            }
                            $usuarios = new Usuarios;
                            $usuarios->validarTipoPeticion($_SERVER['REQUEST_METHOD'], $param['type'], $this->request() );

                    break;
                case 'categorias':
                            if(!isset($param['type'])){
                                Functions::error_response('¡Parametros enviados para el consumo insuficientes!', 400);
                            }
                            $categorias = new Categorias;
                            $categorias->validarTipoPeticion($_SERVER['REQUEST_METHOD'], $param['type'], $this->request() );
                        break;
                case 'posts':
                            if(!isset($param['type'])){
                                Functions::error_response('¡Parametros enviados para el consumo insuficientes!', 400);
                            }
                            $post = new Posts;
                            $post->validarTipoPeticion($_SERVER['REQUEST_METHOD'], $param['type'], $this->request() );
                            
                break;
                case 'comentarios':
                            if(!isset($param['type'])){
                                Functions::error_response('¡Parametros enviados para el consumo insuficientes!', 400);
                            }
                            $comentarios = new Comentarios;
                            $comentarios->validarTipoPeticion($_SERVER['REQUEST_METHOD'], $param['type'], $this->request() );
                    
                    break;
                case 'likes':
                        echo 'registrolike';
                    break;
                default:
                    Functions::error_response('¡La opción solicitada no existe!', 404);
                    break;
            }

        }
        /**
         * Función procesar el request 
         * @access  public
         * @param null 
         */
        public function request(){
            ini_set('memory_limit', '-1');
            $body = json_decode(file_get_contents("php://input"),true);
            return $body;
        }

        
    }