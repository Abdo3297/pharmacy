<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Response;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::get();
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
