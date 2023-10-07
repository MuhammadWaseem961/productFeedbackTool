<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\{UserRepository,ResponseRepository};
use Hash;
class UserController extends Controller
{
    /**
     * @var $userRepository object UserRepository
     */
    private $userRepository;
    private $responseRepository;

    public function __construct(UserRepository $userRepository,ResponseRepository $responseRepository){
        $this->userRepository = $userRepository;
        $this->responseRepository = $responseRepository;
    }

    /**
     * register user
    */
    public function register(Request $request){
        // validate the user input fields
        $validations = $this->userRepository->validations($request->all());
        // if validations fails then return error in response
        if(!$validations['success']){ return $this->responseRepository->error("",$validations['errors']);}
        // save user
        $user = $this->userRepository->store(array_merge($request->only(['name','email']),['password'=>Hash::make($request->password)]));
        // if user created successfully then return with success response
        if(!is_null($user)){
            // create token
            $token = $user->createToken(
                $user->name.'_'.Carbon::now(), // The name of the token
                ['*'],                         // Whatever abilities you want
                Carbon::now()->addDays(6)     // The expiration date
                )->plainTextToken;
                
            // send only specific property
            $user = $user->only(['id','name']);
            return $this->responseRepository->success("You have been registered successfully. Thanks!",array_merge($user,['token'=>$token]));
        }

        return $this->responseRepository->error("Something went wrong!");
    }

}
