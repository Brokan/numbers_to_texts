<?php

declare(strict_types=1);

namespace App\Services\Numbers;

use App\Services\Numbers\ToText\NumberToTextEnglish;
use App\Services\Numbers\ToText\NumberToTextLatvian;
use App\Exceptions\LanguageException;
use App\Services\Numbers\ToText\NumberToTextAbstract;

class NumberToTextService {

    public function toText(
            int $number,
            string $language
    ): string 
    {
        $class = $this->getClass($language);

        /** @var NumberToTextAbstract $classText */
        $classText = new $class($number);
        
        return $classText->text();
    }

    private function getClass(string $language): string {
        switch ($language) {
            case 'en':
                return NumberToTextEnglish::class;
            case 'lv':
                return NumberToTextLatvian::class;
        }

        throw new LanguageException(sprintf('Language "%s" is not supported to convert number to text.', $language));
    }
}
