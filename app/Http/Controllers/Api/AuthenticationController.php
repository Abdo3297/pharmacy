<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Notifications\NewUserNotification;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Ichtrojan\Otp\Otp;
use App\Mail\sendOTPMail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Jobs\newUserRegisterTokenJob;
use App\Http\Resources\Api\UserResource;
use App\Http\Requests\Api\checkOTPRequest;
use App\Http\Requests\Api\registerRequest;
use App\Http\Requests\Api\resendOTPRequest;
use App\Http\Requests\Api\loginEmailRequest;
use App\Http\Requests\Api\loginPhoneRequest;
// use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Api\resetPasswordRequest;
use App\Http\Requests\Api\updateProfileRequest;
use App\Http\Requests\Api\changePasswordRequest;

// use Filament\Notifications\Notification;

class AuthenticationController extends Controller
{
    public function register(registerRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        \Illuminate\Support\Facades\Notification::send($user, new NewUserNotification($user));
        \Filament\Notifications\Notification::make()
            ->icon('heroicon-o-user-plus')
            ->iconColor('primary')
            ->title('New User In Your Pharmacy')
            ->body('Name : ' . $user->name . ' & Email : ' . $user->email)
            ->broadcast(User::where("is_admin", true)->first());
        return ResponseHelper::finalResponse(
            'new user created successfully , check your email',
            UserResource::make($user),
            true,
            Response::HTTP_CREATED
        );
    }
    public function checkRegisterOTP(checkOTPRequest $request)
    {
        $data = $request->validated();
        $user = User::whereEmail($data['email'])->first();
        $otp = (new Otp)->validate($data['email'], $data['otp']);
        if (!$otp->status) {
            return ResponseHelper::finalResponse(
                'OTP Not Valid',
                null,
                true,
                Response::HTTP_OK
            );
        }
        DB::table('otps')
            ->where('identifier', $data['email'])
            ->where('token', $data['otp'])
            ->update(['valid' => 1]);
        User::whereEmail($data['email'])->update([
            'email_verified_at' => now()
        ]);
        $token = $user->createToken('app')->plainTextToken;
        return ResponseHelper::finalResponse(
            'OTP Valid and Email Verified',
            [
                'token' => $token,
            ],
            true,
            Response::HTTP_OK
        );
    }
    public function sendOTP(resendOTPRequest $request)
    {
        $data = $request->validated();
        $user = User::whereEmail($data['email'])->first();
        \Illuminate\Support\Facades\Notification::send($user, new NewUserNotification($user));
        return ResponseHelper::finalResponse(
            'OTP Resend Successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }
    public function checkOTP(checkOTPRequest $request)
    {
        $data = $request->validated();
        $otp = (new Otp)->validate($data['email'], $data['otp']);
        if (!$otp->status) {
            return ResponseHelper::finalResponse(
                'OTP Not Valid',
                null,
                true,
                Response::HTTP_OK
            );
        }
        DB::table('otps')
            ->where('identifier', $data['email'])
            ->where('token', $data['otp'])
            ->update(['valid' => 1]);
        return ResponseHelper::finalResponse(
            'OTP Valid',
            null,
            true,
            Response::HTTP_OK
        );
    }
    public function resetPassword(resetPasswordRequest $request)
    {
        $data = $request->validated();
        $user = User::whereEmail($data['email'])->first();
        $otp = (new Otp)->validate($user->email, $data['otp']);
        if (!$otp->status) {
            return ResponseHelper::finalResponse(
                'OTP Not Valid',
                null,
                true,
                Response::HTTP_OK
            );
        }
        $user->update([
            'password' => bcrypt($data['password'])
        ]);
        $user->tokens()->delete();
        return ResponseHelper::finalResponse(
            'password reset successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }
    public function loginEmail(loginEmailRequest $request)
    {
        $data = $request->validated();
        if (auth()->attempt($data)) {
            $user = User::find(auth()->user()->id);
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;
            return ResponseHelper::finalResponse(
                'user logged in successfully',
                UserResource::make($user),
                true,
                Response::HTTP_OK
            );
        }
        return ResponseHelper::finalResponse(
            'user credentials doesn\'t exists',
            null,
            true,
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function loginPhone(loginPhoneRequest $request)
    {
        $data = $request->validated();
        if (auth()->attempt($data)) {
            $user = User::find(auth()->user()->id);
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;
            return ResponseHelper::finalResponse(
                'user logged in successfully',
                UserResource::make($user),
                true,
                Response::HTTP_OK
            );
        }
        return ResponseHelper::finalResponse(
            'user credentials doesn\'t exists',
            null,
            true,
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function logoutFromCurrentDevices(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ResponseHelper::finalResponse(
            'user logged out From Current Device successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }
    public function logoutFromAllDevices(Request $request)
    {
        $request->user()->tokens()->delete();
        return ResponseHelper::finalResponse(
            'user logged out From All Devices successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }
    public function updateProfile(updateProfileRequest $request)
    {
        $data = $request->validated();
        $user = User::find(auth()->user()->id);
        $user->update($data);
        if ($request->hasFile('image')) {
            $user->clearMediaCollection('userProfile');
            $user->addMediaFromRequest('image')->toMediaCollection('userProfile');
        }
        return ResponseHelper::finalResponse(
            'profile updated successfully',
            UserResource::make($user),
            true,
            Response::HTTP_OK
        );
    }
    public function changePassword(changePasswordRequest $request)
    {
        $data = $request->validated();
        $user = User::find(auth()->user()->id);
        if (!Hash::check($data['current_password'], $user->password)) {
            return ResponseHelper::finalResponse(
                'not valid password',
                null,
                true,
                Response::HTTP_OK
            );
        }
        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);
        return ResponseHelper::finalResponse(
            'password change successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }

    public function deleteProfile()
    {
        $user = User::find(auth()->user()->id);
        $user->tokens()->delete();
        $user->delete();
        \Filament\Notifications\Notification::make()
            ->icon('heroicon-o-user-minus')
            ->iconColor('danger')
            ->title('User Leaved Your Pharmacy')
            ->body('Name : ' . $user->name . ' & Email : ' . $user->email . ' & Phone : ' . $user->phone)
            ->broadcast(User::where("is_admin", true)->first());
        return ResponseHelper::finalResponse(
            'account deleted successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }
}
