<?php

    namespace App\Interfaces;
    use Illuminate\Http\Request;

    interface ResponseInterface{
        /**
         * success method
         */
        public function success($message='',$data=null);

        /**
         * error method
         */
        public function error($message='',$errors=null);


        

        
    }