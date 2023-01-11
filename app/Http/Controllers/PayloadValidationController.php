<?php

namespace App\Http\Controllers;

use App\Traits\PayloadValidationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PayloadValidationController extends Controller
{
    use PayloadValidationTrait;

    /**
     * Validate payload and return appropriate response
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validatePayload(Request $request): JsonResponse
    {
        $validationErrors = $this->getValidationErrors($request->all());

        if (!empty($validationErrors)) {
            return response()->json([
                'status' => false,
                'errors' => $validationErrors
            ], 422);
        }

        return response()->json([
            'status' => true
        ], 200);
    }
}
