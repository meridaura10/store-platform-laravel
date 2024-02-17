<?php

namespace App\Livewire\Datatables\Utils;

use Iterator;
use Livewire\Wireable;
use Throwable;

abstract class AbstractCollection implements Wireable, Iterator
{
    private $position = 0;

    protected $collection;

    public function __construct()
    {
        $this->collection = collect();
    }

    public function count(): int
    {
        return $this->collection->count();
    }


    // =============== WIREABLE ================ //

    public function toLivewire()
    {
        try {
            return serialize($this);
        } catch (Throwable $th) {
            
        }
    }

    public static function fromLivewire($value)
    {
        return unserialize($value);
    }


    // =============== ITERATABLE ================ //

    public function current(): mixed
    {
        return $this->collection[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function valid(): bool
    {
        return $this->collection->count() > $this->position;
    }
}
