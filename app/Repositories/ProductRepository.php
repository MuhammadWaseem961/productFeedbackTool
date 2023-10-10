<?php
    namespace App\Repositories;

    use App\Models\Product;
    use Illuminate\Support\Collection;
    use Validator;

    class ProductRepository
    {
        /**
         * @var $model object of mod
         */
        public $model;

        /**
            * ProductRepository constructor.
            *
            * @param Product $model
            */
        public function __construct(Product $model)
        {
            $this->model = $model;
        }

         /**
            * @return Collection
        */
        public function all(): Collection
        {
            return $this->model->all();    
        }

        /*
            * list with specific columns
            * @return Collection
        */
        public function recordWithSpecificColumns($columns): Collection
        {
            return $this->model->select($columns)->get();    
        }

        /**
         * get product detail against slug of product
         */
        public function productDetail($columns,$slug){
            return $this->model->select($columns)->where('slug',$slug)->first();
        }
        
    }