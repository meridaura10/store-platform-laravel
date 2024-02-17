<?php

namespace App\Livewire\Utils\Filters;

use Illuminate\Database\Eloquent\Builder;

class FilterRange extends Filter
{

    protected $type = 'range';
    protected $view = 'range';

    public function applyFilter(Builder $query, $value): Builder
    {
        if (!$value) {
            return $query;
        }
        if (array_key_exists('min', $value) && $value['min'] && array_key_exists('max', $value) && $value['max']) {
            return $query->whereBetween(
                $this->key,
                [
                    $value['min'],
                    $value['max'],
                ]
            );
        }
        if (array_key_exists('min', $value) && $value['min']) {
            return $query->where($this->key, '>', $value['min']);
        }
        if (array_key_exists('max', $value) && $value['max']) {
            return $query->where($this->key, '<', $value['max']);
        }
        return $query;
    }

    public function validateF(&$f)
    {
        if (isset($f[$this->key]['min'])) {
            if ($f[$this->key]['min'] < $this->attributes['min']) {
                $f[$this->key]['min'] = $this->attributes['min'];
            }

            if ($f[$this->key]['min'] > $this->attributes['max']) {
                $f[$this->key]['min'] = $this->attributes['max'];
            }
        }

        if (isset($f[$this->key]['max'])) {
            if ($f[$this->key]['max'] > $this->attributes['max']) {
                $f[$this->key]['max'] = $this->attributes['max'];
            }

            if ($f[$this->key]['max'] < $this->attributes['min']) {
                $f[$this->key]['max'] = $this->attributes['min'];
            }
        }
    }
}
