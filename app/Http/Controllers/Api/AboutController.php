<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AboutResource;
use App\Models\About;
use Illuminate\Http\Response;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::get();
        if ($abouts) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                AboutResource::collection($abouts),
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
