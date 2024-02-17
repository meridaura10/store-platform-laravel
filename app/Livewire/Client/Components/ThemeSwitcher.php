<?php

namespace App\Livewire\Client\Components;

use Livewire\Component;

class ThemeSwitcher extends Component
{
    public $themes = [];
    public $active = null;
    public function mount()
    {
        $this->themes = ["light", "dark", "cupcake", 'wireframe'];
        $this->active = session('theme') ?? $this->themes[0];
    }
    public function switch($theme)
    {
        session()->put('theme', $theme);
       
        $this->active = $theme;
    }

    public function render()
    {
        return view('livewire.client.components.theme-switcher');
    }
}
