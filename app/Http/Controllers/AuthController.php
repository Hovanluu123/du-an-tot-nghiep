<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResendVerificationRequest;
use App\Support\ApiResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        $user->sendEmailVerificationNotification();

        return ApiResponse::created([
            'user' => $user,
        ], 'Đăng ký thành công. Vui lòng xác thực email.');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();
        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return ApiResponse::error('Tài khoản hoặc mật khẩu không chính xác', 401);
        }
        if (is_null($user->email_verified_at)) {
            return ApiResponse::error('Email chưa được xác thực', 403);
        }
        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return ApiResponse::error('Tài khoản hoặc mật khẩu không chính xác', 401);
        }

        return $this->respondWithToken($token);
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::find($id);
        if (! $user) {
            return ApiResponse::error('User không tồn tại', 404);
        }
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return ApiResponse::error('Link xác thực không hợp lệ', 400);
        }
        if ($user->hasVerifiedEmail()) {
            return ApiResponse::success(null, 'Email đã được xác thực');
        }
        $user->markEmailAsVerified();
        event(new Verified($user));
        return ApiResponse::success(null, 'Email đã được xác thực thành công');
    }

    public function resend(ResendVerificationRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (! $user) {
            return ApiResponse::error('User không tồn tại', 404);
        }
        if ($user->hasVerifiedEmail()) {
            return ApiResponse::success(null, 'Email đã được xác thực');
        }
        $user->sendEmailVerificationNotification();
        return ApiResponse::success(null, 'Email xác thực đã được gửi');
    }

    public function me()
    {
        return ApiResponse::success(Auth::guard('api')->user());
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return ApiResponse::success(null, 'Đăng xuất thành công');
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    protected function respondWithToken(string $token)
    {
        return ApiResponse::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user(),
        ]);
    }
}
