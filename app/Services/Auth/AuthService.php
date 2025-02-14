<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    public function login(array $data): array
    {
        $user = User::query()->where('phone', $data['phone'])->where('status', 1)->first();
        if (!$user) throwError(__('errors.auth_failed'),401);
        if (!auth()->attempt(['phone' => $data['phone'], 'password' => $data['password']])) throwError(__('errors.auth_failed'),401);

        $token = $user->createToken('accessToken', expiresAt: Carbon::now()->addDay())->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];
    }

    public function loginWeb($request)
    {
        $request->validate([
            'phone'    => 'required|regex:/^(998)([0-9]{9})$/',
            'password' => 'required|string|min:6'
        ]);

        $phone = $request->get('phone');
        $password = $request->get('password');

        if (Auth::attempt(['phone' => $phone, 'password' => $password, 'id' => 1])) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['auth' => 'Login yoki parol xato']);
    }

    public function logout(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
