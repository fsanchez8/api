<?php 
    namespace App\models\auth;
    use App\db\Conexion;
    use PDOException;

class AuthModel extends Conexion  {

        /**
         * Función para validar contra la base de datos si el usuario y la contrseña envíados son correctos
         * @access public
         * @param string  
         * @return array
         */
        public function auth( string $email){
            $sql = 'SELECT id, nombre, email, contrasena  FROM usuario WHERE email = :email';
            $data  = [
                "email"      => $email,
            ];
            
            try {
                ($rows = parent::query($sql, $data)) ? $rows[0] : [];
                return $rows;
            } catch (PDOException $th) {
                throw $th;
            }
        }

        

    }