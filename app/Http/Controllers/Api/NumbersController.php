<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\LanguageException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Numbers\StoreNumberRequest;
use App\Services\Numbers\NumberStorageService;
use App\Services\Numbers\NumberToTextService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NumbersController extends Controller
{
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
            'message' => 'Number added to stack',
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
                'message' => 'Stack is empty',
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
