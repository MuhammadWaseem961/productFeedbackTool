<?php
    namespace App\Repositories;

    use App\Interfaces\EloquentRepositoryInterface;
    use App\Models\FeedbackCategory;
    use Illuminate\Support\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Validator;

    class FeedbackCategoryRepository implements EloquentRepositoryInterface
    {
        /**
         * @var $model object of mod
         */
        public $model;

        /**
            * FeedbackCategoryRepository constructor.
            *
            * @param FeedbackCategory $model
            */
        public function __construct(FeedbackCategory $model)
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
            * @return Collection with pagination
        */
        public function paginate($perPage): LengthAwarePaginator 
        {
            return $this->model->paginate($perPage);    
        }

        /**
         * list of items or records with specific columns
         * @return Collection with pagination
        */
        public function recordsWithSpecificColumn($columns): Collection 
        {
            return $this->model->select($columns)->get();    
        }

        /**
         * create user
         */
        
        public function store($data){
           return $this->model->create($data);
        }

        /**
         * create user
         */
        
         public function update($data,$id){
            return $this->model->find($id)->update($data);
         }

        /**
         * data validations
         */
        public function validations($data,$rules){
            $validations = Validator::make($data,$rules);
            if($validations->fails()){
                return ['success'=>false,"errors"=>$validations->errors()];
            }
            return ['success'=>true];
        }

        /**
         * check record using id
         */
        public function findByID($id){
            return $this->model->find($id);
        }

    }