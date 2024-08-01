<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\changeLanguageRequest;
use App\Http\Requests\Api\contactUsRequest;
use App\Http\Resources\Api\PharmacyResource;
use App\Models\Pharmacy;
use App\Models\User;
use App\Notifications\ContactUsNotification;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class SettingController extends Controller
{
    public function getAvailableLanguage()
    {
        return ResponseHelper::finalResponse(
            'get available language successfully',
            config('app.available_locales'),
            true,
            Response::HTTP_OK
        );
    }

    public function changeLanguage(changeLanguageRequest $request)
    {
        $data = $request->validated();
        App::setLocale($data['lang']);

        return ResponseHelper::finalResponse(
            'language changed successfully',
            [
                'language' => $data['lang'],
            ],
            true,
            Response::HTTP_OK
        );
    }

    public function contactUs(contactUsRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        \Illuminate\Support\Facades\Notification::send(User::where('is_admin', true)->first(), new ContactUsNotification($user, $data));

        return ResponseHelper::finalResponse(
            'sending email to admin successfully',
            null,
            true,
            Response::HTTP_OK
        );
    }

    public function getOnboarding()
    {
        $pharmacy = Pharmacy::find(1);

        return ResponseHelper::finalResponse(
            'on barding screen',
            new PharmacyResource($pharmacy, true, true, false),
            true,
            Response::HTTP_OK
        );
    }

    public function getpharmacyCarousel()
    {
        $pharmacy = Pharmacy::find(1);

        return ResponseHelper::finalResponse(
            'on barding screen',
            new PharmacyResource($pharmacy, false, false, true),
            true,
            Response::HTTP_OK
        );
    }
}
