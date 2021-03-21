<?php 
        namespace App\models\posts;

        use App\db\Conexion;
        use Exception;
        use Fx\Functions;
        use PDOException;

        class PostModel extends Conexion {

                private $id;
                private $id_categoria;
                private $id_usuario;
                private $titulo;
                private $slug;
                private $texto_corto;
                private $texto_largo;
                private $url_imagen;
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
                 * Get the value of id_categoria
                 */ 
                public function getId_categoria()
                {
                        return $this->id_categoria;
                }

                /**
                 * Set the value of id_categoria
                 *
                 * @return  self
                 */ 
                public function setId_categoria($id_categoria)
                {
                        $this->id_categoria = $id_categoria;

                        return $this;
                }

                /**
                 * Get the value of id_usuario
                 */ 
                public function getId_usuario()
                {
                        return $this->id_usuario;
                }

                /**
                 * Set the value of id_usuario
                 *
                 * @return  self
                 */ 
                public function setId_usuario($id_usuario)
                {
                        $this->id_usuario = $id_usuario;

                        return $this;
                }

                /**
                 * Get the value of titulo
                 */ 
                public function getTitulo()
                {
                        return $this->titulo;
                }

                /**
                 * Set the value of titulo
                 *
                 * @return  self
                 */ 
                public function setTitulo($titulo)
                {
                        $this->titulo = $titulo;

                        return $this;
                }

                /**
                 * Get the value of slug
                 */ 
                public function getSlug()
                {
                        return $this->slug;
                }

                /**
                 * Set the value of slug
                 *
                 * @return  self
                 */ 
                public function setSlug($slug)
                {
                        $this->slug = $slug;

                        return $this;
                }

                /**
                 * Get the value of texto_corto
                 */ 
                public function getTexto_corto()
                {
                        return $this->texto_corto;
                }

                /**
                 * Set the value of texto_corto
                 *
                 * @return  self
                 */ 
                public function setTexto_corto($texto_corto)
                {
                        $this->texto_corto = $texto_corto;

                        return $this;
                }

                /**
                 * Get the value of texto_largo
                 */ 
                public function getTexto_largo()
                {
                        return $this->texto_largo;
                }

                /**
                 * Set the value of texto_largo
                 *
                 * @return  self
                 */ 
                public function setTexto_largo($texto_largo)
                {
                        $this->texto_largo = $texto_largo;

                        return $this;
                }

                /**
                 * Get the value of url_imagen
                 */ 
                public function getUrl_imagen()
                {
                        return $this->url_imagen;
                }

                /**
                 * Set the value of url_imagen
                 *
                 * @return  self
                 */ 
                public function setUrl_imagen($url_imagen)
                {
                        $this->url_imagen = $url_imagen;

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
                public function registrarPost( ){

                $sql = 'INSERT INTO post (CATEGORIA_id,  USUARIO_id , titulo,  slug,  texto_corto,  texto_largo,  url_imagen,  fecha_creacion,  ESTADO_id)  
                                VALUES  (:CATEGORIA_id, :USUARIO_id, :titulo, :slug, :texto_corto, :texto_largo, :url_imagen, :fecha_creacion, :ESTADO_id)' ;
                $data  = [
                        "CATEGORIA_id"   => (int)$this->getId_categoria(),
                        "USUARIO_id"    => (int)$this->getId_usuario(),
                        "titulo"         => $this->getTitulo(),
                        "slug"           => $this->getSlug() ,
                        "texto_corto"    => $this->getTexto_corto(),
                        "texto_largo"    => $this->getTexto_largo(),
                        "url_imagen"     => $this->getUrl_imagen(),
                        "fecha_creacion" => $this->getFecha_creacion() ,
                        "ESTADO_id"      => (int)$this->getEstado() ,
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
        public function actualizarPost( ){

                $sql = 'UPDATE  post 
                SET  titulo = :titulo,  slug = :slug,  texto_corto = :texto_corto, texto_largo = :texto_largo
                WHERE id = :id' ;
                $data  = [
                        "titulo"       => $this->getTitulo(),
                        "slug"         => $this->getSlug(),
                        "texto_corto"   => $this->getTexto_corto() ,
                        "texto_largo"  => $this->getTexto_largo(),
                        "id"           => $this->getId(),
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
        public function obtenerTodosPost(string $limit = NULL ){

                $sql = 'SELECT  TU.nombre AS nombreU, TU.email, TC.nombre AS categoria, TP.id, TP.titulo, TP.slug, TP.texto_corto, TP.texto_largo, TP.url_imagen, TP.fecha_creacion, TP.fecha_modificacion
                        FROM post TP
                        LEFT JOIN usuario TU ON (TP.USUARIO_id = TU.id)
                        LEFT JOIN categoria TC ON (TP.CATEGORIA_id = TC.id)
                        LEFT JOIN rol TR ON (TU.ROL_id = TR.id)
                        ';
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