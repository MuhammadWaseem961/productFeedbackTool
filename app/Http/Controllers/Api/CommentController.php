<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\{UserRepository,ResponseRepository,CommentRepository};


class CommentController extends Controller
{
    private $responseRepository;
    private $commentRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository,CommentRepository $commentRepository,ResponseRepository $responseRepository){
        $this->responseRepository = $responseRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * create user feedback
    */
    public function store(Request $request){
        if(!$this->userRepository->isAuthenticated($request)){
            return $this->responseRepository->auth("Authentication failed please login");
        }
        
        $comment = $this->commentRepository->store($request);
        if(!is_null($comment)){
            return $this->responseRepository->success("Comment added successfully",$comment);
        }
    }
}
