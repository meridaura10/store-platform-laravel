<?php

namespace App\Traits;

use App\Livewire\Utils\Tabs\Tab;
use App\Livewire\Utils\Tabs\Tabs;
use Illuminate\Database\Eloquent\Builder;

trait TabsTrait
{
    public string|null $tab = null;

    private Tabs $tabs;

    public function tabs(): Tabs
    {
        return new Tabs();
    }

    public function hasTabs(): bool
    {
        return $this->tabs->count() > 0;
    }

    public function tabActive(Tab|null $tab = null)
    {
        return $this->tab == ($tab->key ?? null);
    }

    public function hasSelectedTab()
    {
        return $this->tab !== null && $this->tab !== 'null';
    }

    public function selectTab(string|null $key = null)
    {
        $this->tab = $key;
    }

    public function tabsQuery(Builder $builder)
    {
        if ($this->tab) {
            $this->tabs->apply($builder, $this->tab);
        }
    }

    public function initTabs()
    {
        $this->tabs = $this->tabs();
    }
}
