<?php

declare(strict_types=1);

namespace App\Services\Numbers\ToText;

use NumberToWords\NumberToWords;

class NumberToTextEnglish extends  NumberToTextAbstract{
   
    #[\Override]
    public function text(): string {
        $converter = new NumberToWords();
        return $converter->getNumberTransformer('en')->toWords($this->number);
    }
}
