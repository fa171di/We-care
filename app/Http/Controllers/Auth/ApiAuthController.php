<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\VerificationCodeMail;

class ApiAuthController extends Controller
{
    use ResponseTrait;


    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->returnError("E00",$validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $verificationCode = mt_rand(1000,9999);//Str::random_int(4);
        $input['verification_code'] = $verificationCode;
        $input['roles_name'] = 'Patient';
        $input['Status'] = 'مفعل';
        $user = User::create($input);
        $token =  $user->createToken('Personal Access Token')->accessToken;
        $this->sendMail($user, $verificationCode);
        return $this->returnData("user_token",$token, 'registered successfully.,check your email to get verification code');

    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->returnError("E00",$validator->errors());
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token= $user->createToken('MyApp')->accessToken;
            return $this->returnData("user_token",$token, 'User login successfully.');
        } else {
            return $this->returnError('E00', 'Unauthorised');
        }
    }

    public function verify(Request $request):JsonResponse{
        $user = auth()->user();
        $code = $request->code;
        if ($code!=$user->verification_code){
            return $this->returnError("E03","uncorrected code");
        }else{
            $user->email_verified_at= now();
            $user->save();
            return $this->returnSuccess("verification successfully");
        }

    }

    public function resend():JsonResponse{
        $user =auth()->user();
        $code = $user->verification_code;
        if ($this->sendMail($user, $code)){
            return $this->returnSuccess("verification code resend successfully");
        }else{
            return $this->returnError("E02","something went wrong.. pleas try again");
        }
    }

    public function home():JsonResponse{
            $user = auth()->user();
            if ($user->roles_name=='Patient'){
                $patient=User::with('gnr_m_patients')->find($user->id);
                return $this->returnData("user",$patient,"patient");
            }else
                $doctor = User::with('doctor')->find($user->id);
                return $this->returnData("user",$doctor,'doctor');

    }

    public function sendMail($user, $token)
    {
        Mail::send(
            'auth.verification_code',
            ['user' => $user, 'token' => $token],
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject("Verification Code");
            }
        );
        return true;
    }
}
