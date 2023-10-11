<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Repositories\{FeedbackRepository,UserRepository,ResponseRepository};


class FeedbackController extends Controller
{
    /**
     * @var $feedbackRepository object FeedbackRepository
     */
    private $feedbackRepository;
    private $responseRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository,FeedbackRepository $feedbackRepository,ResponseRepository $responseRepository){
        $this->feedbackRepository = $feedbackRepository;
        $this->responseRepository = $responseRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * create user feedback
    */
    public function store(Request $request){
       
        // validate the user input fields
        $validations = $this->feedbackRepository->validations($request->all(),["title"=>'bail|required',"feedback_category_id"=>'bail|required|',"description"=>'bail|required']);
        // if validations fails then return error in response
        if(!$validations['success']){ return $this->responseRepository->error("",$validations['errors']);}
        $feedback = $this->feedbackRepository->store($request);
        if(!is_null($feedback)){
            return $this->responseRepository->success("Feedback added successfully",$feedback);
        }
    }

    /**
     * get list of user's feedbacks
     */
    public function userFeedbacks(Request $request){
        if(!$this->userRepository->isAuthenticated($request)){
            return $this->responseRepository->auth("Authentication failed please login");
        }
        return $this->responseRepository->success('',$this->feedbackRepository->userFeedbacks($request->header('id')));
    }
}
