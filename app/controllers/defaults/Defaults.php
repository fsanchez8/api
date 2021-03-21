<?php 

    namespace App\controllers\defaults;
    use Fx\Functions;
    use View\Redirect;
    class Defaults{

        /**
         * Función para cargar la vista por defecto
         * @access public 
         * @param 
         * @return views
         */
        public function defaultViews(string $view){
            Functions::header_html();
            $load_documentation =  Redirect::loadDocumentation();
            
        }

    }