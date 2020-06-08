<?php

namespace Robbens\UpsalesTile;

use Illuminate\Support\Collection;
use Spatie\Dashboard\Models\Tile;

class UpsalesStore
{
    private Tile $tile;
    private string $key;

    public static function make($key)
    {
        return new static($key);
    }

    public function __construct($key)
    {
        $this->key = $key;
        $this->tile = Tile::firstOrCreateForName('UpsalesTile');
    }

    public function setData(array $data): self
    {
        $this->tile->putData($this->key, $data);

        return $this;
    }

    public function getData(): Collection
    {
        return collect($this->tile->getData($this->key));
    }
}
