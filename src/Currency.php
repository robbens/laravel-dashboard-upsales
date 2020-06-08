<?php

namespace Robbens\UpsalesTile;

use NumberFormatter;

class Currency
{
    private NumberFormatter $formatter;

    public function __construct()
    {
        $this->formatter = new NumberFormatter('sv_SE', NumberFormatter::CURRENCY);
    }

    public function format($value)
    {
        $this->formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 0);

        return $this->formatter->format($value);
    }
}
