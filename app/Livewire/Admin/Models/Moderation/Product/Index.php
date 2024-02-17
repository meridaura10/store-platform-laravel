<?php

namespace App\Livewire\Admin\Models\Moderation\Product;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Livewire\Datatables\Table;
use App\Livewire\Datatables\Utils\Actions;
use App\Livewire\Datatables\Utils\Actions\ActionModerate;
use App\Livewire\Datatables\Utils\Columns;
use App\Livewire\Datatables\Utils\Columns\Column;
use App\Livewire\Datatables\Utils\Columns\ColumnDate;
use App\Livewire\Datatables\Utils\Columns\ColumnEdit;
use App\Livewire\Utils\Tabs\Tabs;
use App\Livewire\Utils\Tabs\Tab;
use App\Models\Moderation;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Index extends Table
{
    public function model(): string
    {
        return Moderation::class;
    }

    public function extendQuery(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->whereMorphedTo('moderatable', Product::class)
            ->with('moderatable.translations');
    }

    public function getTitle(): string
    {
        return 'Модерація продуктів';
    }

    public function columns(): Columns
    {
        return new Columns(
            Column::make(
                key: 'id',
            ),
            Column::make(
                key: 'moderatable.title',
                title: 'назва продукту',
            ),
            ColumnEdit::make(
                key: 'status',
            )->setEditValues(ModerationStatusesEnum::values()),
            ColumnDate::make(
                key: 'created_at',
                title: 'дата створення',
            ),
        );
    }

    public function actions(): Actions
    {
        return new Actions(
            ActionModerate::make(
                key: 'moderate',
            ),
        );
    }

    public function tabs(): Tabs
    {
        $moderationTabs = array_map(function ($item) {
            return Tab::make(
                key: "status$item->name",
                title: "статус $item->value",
                field: 'status',
                value: $item,
            );
        }, ModerationStatusesEnum::cases());

        return new Tabs(
            ...$moderationTabs,
        );
    }

    public function actionEditField($key, $item)
    {
        $column = $this->getColumns()->column($key);
        $this->dispatch('modal-edit-field-open', [
            'item' => $item,
            'field' => $key,
            'model' => $this->model(),
            'values' => $column->getEditValues(),
            'title' => 'change status moderation',
        ]);
    }

    public function actionModerate(Moderation $moderation)
    {
        redirect()->route('admin.product.moderation', ['product' => $moderation->moderatable]);
    }
}
