<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class WebAuthController extends Controller
{
    public  function __construct() {
    }

    public function index(){
        if(Auth::check()){
            return redirect()->route("home.dashboard");
        } else{
            return view("home");
        }
    }
    
    public function login()
    {
        if(Auth::check()){
            return redirect()->route("home.dashboard");
        } else{
            return view("auth.login");
        }
    }

    public function register()
    {
        if(Auth::check()){
            return redirect()->route("home.dashboard");
        } else{
            return view("auth.register");
        }
    }

    public function postLogin(Request $request){
        $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required|min:6",
        ]);

        // $credentials = $request->only("email", "password");
        $credentials = [
            "email" => "",
            "password" => "",
            // "status" => 1,
            // "is_verified" => 1
        ];
        try{
            $user = User::where("email", $request->email)->first();
            if($user){
                $rememberMe = $request->remember ? true : false;
                if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $credentials["email"] = $request->email;
                }
                // else {
                //     $credentials['name'] = $request->email;
                // }
                $credentials["password"] = $request->password;
                if(Auth::attempt($credentials, $rememberMe)){
                    $request->session()->regenerate();
                    $userId = Auth::id();
                    // $loggedinTime = AdminHelper::getUTC();
                    // User::where('id', $userId)->update([
                    //     'last_login' => $loggedinTime
                    // ]);
                    if($request->remember == "1"){
                        User::where("id",$userId)->update(["remember_me"=>"1"]);
                    }
                    // if($user->status != 1){
                    //     return response()->json(["error" => true, "message" => "User is not active yet!"], 404); 
                    // }
                    // if($user->is_verified != 1){
                    //     return response()->json(["error" => true, "message" => "Kindly verify your account from your registered email!"], 404); 
                    // }
                    return response()->json(["success" => true, "message" => "User logged in successfully","url"=> route("home"), "id"=> $userId], 200);
                }
                else{
                    return response()->json(["error" => true, "message" => "Login details are not valid"], 404); 
                }
            } else{
                return response()->json(['error' => true, 'message' => 'Email or username does not exist'], 404);
            }
        } catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 404);
        }
    }

    public function postRegistration(Request $request){
        $request->validate([
            "first_name" => "required",
            "phone" => "required|min:10|max:10",
            "email" => "required|email|unique:users,email",
            "password" => "required|required_with:confirm_password|same:confirm_password|min:6",
            "confirm_password" => "required"
        ], [
            "first_name.required" => "First Name is required",
            "email.required" => "Email is required",
            "email.email" => "Invalid email",
            "email.unique" => "Email account already register with us",
            "password.required" => "Password is required",
            "password.required_with" => "Confirm password is required",
            "password.same" => "Confirm password does not match",
            "confirm_password.required" => "Confirm password is required"
        ]);

        try{
            $data = $request->all();
            $credentials = [
                'email' => "",
                'password' => "",
            ];
            $register = new User([
                "first_name" => $data["first_name"],
                "last_name" => $data["last_name"],
                "email" => $data["email"],
                "phone" => $data["phone"],
                "password" => $data["password"],
            ]);
            $register->save(); 
            if($register){
                if (!is_dir(storage_path("app/public/upload/users/"))) {
                    mkdir(storage_path("app/public/upload/users/"), 0755, true);
                }
                if($request->hasFile('image')){
                    $images = $request->file('image');
                    $img_name = Str::random(32).'.'.$images->getClientOriginalExtension();
                    $img_path = $request->file('image')->storeAs('upload/categories', $img_name,'public');
                    $profilePath = "storage/".$img_path;
                } else {
                    // $profilePath = "assets/images/category_sample.jpg";
                }
                // $register->image = $profilePath;
                // $register->save();
                
                $credentials['email'] = $request->email;
                $credentials['password'] = $request->password;
                // if(Auth::attempt($credentials)){
                //     $request->session()->regenerate();
                //     $userId = Auth::id();
                //     $loggedinTime = AdminHelper::getUTC();
                //     User::where('id', $userId)->update([
                //         'last_login' => $loggedinTime
                //     ]);
                // }
                return response()->json(["success" => true, "message" => "Congratulations, you have Successfully registered","url"=> route("home.dashboard"), "id"=> $register->id], 200);
            } else{
                return response()->json(["error" => true, "message" => "Oops, account not created yet!, please try again"], 404);
            }
        } catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 404);
        }
    }

    public function dashboard(){
        $user = User::where("id", Auth::id())->whereNull("deleted_at")->first();
        if(!$user){
            // return view("home");
            return redirect()->route("home");
        }
        return view("dashboard" , compact("user"));
    }

    public function logout(){
        if(Auth::check()){
            Session::flush();
            Auth::logout();
            // For remember me thing
            // DB::table("users")->where("id",Auth::id())->update(["remember"=>"0"]);
        }
        return redirect()->route("home");
    }
}
