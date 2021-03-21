<?php 
    namespace View;

    class Redirect{

        /**
         * Metodo Contructor de la clase View
         * @access public
         */
        public function __construct(){
            $this->loadDocumentation();
        }

        /**
         * Función para cargar página HTML con la documentación 
         * en caso de que no se ingrese un endpoint válido
         * @access public 
         * @return HTML
         */
        public function loadDocumentation(){
            include 'documentacion/documentacion.php';
        }
    }