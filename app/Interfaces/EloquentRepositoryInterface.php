<?php

    namespace App\Interfaces;
    use Illuminate\Http\Request;

    interface EloquentRepositoryInterface{
        /**
         * return all records of model
         */
        public function all();

        /**
         * get records of model using paginate
         */
        public function paginate($perPage);

         /**
         * store model record
         */
        public function store($data);

        /**
         * data validations
         */
        public function validations($data);

        /**
         * data validations rules
         */
        public function rules();

        
    }