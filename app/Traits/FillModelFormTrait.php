<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Validation\Rules\Enum;
use UnitEnum;

trait FillModelFormTrait
{
    public function initForm(Model $model, $fields, string $nameModel)
    {
        $this->{$nameModel} = $model;

        foreach ($this->only($fields) as $key => $valueItem) {
            $relations = explode('.', $key);

            $field = end($relations);

            $value = $model;

            foreach ($relations as $rel) {
                switch (true) {
                    case $value instanceof Model:
                        $value = $value->{$rel};
                        break;
                    case $value instanceof Collection:
                        $value = $value->pluck($rel);
                        break;
                }
            }

            if ($value instanceof Collection || $value instanceof SupportCollection || $value instanceof Model) {
                return  $this->{$relations[0]} = $value->toArray();
            }

            if ($value instanceof UnitEnum) {
                return $this->{$field} = $value->value;
            }

            $this->{$field} = $value ?? $valueItem;
        }
    }

    public function exactFillModel($fields, string $nameModel)
    {
        foreach ($this->only($fields) as $key => $value) {
            $this->{$nameModel}->{$key} = $value;
        }
    }
}
