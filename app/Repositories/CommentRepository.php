<?php
    namespace App\Repositories;

    use App\Interfaces\EloquentRepositoryInterface;
    use App\Models\Comment;
    use Illuminate\Support\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\{Validator};
    use App\Events\{NewComment as NewCommentEvent,NewCommentNotification};
    use App\Notifications\NewComment;

    class CommentRepository implements EloquentRepositoryInterface
    {
        /**
         * @var $model object of mod
         */
        public $model;
        public $feedbackRepository;
        public $userRepository;

        /**
            * FeedbackRepository constructor.
            *
            * @param Feedback $model
            */
        public function __construct(Comment $model,FeedbackRepository $feedbackRepository,UserRepository $userRepository)
        {
            $this->model = $model;
            $this->feedbackRepository= $feedbackRepository;
            $this->userRepository= $userRepository;
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
            $comment = $this->model->create($request->all());
            $feedback = $this->feedbackRepository->findByID($comment->feedback_id);
            $user = $this->userRepository->findByID($feedback->user_id);
            $user->notify(new NewComment($comment));
            broadcast(new NewCommentEvent($comment))->toOthers();
            broadcast(new NewCommentNotification($comment))->toOthers();
            return $comment;
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