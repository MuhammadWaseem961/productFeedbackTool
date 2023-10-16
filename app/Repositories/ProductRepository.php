<?php
    namespace App\Repositories;

    use App\Models\Product;
    use Illuminate\Support\Collection;
    use DB;

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
            $productDetail = $this->model
                ->select($columns)
                ->with(['feedbacks' => function ($feedback) {
                    $feedback->with(['comments'=>function($comment){
                        $comment->with(['user'=>function($user){
                            $user->select(['id','name']);
                        }]);
                    }])->addSelect([
                        '*',  // Add other columns you want to select from feedbacks
                    ])->addSelect([
                        DB::raw('(
                            SELECT GROUP_CONCAT(DISTINCT user_id SEPARATOR ",") 
                            FROM feedback_votes 
                            WHERE feedback_id = feedbacks.id
                        ) as user_ids'),
                        DB::raw('(
                            SELECT SUM(vote) 
                            FROM feedback_votes 
                            WHERE feedback_id = feedbacks.id
                        ) as total_votes')
                    ])->with(['category' => function ($category) {
                        $category->select(['id', 'title']);
                    },'user'=>function($user){
                        $user->select(['id','name']);
                    }]);
                }])
                ->where('slug', $slug)
                ->first();
            $productDetail['feedback_user_ids'] = $productDetail->feedbacksUsersID();
            return $productDetail;
        }
        
    }