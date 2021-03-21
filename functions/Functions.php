<?php 
    namespace Fx;

    class Functions{

        /**
         * Función para enviar la cabecera en formato Json
         * @access public
         * @param null 
         * @return header
         */
        public static function header_json(){
            return header('Content-Type: application/json');
        }

        /**
         * Función para enviar la cabecera en formato HTML
         * @access public 
         * @param null 
         * @return header
         */
        public static function header_html(){
            return header('Content-Type: text/html; charset=utf-8');
        }

        /**
         * Función para enviar la cabecera en formato Json codificado a UTF8
         * @access public
         * @param null  
         * @return header
         */
        public static function header_json_utf8(){
            return header('Content-Type: application/json; charset=utf-8');
        }

        /**
         * Función para manejar los errores HTTP
         * @param int 
         * @return http_error 
         */
        public static function error_code(int $error){
            return http_response_code($error);
        }

        /**
         * Función para  responder a los errores http en formato json
         * 
         * @param string @param int 
         * 
         * @return Object
         */
        public static function error_response(string $msg, int $error_code){
            self::header_json();
            self::error_code($error_code);
                $json = array(
                        "status" => $error_code,
                        "msg" => $msg,
                );
                echo json_encode($json, true);
        }

        /**
         * Función para  responder cuando todo funciona bien
         * 
         * @param string @param int 
         * 
         * @return Object
         */
        public static function response(string $msg, int $error_code, array $data){
            self::header_json();
            self::error_code($error_code);
                $json = array(
                        "status" => $error_code,
                        "msg" => $msg,
                        "data" =>$data
                );
                echo json_encode($json, true);
        }

        /**
         * Función  para validar si el metodo enviado para el consumo es POST
         * @access  public
         * @param string 
         * @return bolean | @return Object
         */
        public static function post(string $method){
            return  ($method == 'POST') ? true : false;
        }

        /**
         * Función  para validar si el metodo enviado para el consumo es GET
         * @access  public
         * @param string 
         * @return bolean | @return Object
         */
        public static function get(string $method){
            return  ($method == 'GET') ? true : false;
        }

        
        /**
         * Función  para validar si el metodo enviado para el consumo es PUT
         * @access  public
         * @param string 
         * @return bolean
         */
        public static function put(string $method){
            return  ($method == 'PUT') ? true : false;
        }

        /**
         * Función  para validar si el metodo enviado para el consumo es DELETE
         * @access  public
         * @param string 
         * @return bolean 
         */
        public  static function delete(string $method){
            return  ($method == 'DELETE') ? true : false;
        }

        /**
         * Función para encriptar la contraseña
         * @access public 
         * @param string
         * @return string
         */
        public static function crypt_pass(string $password){
            $passHash = password_hash($password, PASSWORD_BCRYPT);
            return $passHash;
        }

        /**
         * Función para crear el slug de la navegación
         * @access public
         * @param string
         * @return string
         */
        public static function crear_slug($str, $max=30){
            $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
            $slug = substr(preg_replace("/[^-\/+|\w ]/", '', $slug), 0, $max);
            $slug = strtolower(trim($slug, '-'));
            $slug = preg_replace("/[\/_| -]+/", '-', $slug);

            return $slug;
        }


    }