<?php 
    namespace App\models\categorias;

    use App\db\Conexion;
    use Exception;
    use Fx\Functions;
    use PDOException;

    class CategoriasModel extends Conexion {

        private $id;
        private $nombre;
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
         * Función para registrar una nueva categoria
         * @access public
         * @param string  
         * @return array
         */
        public function registrarCategoria( ){

                $sql = 'INSERT INTO categoria (nombre,  fecha_creacion, ESTADO_id)  
                                VALUES  (:nombre,  :fecha_creacion, :ESTADO_id)' ;
                $data  = [
                        "nombre"               => $this->getNombre(),
                        "fecha_creacion"       => $this->getFecha_creacion(),
                        "ESTADO_id"            => (int)$this->getEstado() ,
                ];
                try {
                        ($id = parent::query($sql, $data )) ? $id : false;
                        return $id;
                } catch (PDOException $th) {
                        throw new Exception("Error procesando la solicitud", 1, $th);
                }
        }

        /**
         * Función para actualizar una categoría 
         * @access public
         * @param string  
         * @return array
         */
        public function actualizarCategoria( ){
            
                $sql = 'UPDATE  categoria 
                SET  nombre = :nombre 
                WHERE id = :id' ;

                $data  = [
                        "nombre"               => $this->getNombre(),
                        "id"                   => $this->getId(),
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
        public function incativarCategoria( ){

                $sql = 'UPDATE  categoria SET ESTADO_id = :ESTADO_id WHERE id = :id ';
                $data  = [
                        "ESTADO_id" =>  $this->getEstado(),
                        "id"        => $this->getId(),
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
        public function obtenerCategoria( ){
                $sql = "SELECT id, nombre, fecha_creacion, fecha_modificacion
                        FROM categoria 
                        WHERE  nombre  LIKE  CONCAT('%', :nombre, '%') ";
                $data  = [
                        "nombre" => $this->getNombre(),
                ];

                try {
                        return ($row =  parent::query($sql, $data)) ? $row: false ;          
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
        public function obtenerTodasCategorias( string $limit = NULL){

                $sql = "SELECT id, nombre, fecha_creacion, fecha_modificacion
                        FROM categoria 
                        ";
                if(isset($limit)){
                    $sql .= "LIMIT $limit ";
                }
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

        $sql = "SELECT  $campo   FROM categoria WHERE $campo = :$campo ";
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