<?php
    namespace App\Repositories;

    use App\Interfaces\EloquentRepositoryInterface;
    use App\Models\FeedbackVote;
    use Illuminate\Support\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\{Validator,DB};
    // use App\Events\NewFeedback;

    class FeedbackVoteRepository implements EloquentRepositoryInterface
    {
        /**
         * @var $model object of mod
         */
        public $model;

        /**
            * FeedbackRepository constructor.
            *
            * @param Feedback $model
            */
        public function __construct(FeedbackVote $model)
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
            $feedbackVote = $this->model->create($data);
            $feedbackVote = $this->model->addSelect([
                "*",
                DB::raw("(
                    SELECT SUM(vote) 
                    FROM feedback_votes 
                    WHERE feedback_id = $feedbackVote->feedback_id
                ) as total_votes")
            ])->find($feedbackVote->id);
            // broadcast(new NewFeedback($feedback))->toOthers();
            return $feedbackVote;
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