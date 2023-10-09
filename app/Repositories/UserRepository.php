<?php
    namespace App\Repositories;

    use Illuminate\Database\Eloquent\Model;
    use App\Interfaces\EloquentRepositoryInterface;
    use App\Models\User;
use GuzzleHttp\Psr7\Request;
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


         /**
         * check record using email
         */
        public function findByEmail($email){
            return $this->model->where('email',$email)->first();
        }
    }