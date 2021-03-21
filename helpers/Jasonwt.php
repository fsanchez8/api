<?php 
    namespace JsonT;

    use Exception;
    use Firebase\JWT\JWT;

    class Jasonwt{

        private static $encrypt = ['HS256'];
        
        /**
         * Función para genetar el JWT
         * @param array
         * @return string
         */
        public static function SignIn(array $data ){

            $time = time();

            $token = array(
                'exp' => $time + (60*60),
                'aud' => self::Aud(),
                'data' => $data
            );
    
            return JWT::encode($token, $_ENV['SECRET_KEY']);

        }

        /**
         * Función para genetar el JWT
         * @param array
         * @return string
         */
        public static function Check($token){
            if(empty($token))
            {
                throw new Exception(" No se envió un token valido.");
            }
    
            $decode = JWT::decode(
                $token,
                $_ENV['SECRET_KEY'],
                self::$encrypt
            );
    
            if($decode->aud !== self::Aud())
            {
                throw new Exception("Datos de usuario incorrectos.");
            }

            return true;
        }

        public static function GetData($token){
            return JWT::decode(
                $token,
                $_ENV['SECRET_KEY'],
                self::$encrypt
            )->data;
        }

        private static function Aud(){
            $aud = '';
    
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $aud = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $aud = $_SERVER['REMOTE_ADDR'];
            }
    
            $aud .= @$_SERVER['HTTP_USER_AGENT'];
            $aud .= gethostname();
    
            return sha1($aud);
        }

    }