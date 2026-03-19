<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Numbers\NumberStorageService;
use App\Services\Numbers\NumberToTextService;
use App\Http\Requests\Api\Numbers\StoreNumberRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Exceptions\LanguageException;
use Illuminate\Http\JsonResponse;

class NumbersController extends Controller {

    public function __construct(
        private NumberStorageService $numberStorageService,
        private NumberToTextService $numberToTextService,
    ) {
        
    }

    public function store(StoreNumberRequest $request): JsonResponse 
    {
        $this->numberStorageService->push($request->number);

        return response()->json([
            'success' => true,
            'message' => 'Number added to stack'
        ], Response::HTTP_CREATED);
    }

    public function pop(Request $request): JsonResponse 
    {
        /** @var string $language */
        $language = $request->query('language', 'en');

        $number = $this->numberStorageService->pop();

        if (!$number) {
            return response()->json([
                'success' => false,
                'message' => 'Stack is empty'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $numberText = $this->numberToTextService->toText($number, $language);
        } catch (LanguageException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
        
        return response()->json([
            'success' => true,
            'number' => $number,
            'text' => $numberText,
        ], Response::HTTP_OK);
    }
}
