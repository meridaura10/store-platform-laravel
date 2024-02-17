<?php

namespace App\Livewire\Store\Models\Product;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Enums\User\UserRightTypeEnum;
use App\Livewire\Datatables\Table;
use App\Livewire\Datatables\Utils\Actions;
use App\Livewire\Datatables\Utils\Actions\ActionDelete;
use App\Livewire\Datatables\Utils\Actions\ActionEdit;
use App\Livewire\Datatables\Utils\Columns;
use App\Livewire\Datatables\Utils\Columns\Column;
use App\Livewire\Datatables\Utils\Columns\ColumnDate;
use App\Livewire\Datatables\Utils\Columns\ColumnImage;
use App\Livewire\Datatables\Utils\Columns\ColumnList;
use App\Livewire\Datatables\Utils\Columns\ColumnSwitch;
use App\Livewire\Datatables\Utils\Filters;
use App\Livewire\Datatables\Utils\Filters\DatatableFilter;
use App\Livewire\Datatables\Utils\Filters\Filter;
use App\Livewire\Utils\Tabs\Tabs;
use App\Livewire\Utils\Tabs\Tab;
use App\Models\Moderation;
use App\Models\Product;

class Index extends Table
{
    public $store_id = null;
    public function mount()
    {
        $this->store_id = request()->route('store');
    }
    public function model(): string
    {
        return Product::class;
    }

    public function getTitle(): string
    {
        return 'Продукти';
    }

    public function extendQuery(\Illuminate\Database\Eloquent\Builder $builder)
    {
        $builder->with(['translations', 'categories.translations', 'moderation', 'image'])->whereStore($this->store_id);
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
            Column::make(
                key: 'moderation.status',
                title: 'модерація'
            ),
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
            ActionEdit::make(
                key: 'edit',
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

    public function actionEdit(Product $product)
    {
        redirect()->route('store.admin.product.edit', [
            'store' => $this->store_id,
            'product' => $product->id,
        ]);
    }

    public function actionDelete(Product $product)
    {
        $this->authorize('delete', [$product, $this->store_id]);
        $product->delete();
    }

    public function switchStatus(Product $product)
    {
        $this->authorize('update', [$product, $this->store_id]);
        $product->update(['status' => !$product->status]);
    }

    public function getCreatedLink()
    {
        return route('store.admin.product.create', $this->store_id);
    }
}
