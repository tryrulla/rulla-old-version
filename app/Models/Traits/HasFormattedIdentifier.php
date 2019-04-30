<?php

namespace App\Models\Traits;

trait HasFormattedIdentifier
{
    abstract public function getIdentifierPrefixLetter(): string;

    public function getIdentifierAttribute(): string
    {
        return $this->getIdentifierPrefixLetter() . str_pad($this->id, 7, '0', STR_PAD_LEFT);
    }
}
