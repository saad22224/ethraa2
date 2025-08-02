<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric',
                'national_id_front' => 'required|file|image',
                'national_id_back' => 'required|file|image',
                'password' => 'required|min:8',
            ]);

            $user = User::create([
                'user_identifier' => rand(100000, 999999),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            if ($request->hasFile('national_id_front')) {
                $file = $request->file('national_id_front');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('national_id_front', $name, 'public');
                $user->national_id_front = $path;
            }

            if ($request->hasFile('national_id_back')) {
                $file = $request->file('national_id_back');
                $name = $file->getClientOriginalName();
                $path = $file->storeAs('national_id_back', $name, 'public');
                $user->national_id_back = $path;
            }


            $verificationCode = rand(100000, 999999);
            $user->verification_code = $verificationCode;
            $user->save();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer 121$EbuaGQzqXMqhseLLruhtGeRDtPFmiEQHIWdl',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api.verifyway.com/api/v1/', [
                'recipient' => $request->phone,
                'type' => 'otp',
                'code' => $verificationCode,
                'channel' => 'whatsapp',
            ]);

            return response()->json([
                'message' => 'تم إرسال كود التحقق إلى  واتساب.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function verifyCode(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'code' => 'required|string',
            ]);


            $email = trim($request->email);
            $code = trim($request->code);

            \Log::info('Verifying user', ['email' => $email, 'code' => $code]);

            $user = User::where('email', $email)
                ->where('verification_code', $code)
                ->first();

            if (!$user) {
                \Log::warning('Verification failed', [
                    'email' => $email,
                    'code' => $code,
                    'user_found_with_email' => User::where('email', $email)->first(),
                ]);
                return response()->json(['error' => 'الكود غير صحيح أو البريد غير موجود.'], 400);
            }

            $user->is_verified = true;
            $user->verification_code = null;
            $user->save();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'User verified successfully',
                'token' => $token,
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }



    public function resendVerificationCode(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);
        \Log::info($request->phone);
        // البحث عن المستخدم بناءً على البريد
        $user = User::where('phone', $request->phone)->first();
        \Log::info($user);
        if (!$user) {
            return response()->json(['error' => 'رقم الهاتف  غير موجود.'], 400);
        }

        // توليد كود التحقق جديد
        $verificationCode = rand(100000, 999999); // مثال: "a8B3fK"
        $user->verification_code = $verificationCode;
        $user->save();

        // Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
        $response = Http::withHeaders([
            'Authorization' => 'Bearer 121$EbuaGQzqXMqhseLLruhtGeRDtPFmiEQHIWdl',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.verifyway.com/api/v1/', [
            'recipient' => $request->phone, // تأكد من التنسيق الدولي (مثال: 9665xxxxxxx للسعودية)
            'type' => 'otp',
            'code' => $verificationCode,
            'channel' => 'whatsapp',
        ]);

        return response()->json([
            'message' => 'تم إرسال كود التحقق إلى  واتساب.',
        ]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');
        $credentials['is_verified'] = 1; // تأكد أن المستخدم مفعل

        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'اسم المستخدم او كلمة المرور غير صحيحة'], 401);
        }

        $user = auth()->user(); // المستخدم المسجل حالياً
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'user' => $user
        ], 200);
    }
}
