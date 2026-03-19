<?php

declare(strict_types=1);

namespace App\Services\Numbers\ToText;

abstract class NumberToTextAbstract {

    public function __construct(
            readonly protected int $number,
    ) {
        
    }

    abstract public function text(): string;
}
