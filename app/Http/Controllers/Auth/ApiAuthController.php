<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\back\doctors;
use App\Models\back\gnr_m_areas;
use App\Models\back\gnr_m_patients;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'mother_name' => 'required',
            'mobile' => 'required',
            'birth_date' => 'required',
            'sex' => 'required',
            'blood' => 'required',
            'p_city' => 'required',
            'nationality' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError("V01", $validator->errors());
        }
        $newDate = Carbon::createFromFormat('m/d/Y', $request->birth_date)->format('Y-m-d');
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $verificationCode = mt_rand(1000, 9999);//Str::random_int(4);
        $input['verification_code'] = $verificationCode;
        $input['roles_name'] = 'Patient';
        $input['Status'] = 'مفعل';
        try {
            DB::transaction(function () use ($input, $newDate) {
                $user = User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => $input['password'],
                    'verification_code' => $input['verification_code'],
                    'roles_name' => $input['roles_name'],
                    'Status' => $input['Status'],
                ]);

                $patient = gnr_m_patients::create([

                    'f_name' => $input['name'],
                    'mother_name' => $input['mother_name'],
                    'mobile' => $input['mobile'],
                    'birth_date' => $newDate,
                    'sex' => $input['sex'],
                    'blood' => $input['blood'],
                    'p_city' => $input['p_city'],
                    'nationality' => $input['nationality'],
                    'address' => $input['address'],
                    'user_id' => $user->id,
                ]);
            });
            DB::commit();
            $user = User::where('email', $input['email'])->first();
            if ($request->phone != null) {
                $user->phone = $input['phone'];
                $user->save();
            }
            if ($request->date != null) {
                $user->date = $input['date'];
                $user->save();
            }
            $token = $user->createToken('Personal Access Token')->accessToken;
            $this->sendMail($user, $input['verification_code']);
            return $this->returnData("user_token", $token, 'registered successfully.,check your email to get verification code', "D00");
        } catch (\Exception $ex) {
            DB::rollback();
            return $this->returnError("D01", $ex->getMessage());
        }

    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->returnError("V00", $validator->errors());
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;
            return $this->returnData("user_token", $token, 'User login successfully.', "A00");
        } else {
            return $this->returnError('A01', 'Email or Password not correct');
        }
    }

    public function verify(Request $request): JsonResponse
    {
        $user = auth()->user();
        $code = $request->code;
        if ($code != $user->verification_code) {
            return $this->returnError("E03", "uncorrected code");
        } else {
            $user->email_verified_at = now();
            $user->save();
            return $this->returnSuccess("verification successfully");
        }

    }

    public function resend(): JsonResponse
    {
        $user = auth()->user();
        $code = $user->verification_code;
        if ($this->sendMail($user, $code)) {
            return $this->returnSuccess("verification code resend successfully");
        } else {
            return $this->returnError("E02", "something went wrong.. pleas try again");
        }
    }

    public function home(): JsonResponse
    {
        $user = auth()->user();
        if ($user->roles_name == 'Patient') {
            $patient = User::with('gnr_m_patients')->find($user->id);
            return $this->returnData("user", $patient, "patient");
        } else
            $doctor = User::with('doctor')->find($user->id);
        return $this->returnData("user", $doctor, 'doctor');

    }

    public function profile(): JsonResponse
    {
        $user = auth()->user();
        $role = $user->roles_name;
        $id = $user->id;
        if ($role == 'Patient') {
            $patient = gnr_m_patients::with('user')->where('user_id', $id)->first();
            return $this->returnData("patient", $patient, "patient", "D00");
        } elseif ($role == 'Doctor') {
            $doctor = doctors::with('user')->where('user_id', $id)->first();
            return $this->returnData("doctor", $doctor, "doctor", "D00");
        }
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
