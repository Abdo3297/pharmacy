<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

class SocialiteAuthenticationController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $socialiteUser = Socialite::driver('google')->user();
        $user = User::updateOrCreate([
            'provider' => 'google',
            'provider_id' => $socialiteUser->getId(),
        ], [
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail(),
            'email_verified_at' => now(),
        ]);
        if ($user->wasRecentlyCreated) {
            $admin = User::where('is_admin', true)->first();
            \Filament\Notifications\Notification::make()
                ->icon('heroicon-o-user-plus')
                ->iconColor('primary')
                ->title('New User In Your Pharmacy')
                ->body('Name : '.$user->name.' & Email : '.$user->email)
                ->sendToDatabase($admin);
            event(new DatabaseNotificationsSent($admin));
        }
        $sanctum_token = $user->createToken('app')->plainTextToken;
        $user->addMediaFromUrl($socialiteUser->getAvatar())->toMediaCollection('userProfile');

        return ResponseHelper::finalResponse(
            'login using socialite successfully',
            [
                'userId' => $user->id,
                'userName' => $socialiteUser->getName(),
                'userEmail' => $socialiteUser->getEmail(),
                'userImage' => $socialiteUser->getAvatar(),
                'tokenType' => 'Bearer Token',
                'tokenValue' => $sanctum_token,
                'tokenGoogle' => $socialiteUser->token,
            ],
            true,
            Response::HTTP_OK
        );
    }
}
