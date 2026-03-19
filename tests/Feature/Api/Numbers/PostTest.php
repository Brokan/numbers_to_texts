<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Numbers;

use Tests\TestCase;

class PostTest extends TestCase
{
    private const ENDPOINT = 'api/numbers';

    public function testFailWhenEmptyRequest(): void
    {
        $response = $this->post(self::ENDPOINT, []);

        $response->assertBadRequest();
        $response->assertJson([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => [
                'number' => [
                    'Number is required',
                ],
            ],
        ]);
    }

    public function testFailWhenNotNumber(): void
    {
        $response = $this->post(self::ENDPOINT, [
            'number' => 'abc',
        ]);

        $response->assertBadRequest();
        $response->assertJson([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => [
                'number' => [
                    'Number must be an integer',
                ],
            ],
        ]);
    }

    public function testFailWhenNumberNegative(): void
    {
        $response = $this->post(self::ENDPOINT, [
            'number' => -5,
        ]);

        $response->assertBadRequest();
        $response->assertJson([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => [
                'number' => [
                    'Number must be >= 0',
                ],
            ],
        ]);
    }

    public function testSuccess(): void
    {
        $response = $this->post(self::ENDPOINT, [
            'number' => 123456789,
        ]);

        $response->assertCreated();
        $response->assertJson([
            'success' => true,
            'message' => 'Number added to stack',
        ]);
    }
}
