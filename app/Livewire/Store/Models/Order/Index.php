<?php

namespace App\Livewire\Store\Models\Order;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Enums\Payment\PaymentStatusEnum;
use App\Livewire\Datatables\Table;
use App\Livewire\Datatables\Utils\Actions;
use App\Livewire\Datatables\Utils\Actions\ActionEdit;
use App\Livewire\Datatables\Utils\Actions\ActionModerate;
use App\Livewire\Datatables\Utils\Columns;
use App\Livewire\Datatables\Utils\Columns\Column;
use App\Livewire\Datatables\Utils\Columns\ColumnDate;
use App\Livewire\Datatables\Utils\Columns\ColumnEdit;
use App\Livewire\Datatables\Utils\Columns\ColumnOrderCustomer;
use App\Livewire\Datatables\Utils\Columns\ColumnOrderPayment;
use App\Livewire\Datatables\Utils\Filters;
use App\Livewire\Utils\Filters\Filter;
use App\Livewire\Utils\Filters\FilterDate;
use App\Livewire\Utils\Tabs\Tab;
use App\Livewire\Utils\Tabs\Tabs;
use App\Models\Order;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Index extends Table
{

    public $store_id;

    public function mount()
    {
        $this->store_id = request()->route('store');
    }

    public function model(): string
    {
        return Order::class;
    }

    public function extendQuery(Builder $builder)
    {
        $builder->with('payment', 'moderation')->where('store_id', $this->store_id);
    }

    public function tabs(): Tabs
    {
        $statusTabs = array_map(function ($item) {
            return Tab::make(
                key: "status$item->name",
                title: "статус: $item->value",
                field: 'status',
                value: $item,
            );
        }, OrderStatusEnum::cases());

        return new Tabs(
            ...$statusTabs,
        );
    }

    public function filters(): Filters
    {
        return new Filters(
            Filter::make(
                key: 'id',
                title: 'Знайти по індетифікатору'
            ),
            FilterDate::make(
                key: 'created_at',
                title: 'Знайти за часом замовлення',
            )
        );
    }

    public function columns(): Columns
    {
        return new Columns(
            Column::make(
                key: 'id',
            ),
            Column::make(
                key: 'amount',
                title: 'ціна замовлення'
            ),
            ColumnOrderCustomer::make(
                key: 'customer',
                sortable: false,
            ),
            ColumnOrderPayment::make(
                key: 'payment',
                sortable: false,
            ),
            ColumnEdit::make(
                key: 'status',
                title: 'статус',
                sortable: false,
            )->setEditValues(OrderStatusEnum::cases())
                ->setModalTitle('Change status'),
            ColumnEdit::make(
                key: 'payment.status',
                title: 'статус оплати',
                sortable: false,
            )->setEditValues(PaymentStatusEnum::cases())
                ->setModalTitle('Change payment status'),
            ColumnEdit::make(
                key: 'moderation.status',
                title: 'модерація',
                sortable: false,
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
                key: 'moderation',
            ),
            ActionEdit::make(
                key: 'edit',
            ),
        );
    }

    public function actionModeration(Order $order)
    {
        redirect()->route('store.admin.order.moderation', [
            'store' => $this->store_id,
            'order' => $order,
        ]);
    }

    public function actionEdit(Order $order)
    {
        redirect()->route('store.admin.order.edit', [
            'store' => $this->store_id,
            'order' => $order,
        ]);
    }
}
