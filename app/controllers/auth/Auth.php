<?php 

    namespace App\controllers\auth;

    use App\interfaces\AuthInterface;
    use App\models\auth\AuthModel;
    use Exception;
    use Fx\Functions;
    use JsonT\Jasonwt;

    class Auth implements AuthInterface{

        /**
         * Función para recibir los datos que vienen y mandarlos al modelo  para obtener la información de la BD
         * @access public 
         * @param string 
         * @return array
         */
        public function auth( string $email, string $password ){
            $auth = new AuthModel;

            $response = $auth->auth($email);
            if($response){
                if(password_verify($password, $response[0]->contrasena)){
                    $data  = array($response[0]->id, $response[0]->nombre );
                    $token = Jasonwt::SignIn($data);
                    try {
                        if(Jasonwt::Check( $token )){
                            $data = array(
                                "id"     => $response[0]->id,
                                "nombre" => $response[0]->nombre,
                                "email"  => $response[0]->email,
                                "tokken" => $token
                            );
                            Functions::response('¡Éxito!', 200, $data);
                        }else{
                            Functions::error_response('¡Datos de conexión incorrectos!', 401);
                        }
                    } catch (Exception $th) {
                        return Functions::error_response('Verificación de tokken fallída', 401);
                        
                    }
                }else{
                    Functions::error_response('¡Datos de conexión incorrectos!', 401);
                }
            }else{
                Functions::error_response('¡Datos de conexión incorrectos!', 401);
            }
            
        }

    }