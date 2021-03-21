<?php 
    namespace App\models\usuarios;

    use App\db\Conexion;
use Exception;
use Fx\Functions;
    use PDOException;

    class UsuariosModel extends Conexion {

        private $id;
        private $nombre;
        private $email;
        private $contrasena;
        private $telefono_movil;
        private $rol;
        private $fecha_creacion;
        private $estado;

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of nombre
         */ 
        public function getNombre()
        {
                return $this->nombre;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of contrasena
         */ 
        public function getContrasena()
        {
                return $this->contrasena;
        }

        /**
         * Set the value of contrasena
         *
         * @return  self
         */ 
        public function setContrasena($contrasena)
        {
                $this->contrasena = $contrasena;

                return $this;
        }

        /**
         * Get the value of telefono_movil
         */ 
        public function getTelefono_movil()
        {
                return $this->telefono_movil;
        }

        /**
         * Set the value of telefono_movil
         *
         * @return  self
         */ 
        public function setTelefono_movil($telefono_movil)
        {
                $this->telefono_movil = $telefono_movil;

                return $this;
        }

        /**
         * Get the value of rol
         */ 
        public function getRol()
        {
                return $this->rol;
        }

        /**
         * Set the value of rol
         *
         * @return  self
         */ 
        public function setRol($rol)
        {
                $this->rol = $rol;

                return $this;
        }

        /**
         * Get the value of fecha_creacion
         */ 
        public function getFecha_creacion()
        {
                return $this->fecha_creacion;
        }

        /**
         * Set the value of fecha_creacion
         *
         * @return  self
         */ 
        public function setFecha_creacion($fecha_creacion)
        {
                $this->fecha_creacion = $fecha_creacion;

                return $this;
        }

        /**
         * Get the value of estado
         */ 
        public function getEstado()
        {
                return $this->estado;
        }

        /**
         * Set the value of estado
         *
         * @return  self
         */ 
        public function setEstado($estado)
        {
                $this->estado = $estado;

                return $this;
        }


        /**
         * Función para validar contra la base de datos si el usuario y la contrseña envíados son correctos
         * @access public
         * @param string  
         * @return array
         */
        public function registrarUsuario( ){

                $sql = 'INSERT INTO usuario (nombre, email, contrasena, telefono_movil, ROL_id, fecha_creacion, ESTADO_id)  
                                VALUES  (:nombre, :email, :contrasena, :telefono_movil, :ROL_id, :fecha_creacion, :ESTADO_id)' ;
                $data  = [
                        "nombre"               => $this->getNombre(),
                        "email"                => $this->getEmail(),
                        "contrasena"           => Functions::crypt_pass($this->getContrasena()),
                        "telefono_movil"       => $this->getTelefono_movil(),
                        "ROL_id"               => (int)$this->getRol(),
                        "fecha_creacion"       => $this->getFecha_creacion(),
                        "ESTADO_id"            => (int)$this->getEstado() ,
                ];
                try {
                        ($id = parent::query($sql, $data )) ? $id : false;
                        return $id;
                } catch (PDOException $th) {
                        throw new Exception("Error procesando la información", 1, $th);
                }
        }

        /**
         * Función para validar contra la base de datos si el usuario y la contrseña envíados son correctos
         * @access public
         * @param string  
         * @return array
         */
        public function actualizarUsuario( ){
                
                if($this->getContrasena() !=  NULL ){
                        $sql = 'UPDATE  usuario 
                        SET  nombre = :nombre,  email = :email,  contrasena = :contrasena, telefono_movil = :telefono_movil
                        WHERE id = :id' ;
                        $data  = [
                                "nombre"               => $this->getNombre(),
                                "email"                => $this->getEmail(),
                                "contrasena"           => Functions::crypt_pass($this->getContrasena()),
                                "telefono_movil"       => $this->getTelefono_movil(),
                                "id"                   => $this->getId(),
                        ];
                }else{
                        $sql = 'UPDATE  usuario 
                        SET  nombre = :nombre,  email = :email, telefono_movil = :telefono_movil
                        WHERE id = :id' ;
                        $data  = [
                                "nombre"               => $this->getNombre(),
                                "email"                => $this->getEmail(),
                                "telefono_movil"       => $this->getTelefono_movil(),
                                "id"                   => $this->getId(),
                        ];
                }
 
                try {
                        return (parent::query($sql, $data)) ? true: false ;          
                } catch (PDOException $th) {
                        throw new Exception("Error procesando la solicitud", 1, $th);
                }
        }

        /**
         * Función para validar contra la base de datos si el usuario y la contrseña envíados son correctos
         * @access public
         * @param string  
         * @return array
         */
        public function eliminarUsuario( ){

                $sql = 'DELETE FROM usuario WHERE id = :id ';
                $data  = [
                        "id" => $this->getId(),
                ];

                try {
                        return (parent::query($sql, $data)) ? true: false ;          
                } catch (PDOException $th) {
                        throw new Exception("Error procesando la solicitud", 1, $th);
                }
        }
                
        /**
         * Función para validar contra la base de datos si el usuario y la contrseña envíados son correctos
         * @access public
         * @param string  
         * @return array
         */
        public function obtenerUsuario( ){

                $sql = 'SELECT TU.nombre, TU.email, TU.telefono_movil, TU.fecha_creacion,TR.nombre AS permiso 
                        FROM usuario TU
                        LEFT JOIN rol TR ON (TU.ROL_id = TR.id)
                        WHERE email = :email ';
                $data  = [
                        "email" => $this->getEmail(),
                ];

                try {
                        return ($row =  parent::query($sql, $data)) ? $row[0]: false ;          
                } catch (PDOException $th) {
                        throw new Exception("Error procesando la solicitud", 1, $th);
                }
        }

        /**
         * Función para validar contra la base de datos si el usuario y la contrseña envíados son correctos
         * @access public
         * @param string  
         * @return array
         */
        public function obtenerTodos( ){

                $sql = 'SELECT TU.nombre, TU.email, TU.telefono_movil, TU.fecha_creacion,TR.nombre AS permiso 
                        FROM usuario TU
                        LEFT JOIN rol TR ON (TU.ROL_id = TR.id)
                        ';
                try {
                        ($row = parent::query($sql)) ? $row: false ;

                        return $row ;     
                } catch (PDOException $th) {
                        throw new Exception("Error procesando la solicitud", 1, $th);
                }
        }
        
        /**
         * Función para validar si el usuario ya existe en la base de datos 
         * @access public 
         * @param string
         * @return bolean
         */
        public function existe(string $campo, string $value){

        $sql = "SELECT  $campo   FROM usuario WHERE $campo = :$campo ";
        $data  = [
                $campo      => $value,
        ];
        try {
                return parent::query($sql, $data) ? true : false;
                
        } catch (PDOException $th) {
                throw $th;
        }
        }



}