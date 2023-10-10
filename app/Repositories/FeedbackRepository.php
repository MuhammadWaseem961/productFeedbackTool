<?php
    namespace App\Repositories;

    use App\Interfaces\EloquentRepositoryInterface;
    use App\Models\Feedback;
    use App\Traits\ImageUploadTrait;
    use Illuminate\Support\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Validator;
    use App\Events\NewFeedback;

    class FeedbackRepository implements EloquentRepositoryInterface
    {
        use ImageUploadTrait;
        /**
         * @var $model object of mod
         */
        public $model;

        /**
            * FeedbackRepository constructor.
            *
            * @param Feedback $model
            */
        public function __construct(Feedback $model)
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
        
        public function store($request){
            $data = $request->except('files');
            if(count($request->files)>0){
                $data['files'] = json_encode($this->uploadMultipleFiles($request,'uploads/feedbacks'));
            }
            $feedback = $this->model->create($data);
            broadcast(new NewFeedback($feedback))->toOthers();
            return $feedback;
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