<?php
    namespace App\Repositories;

    use Illuminate\Database\Eloquent\Model;
    use App\Interfaces\EloquentRepositoryInterface;
    use App\Models\User;
    use Illuminate\Support\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Validator;

    class UserRepository implements EloquentRepositoryInterface
    {
        /**
         * @var $model object of mod
         */
        public $model;

        /**
            * UserRepository constructor.
            *
            * @param User $model
            */
        public function __construct(User $model)
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
         * create user
         */
        
        public function store($data){
           return $this->model->create($data);
        }

        /**
         * data validations
         */
        public function validations($data){
            $validations = Validator::make($data,$this->rules());
            if($validations->fails()){
                return ['success'=>false,"errors"=>$validations->errors()];
            }
            return ['success'=>true];
        }

        /**
         * data validations rules
         */
        public function rules(){
            return [
                "name"=>'bail|required',
                "email"=>'bail|required|email|unique:users',
                "password"=>'bail|required|min:6',
            ];
        }
    }