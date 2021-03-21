<?php 

    namespace Route;

    class EnrutadorAPI{
        
        private $uri = []; 
        private $params;

        /**
         * Función para getionar las URLS de la API
         * @access public 
         * @param null
         * @return self
         */
        public function Uri(){
            return $this->parseUri();
        }

        /**
         * Función para parsear y sanitizar la URL recibida
         * @access public 
         * @param null
         * @return string | @return array
         */
        public function parseUri(){
            $uri = $_SERVER["REQUEST_URI"];
            var_dump($uri);
            $uri =  explode("/", filter_var(rtrim( $uri , "/"), FILTER_SANITIZE_URL));
            $uri = array_filter($uri);
            if(isset($uri[2])){
                if(!isset($uri[3])){
                    $routes = [
                        "controller" => $uri[2],
                    ];
                    return  $routes;
                }else{
                    if(!isset($uri[4])){
                        $routes = [
                            "controller" => $uri[2],
                            "params"     => $uri[3],
                        ];
                    }else{
                        $routes = [
                            "controller" => $uri[2],
                            "params"     => $uri[2],
                        ];
                    }
                    return $routes;
                }
            }else {
                return  $routes = [
                    "controller" =>  "default"
                ];
            }  
        }


    }