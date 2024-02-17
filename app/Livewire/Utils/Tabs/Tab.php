<?php

namespace App\Livewire\Utils\Tabs;


class Tab
{
    public function __construct(
        public string $key,
        public string|null $title = null,
        public string|null $field = null,
        public mixed $value = null,
    ) {
        $this->key = $key;
        $this->field = $field ?? $key;
        $this->value = $value ?? $key;
        $this->title = $title ?? $key;
    }

    public static function make(...$arguments): static
    {
        return new static(...$arguments);
    }
}
