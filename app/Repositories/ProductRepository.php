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

        /**
         * get product detail against slug of product
         */
        public function productDetail($slug){
            return $this->model->where('slug',$slug)->first();
        }
        
    }