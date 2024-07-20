<?php

namespace App\Http\Controllers\Api;

use App\Models\Term;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TermResource;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::get();
        if ($terms) {
            return ResponseHelper::finalResponse(
                'data fetched successfully',
                TermResource::collection($terms),
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
