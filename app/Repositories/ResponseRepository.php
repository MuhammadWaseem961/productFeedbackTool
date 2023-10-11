<?php
    namespace App\Repositories;

    use App\Interfaces\ResponseInterface;

    class ResponseRepository implements ResponseInterface
    {
        /**
         * success response
         */
        
        public function success($message='',$data=[]){
           return response()->json(['success'=>true,"message"=>$message,"data"=>$data]);
        }

        /**
         * error response
         */
        
        public function error($message='',$errors=[]){
            return response()->json(['success'=>false,"message"=>$message,"errors"=>$errors]);
        }

        /**
         * error response
         */
        
        public function auth($message=''){
            return response()->json(["message"=>$message,"authentication"=>false]);
        }
    }