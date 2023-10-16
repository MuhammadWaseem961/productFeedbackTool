<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Repositories\{FeedbackRepository,UserRepository,ResponseRepository,FeedbackVoteRepository};


class FeedbackController extends Controller
{
    /**
     * @var $feedbackRepository object FeedbackRepository
     */
    private $feedbackRepository;
    private $responseRepository;
    private $userRepository;
    private $feedbackVoteRepository;

    public function __construct(UserRepository $userRepository,FeedbackVoteRepository $feedbackVoteRepository,FeedbackRepository $feedbackRepository,ResponseRepository $responseRepository){
        $this->feedbackRepository = $feedbackRepository;
        $this->responseRepository = $responseRepository;
        $this->userRepository = $userRepository;
        $this->feedbackVoteRepository = $feedbackVoteRepository;
    }

    /**
     * get list of feedbacks
     */
    public function all(Request $request){
        if(!$this->userRepository->isAuthenticated($request)){
            return $this->responseRepository->auth("Authentication failed please login");
        }
        return $this->responseRepository->success('',$this->feedbackRepository->all());
    }

    /**
     * create user feedback
    */
    public function store(Request $request){
        if(!$this->userRepository->isAuthenticated($request)){
            return $this->responseRepository->auth("Authentication failed please login");
        }
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
     * update user feedback
    */
    public function update(Request $request,$id){
        if(!$this->userRepository->isAuthenticated($request)){
            return $this->responseRepository->auth("Authentication failed please login");
        }
        // validate the user input fields
        $validations = $this->feedbackRepository->validations($request->all(),["title"=>'bail|required',"feedback_category_id"=>'bail|required|',"description"=>'bail|required']);
        // if validations fails then return error in response
        if(!$validations['success']){ return $this->responseRepository->error("",$validations['errors']);}
        $feedback = $this->feedbackRepository->update($request,$id);
        if(!is_null($feedback)){
            return $this->responseRepository->success("Feedback has been updated successfully",$feedback);
        }
    }

    /**
     * get list of user's feedbacks
     */
    public function userFeedbacks(Request $request){
        if($this->userRepository->isAuthenticated($request)=='false'){
            return $this->responseRepository->auth("Authentication failed please login");
        }
        return $this->responseRepository->success('',$this->feedbackRepository->userFeedbacks($request->header('id')));
    }

    /**
     * add user feedback vote
     */
    public function addFeedbackVote(Request $request){
        if(!$this->userRepository->isAuthenticated($request)){
            return $this->responseRepository->auth("Authentication failed please login");
        }
        $feedbackVote = $this->feedbackVoteRepository->store($request->all());
        if(!is_null($feedbackVote)){
            return $this->responseRepository->success('',$feedbackVote);
        }
    }

    /**
     * delete feedback
     */
    public function delete($id){
        $feedback = $this->feedbackRepository->delete($id);
        if($feedback){
            return $this->responseRepository->success('Feedback has been deleted successfully',$feedback);
        }
    }
}
