<?php 

    namespace App\interfaces;

    interface AuthInterface{
        public function auth(string $email, string $password);  
    }