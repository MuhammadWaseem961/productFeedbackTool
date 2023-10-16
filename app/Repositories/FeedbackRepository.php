<?php
    namespace App\Repositories;

    use App\Interfaces\EloquentRepositoryInterface;
    use App\Models\Feedback;
    use App\Traits\ImageUploadTrait;
    use Illuminate\Support\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\{Validator,DB};
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
            return $this->model->addSelect([
                "*",
                DB::raw('(
                    SELECT SUM(vote) 
                    FROM feedback_votes 
                    WHERE feedback_id = feedbacks.id
                ) as total_votes')
            ])->with(['user'=>function($user){
                $user->select(['id','name']);
            },'category'=>function($category){
                $category->select(['id','title']);
            },'product'=>function($product){
                $product->select(['id','title']);
            }])->withCount('votes')->get();    
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
            $feedback = $this->model->with(['user'=>function($user){
                $user->select(['id','name']);
            },'category'=>function($category){
                $category->select(['id','title']);
            },'product'=>function($product){
                $product->select(['id','title']);
            }])->addSelect([
                DB::raw('(
                    SELECT GROUP_CONCAT(user_id SEPARATOR ",") 
                    FROM feedback_votes 
                    WHERE feedback_id = feedbacks.id
                ) as user_ids'),
                DB::raw('(
                    SELECT SUM(vote) 
                    FROM feedback_votes 
                    WHERE feedback_id = feedbacks.id
                ) as total_votes')
            ])->find($feedback->id);
            broadcast(new NewFeedback($feedback))->toOthers();
            return $feedback;
        }

        /**
         * update Feedback
         */
        
        public function update($data,$id){
            return $this->model->find($id)->update($data);
        }

         /**
         * delete Feedback
         */
        
         public function delete($id){
            return $this->model->find($id)->delete();
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
         * get user's feedbacks
         */

         public function userFeedbacks($userID){
            return $this->model->with(['user'=>function($user){
                $user->select(['id','name']);
            },'category'=>function($category){
                $category->select(['id','title']);
            },'product'=>function($product){
                $product->select(['id','title']);
            }])->where('user_id',$userID)->get();
         }

    }