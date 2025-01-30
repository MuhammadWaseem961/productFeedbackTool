<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\{UserRepository,ResponseRepository};
use Illuminate\Support\Facades\{Hash,Auth};
use App\Rules\MatchOldPassword;

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
        $validations = $this->userRepository->validations($request->all(),["name"=>'bail|required',"email"=>'bail|required|email|unique:users',"password"=>'bail|required|min:6']);
        // if validations fails then return error in response
        if(!$validations['success']){ return $this->responseRepository->error($validations['errors']);}
        // save user
        $user = $this->userRepository->store(array_merge($request->only(['name','email']),['password'=>Hash::make($request->password)]));
        // if user created successfully then return with success response
        if(!is_null($user)){
            // create token
            $token = $user->createToken(
                $user->name.'_'.Carbon::now(), // The name of the token
                ['*'],                         // Whatever abilities you want
                Carbon::now()->addHours(2)     // The expiration date
                // )->plainTextToken;
            );
            
            // send only specific property
            $user = $user->only(['id','name','email']);
            return $this->responseRepository->success("You have been registered successfully. Thanks!",array_merge($user,['token'=>$token]));
        }

        return $this->responseRepository->error("Something went wrong!");
    }

    /**
     * login user
     */
    public function login(Request $request){
        // validate the user input fields
        $validations = $this->userRepository->validations($request->all(),["email"=>'bail|required|email']);
        
        // if validations fails then return error in response
        if(!$validations['success']){ return $this->responseRepository->error("",$validations['errors']);}

        // check email if exists
        if($this->userRepository->findByEmail($request->email)==null){
            return $this->responseRepository->error("",["email"=>[$request->email." does not exist"]]);
        }

        if(Auth::attempt($request->only(['email','password']))){
            $user = $this->userRepository->findByEmail($request->email);
            // create token
            $userToken = $user->createToken(
                $user->name.'_'.Carbon::now(), // The name of the token
                ['*'],                         // Whatever abilities you want
                Carbon::now()->addHours(2)     // The expiration time
            );

            // redirect url of user according to user type
            $redirectUrl = $user->type=='1'?"adminDashboard":"userDashboard";

            // send only specific property
            $user = $user->only(['id','name','email','type']);
            return $this->responseRepository->success("You have been logged in successfully",array_merge($user,["redirectUrl"=>$redirectUrl,'token'=>$userToken->plainTextToken,"expire_at"=>strtotime($userToken->accessToken->expires_at)]));
        
        }else{
            return $this->responseRepository->error("",["email"=>["These credentials do not match our records."]]);
        }
    }

    /**
     * update user profile
     */
    public function profile(Request $request){
        // validate the user input fields
        $validations = $this->userRepository->validations($request->all(),["name"=>'bail|required',"email"=>'bail|required|email|unique:users,id,'.$request->id]);
        // if validations fails then return error in response
        if(!$validations['success']){ return $this->responseRepository->error("",$validations['errors']);}
        
        // update user profile
        $user = $this->userRepository->update($request->only(['name','email']),$request->id);
        if(!is_null($user)){
            $user = $this->userRepository->findByID($request->id);
            // create token
            $userToken = $user->createToken(
                $user->name.'_'.Carbon::now(), // The name of the token
                ['*'],                         // Whatever abilities you want
                Carbon::now()->addHours(2)     // The expiration time
            );
            $user = $user->only(['id','name','email']);
            return $this->responseRepository->success("Your profile has been updated successfully",array_merge($user,['token'=>$userToken->plainTextToken,"expire_at"=>strtotime($userToken->accessToken->expires_at)]));
        }
        return $this->responseRepository->error("Something went wrong!");
    }

    /**
     * update user password
     */
    public function changePasswrd(Request $request){
        return $this->responseRepository->auth("Authentication failed please login");
        if(!$this->userRepository->isAuthenticated($request)){
            return $this->responseRepository->auth("Authentication failed please login");
        }
        $user = $this->userRepository->findByID($request->id);
        // validate the user input fields
        $validations = $this->userRepository->validations($request->all(),["current_password"=>["required"],'password'=>"bail|required|min:6|confirmed",]);
        // if validations fails then return error in response
        if(!$validations['success']){ return $this->responseRepository->error("",$validations['errors']);}
        if(!Hash::check($request->current_password, $user->password)){ return $this->responseRepository->error("",["current_password"=>["Current password does not match"]]);}
              
        $user = $this->userRepository->update(['password'=>Hash::make($request->password)],$request->id);
        if(!is_null($user)){
            return $this->responseRepository->success("Your password has been updated successfully");
        }
        return $this->responseRepository->error("Something went wrong!");
    }

}
