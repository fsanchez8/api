<?php 
    /**
     * Archivo de Configuración
     */
    require_once './config/Config.php';
    use Route\Router;
    $run = new Router;
    $run->load();
    
    // echo phpinfo();