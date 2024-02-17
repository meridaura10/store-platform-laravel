<?php

namespace App\Livewire\Admin\Models\Product;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Livewire\Datatables\Table;
use App\Livewire\Datatables\Utils\Actions;
use App\Livewire\Datatables\Utils\Actions\ActionDelete;
use App\Livewire\Datatables\Utils\Actions\ActionModerate;
use App\Livewire\Datatables\Utils\Columns;
use App\Livewire\Datatables\Utils\Columns\Column;
use App\Livewire\Datatables\Utils\Columns\ColumnDate;
use App\Livewire\Datatables\Utils\Columns\ColumnEdit;
use App\Livewire\Datatables\Utils\Columns\ColumnImage;
use App\Livewire\Datatables\Utils\Columns\ColumnList;
use App\Livewire\Datatables\Utils\Columns\ColumnSwitch;
use App\Livewire\Datatables\Utils\Filters;
use App\Livewire\Datatables\Utils\Filters\DatatableFilter;
use App\Livewire\Datatables\Utils\Filters\Filter;
use App\Livewire\Utils\Tabs\Tabs;
use App\Livewire\Utils\Tabs\Tab;
use App\Models\Product;
use Livewire\Component;

class Index extends Table
{
    public function model(): string
    {
        return Product::class;
    }

    public function extendQuery(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->with(['translations', 'categories.translations', 'moderation', 'image']);
    }

    public function getTitle(): string
    {
        return 'Продукти';
    }

    public function columns(): Columns
    {
        return new Columns(
            Column::make(
                key: 'id',
            ),
            ColumnImage::make(
                key: 'image',
            ),
            Column::make(
                key: 'title',
            )->setCustomQuery(function ($query, $value) {
                $query->sortByTitle($value);
            }),
            ColumnList::make(
                key: 'categories.title',
                title: 'категорії',
            ),
            Column::make(
                key: 'price',
            ),
            Column::make(
                key: 'quantity',
            ),
            ColumnSwitch::make(
                key: 'status',
                title: 'статус',
            ),
            ColumnEdit::make(
                key: 'moderation.status',
                title: 'модерація'
            )->setEditValues(ModerationStatusesEnum::values()),
            ColumnDate::make(
                key: 'created_at',
                title: 'дата створення',
            ),
        );
    }
    public function filters(): Filters
    {
        return new Filters(
            DatatableFilter::make(
                key: 'title',
                title: 'пошук',
            )->setCustomQuery(function ($query, $value) {
                return $query->search($value);
            }),
        );
    }

    public function actions(): Actions
    {
        return new Actions(
            ActionDelete::make(
                key: 'delete',
                confirm: true,
                confirmTitle: 'видалити цей продукт ?',
                confirmText: 'ви впевнені що хочете видалити цей продукт ?',
            ),

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
                title: "статус модерації: $item->value",
                field: 'moderation.status',
                value: $item,
            );
        }, ModerationStatusesEnum::cases());

        return new Tabs(
            Tab::make(
                key: 'statusFalse',
                title: 'не актривний',
                field: 'status',
                value: false,
            ),
            Tab::make(
                key: 'statusTrue',
                title: 'активний',
                field: 'status',
                value: true,
            ),
            ...$moderationTabs,
        );
    }



    public function actionDelete(Product $product)
    {
        $product->delete();
    }

    public function actionModerate(Product $product)
    {
        redirect()->route('admin.product.moderation', ['product' => $product]);
    }

    public function switchStatus(Product $product)
    {
        $product->update(['status' => !$product->status]);
    }
}
