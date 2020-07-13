<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Jobs\SendEmailNotify;
use App\Mail\UserLogin;
use App\Mail\UserRegister;
use App\Models\Address;
use App\Models\CodeVerify;
use App\User;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Location;
use Symfony\Component\Mime\Header\MailboxHeader;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register()
    {
        return response()->json(['result' => 'ok'], 200);
    }

    public function doRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4,max:15',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4|max:16',
        ]);
        if (!User::where('email', $request->input('email'))->first()) {
            $data = [
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ];
            User::create($data);
            return response()->json(['result' => 'Membership was successful'], 200);
        } else {
            return response()->json(['error' => 'Exist Email'], 404);
        }
    }

    public function checkFastLogin()
    {
        $user = new User();
        $username = $user->username;
        $password = $user->password;
        return response()->json([
            $username, $password
        ], 200);
    }

    public function page_password_resets()
    {
        return response()->json(['result' => 'ok'], 200);
    }

    public function password_resets(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);
        if ($user = User::where('email', $request->input('email'))->first()) {
            $code_verify = Str::random(5);
            $user->update([
                'password' => bcrypt($code_verify)
            ]);
//            CodeVerify::where('user_id', $user->id)->update([
//                'code_verify_login' => $code_verify,
//                'expired_at' => Carbon::now()->addSeconds(90),
//            ]);
            Mail::to($user->email)->send(new UserLogin($user));
            return response()->json(['result' => 'Sent codeVerify successfully'], 200);
        } else {
            return response()->json(['errorUser' => 'user noRegistered']);
        }
    }

    public function login()
    {
        return response()->json(['result' => 'ok'], 200);
    }

    public function doLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:4,max:12',
            'password' => 'required|min:5',
        ]);
        $remember = $request->has('remember');
        $credentials = request(['username', 'password']);
        if (Auth::attempt($credentials, $remember)) {
            $token = Auth::user()->createToken('Personal Access Token')->accessToken;
            return response()->json([
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'error' => 'Invalid username or password'
            ], 404);
        }

    }

    public function loginWithEmail(Request $request)
    {
        if ($user = User::where('email', $request->input('email'))->first()) {
            $code_verify = Str::random(5);
            $object = CodeVerify::create([
                'user_id' => $user->id,
                'code_verify_login' => $code_verify,
                'expired_at' => Carbon::now()->addSeconds(90)
            ]);
            Mail::to($user->email)->send(new UserLogin($user));
            $code = Str::random(40);
            $user->update([
                'code' => $code
            ]);
            return response()->json([
                'result' => 'Send CodeVerify With Email',
                'code' => $code
            ], 200);

        } else {
            return response()->json(['errorEmail' => 'Invalid Email'], 404);
        }

    }

    public function showloginWithEmail()
    {
        return response()->json(['result' => 'ok'], 200);
    }

    public function doLoginWithEmail(Request $request,$code)
    {
        $user = User::where('code', $code)->first();
        $time = $user->codeVerifies()->pluck('expired_at')->toArray();
        $object = new CodeVerify();
        if (Carbon::now()->toDateTimeString() < $time[0]) {
            $code_verify = $user->codeVerifies()->pluck('code_verify_login')->first();
            $code_email = $request->input('code_email');
            if ($code_email == $code_verify) {
                $newUser = Auth::loginUsingId($user->id);
                $token = $newUser->createToken('Personal Access Token')->accessToken;
                return response()->json(['token' => $token], 200);
            } else {
                return response()->json(['errorCode' => 'Invalid CodeVerify']);
            }
        } else {
            CodeVerify::where('user_id', $user->id)->delete();
            return response()->json(['errorTime' => 'Time is up'], 400);
        }
    }

    public function logOut(Request $request)
    {
         Auth::user()->token()->revoke();
        return response()->json(['message' => trans('api.user.logout.success')], 200);
    }

    public function authCheck()
    {
        if (Auth::check()){
            return response()->json(['result' => true],200);
        }
        if ($user=Auth::user() != null){
            return response()->json($user);
        }
            return response()->json(['message' =>'Unauthenticated'],400);
    }

}
