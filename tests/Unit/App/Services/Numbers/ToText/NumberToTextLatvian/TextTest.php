<?php

declare(strict_types=1);

namespace Tests\Unit\App\Services\Numbers\ToText\NumberToTextLatvian;

use PHPUnit\Framework\TestCase;
use App\Services\Numbers\ToText\NumberToTextLatvian;

class TextTest extends TestCase {

    private const EXAMPLES = [
        4 => 'četri',
        15 => 'piecpadsmit',
        22 => 'divdesmit divi',
        111 => 'simts vienpadsmit',
        2222 => 'divi tūkstoši divi simti divdesmit divi',
        333333 => 'trīs simti trīsdesmit trīs tūkstoši trīs simti trīsdesmit trīs',
        4444444 => 'četri miljoni četri simti četrdesmit četri tūkstoši četri simti četrdesmit četri',
        555555555 => 'pieci simti piecdesmit pieci miljoni pieci simti piecdesmit pieci tūkstoši pieci simti piecdesmit pieci',
        66666666666 => 'sešdesmit seši miljardi seši simti sešdesmit seši miljoni seši simti sešdesmit seši tūkstoši seši simti sešdesmit seši',
    ];

    public function testSuccess(): void {
        foreach (self::EXAMPLES as $number => $expectText) 
        {
            $numberToText = new NumberToTextLatvian($number);
            
            $this->assertEquals($expectText, $numberToText->text());
        }
    }
}
