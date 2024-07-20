<?php

namespace App\Http\Controllers\Api;

use App\Models\FAQ;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FaqResource;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = FAQ::get();
        if ($faqs) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                FaqResource::collection($faqs),
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
