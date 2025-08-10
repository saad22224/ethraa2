<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserLogin;
use App\Models\DeviceToken;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'national_id_front' => 'required|file|image',
                'national_id_back' => 'required|file|image',
                'password' => 'required|min:8',
            ]);

            $unverifieduser = User::where('phone', $request->phone)
                ->where('is_verified', 0)
                ->first();
            $verifieduser = User::where('phone', $request->phone)
                ->where('is_verified', 1)
                ->first();


            if ($unverifieduser) {
                $unverifieduser->delete();
            }else if($verifieduser){
                return response()->json([
                    'error' => 'المستخدم موجود بالفعل',
                ]);
            }

            $user = User::create([
                'user_identifier' => rand(100000, 999999),
                'name' => $request->name,
                'email' => $request->email,
                'country_code' => $request->country_code,
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
                'recipient' => $request->country_code . $request->phone,
                'type' => 'otp',
                'code' => $verificationCode,
                'channel' => 'whatsapp',
            ]);





            return response()->json([
                'message' => 'تم إرسال كود التحقق إلى  واتساب.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
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

            $user = User::where('email', $email)
                ->where('verification_code', $code)
                ->first();

            if (!$user) {
                return response()->json(['error' => 'الكود غير صحيح أو البريد غير موجود.'], 400);
            }

            $user->is_verified = true;
            $user->verification_code = null;

            // $secret = env('STRIGA_SECRET');
            // $apiKey = env('STRIGA_API_KEY');
            // $method = 'POST';
            // $endpoint = '/user/create';
            // $body = [
            //     "firstName" => $user->name,
            //     "lastName" => $user->name,
            //     "email" => $user->email,
            //     "mobile" => [
            //         "countryCode" => $user->country_code,
            //         "number" => $user->phone
            //     ],
            //     "address" => [
            //         "addressLine1" => "Test Street",
            //         "city" => "Cairo",
            //         "country" => "EG",
            //         "postalCode" => "12345"
            //     ]
            // ];

            // $timestamp = (string) round(microtime(true) * 1000); // مللي ثانية
            // $bodyHash = md5(json_encode($body));

            // $stringToSign = $timestamp . $method . $endpoint . $bodyHash;
            // $signature = hash_hmac('sha256', $stringToSign, $secret);
            // $authorizationHeader = 'HMAC ' . $timestamp . ':' . $signature;

            // $response = Http::withHeaders([
            //     'Authorization' => $authorizationHeader,
            //     'api-key' => $apiKey,
            //     'Content-Type' => 'application/json',
            // ])->post('https://www.sandbox.striga.com/api/v1' . $endpoint, $body);

            // \Log::info("Generated timestamp: {$timestamp}");
            // \Log::info("Authorization: {$authorizationHeader}");
            // \Log::info("Response: " . $response);



            // $customer_id = $response->json('userId');

            // $user->striga_customer_id = $customer_id;



            // // ⚠️ بدء عملية KYC بعد إنشاء المستخدم
            // $kyc_endpoint = '/user/kyc/start';
            // $kyc_body = [
            //     "userId" => $customer_id
            // ];

            // $kyc_timestamp = (string) round(microtime(true) * 1000);
            // $kyc_bodyHash = md5(json_encode($kyc_body));
            // $kyc_stringToSign = $kyc_timestamp . 'POST' . $kyc_endpoint . $kyc_bodyHash;
            // $kyc_signature = hash_hmac('sha256', $kyc_stringToSign, $secret);
            // $kyc_authorizationHeader = 'HMAC ' . $kyc_timestamp . ':' . $kyc_signature;

            // $kyc_response = Http::withHeaders([
            //     'Authorization' => $kyc_authorizationHeader,
            //     'api-key' => $apiKey,
            //     'Content-Type' => 'application/json',
            // ])->post('https://www.sandbox.striga.com/server/api/v0' . $kyc_endpoint, $kyc_body);

            // \Log::info("KYC Response: " . $kyc_response->body());
            // $user->kyc_verification_link = $kyc_response->json('verificationLink');


            // $verificationLink = $user->kyc_verification_link;

            $token = $user->createToken('auth_token')->plainTextToken;
            $user->save();
            Mail::to($request->email)->send(new UserLogin($user->name));

            return response()->json([
                'message' => 'User verified and registered on Striga',
                // 'kyc_link' => $verificationLink,
                'token' => $token,
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'حدث خطأ داخلي',
                'error' => $e->getMessage(),
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

    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // حذف التوكن الحالي فقط
        $user->currentAccessToken()?->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function me(Request $request)
    {
        return response()->json($request->user());
    }
    public function refresh(Request $request)
    {
        $user = $request->user();

        // حذف التوكن الحالي
        $user->currentAccessToken()?->delete();

        // إنشاء توكن جديد
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Token refreshed successfully',
            'token' => $token,
            'user' => $user
        ], 200);
    }


    public function deviceToken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);

        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'error' => 'User not authenticated',
            ], 401);
        }
        DeviceToken::updateOrCreate(
            ['user_id' => $user->id],
            ['device_token' => $request->device_token]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Device token saved successfully',
        ]);
    }



    public function delete(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'error' => 'user not found'
            ]);
        }




        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
