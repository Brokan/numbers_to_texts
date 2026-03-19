<?php

declare(strict_types=1);

namespace App\Services\Numbers\ToText;

class NumberToTextLatvian extends NumberToTextAbstract
{
    private const UNITS = [
        0 => 'nulle',
        1 => 'viens',
        2 => 'divi',
        3 => 'trīs',
        4 => 'četri',
        5 => 'pieci',
        6 => 'seši',
        7 => 'septiņi',
        8 => 'astoņi',
        9 => 'deviņi',
        10 => 'desmit',
    ];

    private const PADSMIT = [
        1 => 'vienpadsmit',
        2 => 'divpadsmit',
        3 => 'trīspadsmit',
        4 => 'četrpadsmit',
        5 => 'piecpadsmit',
        6 => 'sešpadsmit',
        7 => 'septiņpadsmit',
        8 => 'astoņpadsmit',
        9 => 'deviņpadsmit',
    ];

    private const TENS = [
        2 => 'divdesmit',
        3 => 'trīsdesmit',
        4 => 'četrdesmit',
        5 => 'piecdesmit',
        6 => 'sešdesmit',
        7 => 'septiņdesmit',
        8 => 'astoņdesmit',
        9 => 'deviņdesmit',
    ];

    #[\Override]
    public function text(): string
    {
        if ($this->number === 0) {
            return self::UNITS[0];
        }

        return $this->convert($this->number);
    }

    private function convert(int $number): string
    {
        if ($number < 100) {
            return $this->getTens($number);
        }

        if ($number < 1000) {
            return $this->getHundreds($number);
        }

        if ($number < 1_000_000) {
            return $this->getThousands($number);
        }

        if ($number < 1_000_000_000) {
            return $this->getMillions($number);
        }

        return $this->getBillions($number);
    }

    private function getTens(int $number): string
    {
        if ($number <= 10) {
            return self::UNITS[$number];
        }

        if ($number < 20) {
            return self::PADSMIT[$number - 10];
        }

        $tens = intdiv($number, 10);
        $ones = $number % 10;

        return self::TENS[$tens] . ($ones ? ' ' . self::UNITS[$ones] : '');
    }

    private function getHundreds(int $number): string
    {
        $hundreds = intdiv($number, 100);
        $remainder = $number % 100;

        $hundredWord = $hundreds === 1
            ? 'simts'
            : self::UNITS[$hundreds] . ' simti';

        return $hundredWord . ($remainder ? ' ' . $this->convert($remainder) : '');
    }

    private function getThousands(int $number): string
    {
        $thousands = intdiv($number, 1000);
        $remainder = $number % 1000;

        $word = match (true) {
            $thousands === 1 => 'tūkstotis',
            default => $this->convert($thousands) . ' tūkstoši',
        };

        return $word . ($remainder ? ' ' . $this->convert($remainder) : '');
    }

    private function getMillions(int $number): string
    {
        $millions = intdiv($number, 1_000_000);
        $remainder = $number % 1_000_000;

        $word = match (true) {
            $millions === 1 => 'viens miljons',
            default => $this->convert($millions) . ' miljoni',
        };

        return $word . ($remainder ? ' ' . $this->convert($remainder) : '');
    }

    private function getBillions(int $number): string
    {
        $billions = intdiv($number, 1_000_000_000);
        $remainder = $number % 1_000_000_000;

        $word = match (true) {
            $billions === 1 => 'viens miljards',
            default => $this->convert($billions) . ' miljardi',
        };

        return $word . ($remainder ? ' ' . $this->convert($remainder) : '');
    }
}
