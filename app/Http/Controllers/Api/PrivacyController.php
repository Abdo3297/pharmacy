<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\PrivacyResource;
use App\Models\Privacy;
use Illuminate\Http\Response;

class PrivacyController extends Controller
{
    public function index()
    {
        $privacies = Privacy::get();
        if ($privacies) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                PrivacyResource::collection($privacies),
                true,
                Response::HTTP_OK
            );
        }

        return ResponseHelper::finalResponse(
            'data not found',
            null,
            true,
            Response::HTTP_OK
        );
    }
}
