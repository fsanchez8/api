<?php 
        namespace App\models\comentarios;

        use App\db\Conexion;
        use Exception;
        use Fx\Functions;
        use PDOException;

class ComentariosModel extends Conexion {

        private $id;
        private $id_post;
        private $id_usuario;
        private $fecha_creacion;
        private $estado;
        private $comentario;

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
         * Get the value of id_post
         */ 
        public function getId_post()
        {
                return $this->id_post;
        }

        /**
         * Set the value of id_post
         *
         * @return  self
         */ 
        public function setId_post($id_post)
        {
                $this->id_post = $id_post;

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
         * Get the value of comentario
         */ 
        public function getComentario()
        {
                return $this->comentario;
        }

        /**
         * Set the value of comentario
         *
         * @return  self
         */ 
        public function setComentario($comentario)
        {
                $this->comentario = $comentario;

                return $this;
        }


        /**
         * Función para validar contra la base de datos si el usuario y la contrseña envíados son correctos
         * @access public
         * @param string  
         * @return array
         */
        public function registrarComentario( ){

                $sql = 'INSERT INTO comentario (POST_id, ESTADO_id, comentario, fecha_creacion)  
                                VALUES  (:POST_id, :ESTADO_id, :comentario, :fecha_creacion)' ;
                $data  = [
                        "POST_id"         => $this->getId_post(),
                        "ESTADO_id"       => $this->getEstado(),
                        "comentario"      => $this->getComentario(),
                        "fecha_creacion"  => $this->getFecha_creacion(),
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
        public function actualizarComentario( ){

                $sql = 'UPDATE  comentario 
                        SET  comentario = :comentario
                        WHERE id = :id' ;
                $data  = [
                        "comentario"  => $this->getComentario(),
                        "id"          => $this->getId(),
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
        public function eliminarComentario( ){

                $sql = 'DELETE FROM comentario WHERE id = :id ';
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
        public function obtenerComentario( ){

                // $sql = 'SELECT TU.nombre, TU.email, TU.telefono_movil, TU.fecha_creacion,TR.nombre AS permiso 
                //         FROM usuario TU
                //         LEFT JOIN rol TR ON (TU.ROL_id = TR.id)
                //         WHERE email = :email ';
                // $data  = [
                //         "email" => $this->get(),
                // ];

                // try {
                //         return ($row =  parent::query($sql, $data)) ? $row[0]: false ;          
                // } catch (PDOException $th) {
                //         throw new Exception("Error procesando la solicitud", 1, $th);
                // }
        }

        /**
         * Función para validar contra la base de datos si el usuario y la contrseña envíados son correctos
         * @access public
         * @param string  
         * @return array
         */
        public function obtenerTodosComentarios( int $id ){

                $sql = 'SELECT  id, comentario
                        FROM  comentario
                        WHERE POST_id = :POST_id
                        ';
                $data  = [
                        "POST_id" => $id,
                ];
                try {
                        ($row = parent::query($sql, $data)) ? $row: false ;

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