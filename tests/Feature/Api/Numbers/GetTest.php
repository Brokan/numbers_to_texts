<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Numbers;

use Tests\TestCase;

class GetTest extends TestCase
{
    private const ENDPOINT = 'api/numbers';
    private const FILE_LOCATION = 'app/stack.json';

    private string $file;

    #[\Override]
    public function setUp(): void
    {
        parent::setUp();

        $this->file = $this->app->storagePath(self::FILE_LOCATION);
    }

    public function testFailWhenEmptyJSON(): void
    {

        file_put_contents($this->file, json_encode([]));

        $response = $this->get(self::ENDPOINT);

        $response->assertNotFound();
        $response->assertJson([
            'success' => false,
            'message' => 'Stack is empty',
        ]);
    }

    public function testSuccessWhenLanguageDefault(): void
    {

        file_put_contents($this->file, json_encode([1,2,3,4,5]));

        $response = $this->get(self::ENDPOINT);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'number' => 5,
            'text' => 'five',
        ]);

        //On next get, get next last number.
        $responseSecond = $this->get(self::ENDPOINT);

        $responseSecond->assertOk();
        $responseSecond->assertJson([
            'success' => true,
            'number' => 4,
            'text' => 'four',
        ]);
    }

    public function testSuccessWhenLanguageLatvian(): void
    {

        file_put_contents($this->file, json_encode([1,2,3,4,5,6,7]));

        $response = $this->get(self::ENDPOINT . '?language=lv');

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'number' => 7,
            'text' => 'septiņi',
        ]);
    }

    public function testFailWhenLanguageWrong(): void
    {

        file_put_contents($this->file, json_encode([1,2,3,4,5]));

        $response = $this->get(self::ENDPOINT . '?language=123456');

        $response->assertBadRequest();
        $response->assertJson([
            'success' => false,
             'message' => 'Language "123456" is not supported to convert number to text.',
        ]);
    }
}
