<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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

class AdminAuthController extends Controller
{
    public function index(){
        if(Auth::guard('admin')->check()){
            return redirect()->route("admin.dashboard");
        } else{
            return view("admin.index");
        }
    }
    
    public function login()
    {
        if(Auth::guard('admin')->check()){
            return redirect()->route("admin.dashboard");
        } else{
            return view("admin.auth.login");
        }
    }

    public function register()
    {
        if(Auth::guard('admin')->check()){
            return redirect()->route("admin.dashboard");
        } else{
            return view("admin.auth.register");
        }
    }

    public function postLogin(Request $request){
        $request->validate([
            "email" => "required|email|exists:admins,email",
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
            $admin = Admin::where("email", $request->email)->first();
            if($admin){
                $rememberMe = $request->remember ? true : false;
                if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                    $credentials["email"] = $request->email;
                }
                // else {
                //     $credentials['name'] = $request->email;
                // }
                $credentials["password"] = $request->password;
                if (Auth::guard("admin")->attempt($credentials)) {
                    $request->session()->regenerate();
                    $adminId = Auth::guard("admin")->user()->id;
                    // $loggedinTime = AdminHelper::getUTC();
                    // Admin::where('id', $adminId)->update([
                    //     'last_login' => $loggedinTime
                    // ]);
                    if($request->remember == "1"){
                        Admin::where("id",$adminId)->update(["remember_me"=>"1"]);
                    }
                    // if($admin->status != 1){
                    //     return response()->json(["error" => true, "message" => "User is not active yet!"], 404); 
                    // }
                    // if($admin->is_verified != 1){
                    //     return response()->json(["error" => true, "message" => "Kindly verify your account from your registered email!"], 404); 
                    // }
                    return response()->json(["success" => true, "message" => "Admin logged in successfully","url"=> route("admin.dashboard"), "id"=> $adminId], 200);
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
            "name" => "required",
            "email" => "required|email|unique:admins,email",
            "password" => "required|required_with:confirm_password|same:confirm_password|min:6",
            "confirm_password" => "required"
        ], [
            "name.required" => "Name is required",
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
            $register = new Admin([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"],
            ]);
            $register->save(); 
            if($register){
                if (!is_dir(storage_path("app/public/upload/admins/"))) {
                    mkdir(storage_path("app/public/upload/admins/"), 0755, true);
                }
                if($request->hasFile('image')){
                    $images = $request->file('image');
                    $img_name = Str::random(32).'.'.$images->getClientOriginalExtension();
                    $img_path = $request->file('image')->storeAs('upload/admins', $img_name,'public');
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
                //     $adminId = Auth::id();
                //     $loggedinTime = AdminHelper::getUTC();
                //     Admin::where('id', $adminId)->update([
                //         'last_login' => $loggedinTime
                //     ]);
                // }
                return response()->json(["success" => true, "message" => "Congratulations, you have Successfully registered","url"=> route("admin.login"), "id"=> $register->id], 200);
            } else{
                return response()->json(["error" => true, "message" => "Oops, account not created yet!, please try again"], 404);
            }
        } catch(Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 404);
        }
    }

    public function dashboard(){
        if(Auth::guard('admin')->check()){
            $id = Auth::guard("admin")->user()->id;
            $admin = Admin::where("id", $id)->whereNull("deleted_at")->first();
            if(!$admin){
                // return view("admin");
                return redirect()->route("admin");
            }
            return view("admin.dashboard" , compact("admin"));
        } else{
            return redirect()->route("admin.login");
        }
    }

    public function logout(){
        $value = Auth::guard("admin")->user()->id;
        Auth::guard("admin")->logout();
        return redirect()->route("admin.login");
    }
}
