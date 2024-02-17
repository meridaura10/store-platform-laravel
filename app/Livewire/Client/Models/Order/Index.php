<?php

namespace App\Livewire\Client\Models\Order;

use App\Contracts\Payment\PaymentSystemCardInterface;
use App\Enums\Order\OrderStatusEnum;
use App\Livewire\Datatables\Utils\Filters;
use App\Livewire\Utils\Filters\Filter;
use App\Livewire\Utils\Filters\FilterDate;
use App\Livewire\Utils\Sorts\Sort;
use App\Livewire\Utils\Sorts\Sorts;
use App\Livewire\Utils\Tabs\Tab;
use App\Livewire\Utils\Tabs\Tabs;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Payment\Helpers\PaymentTypeHelper;
use App\Traits\FilterableTrait;
use App\Traits\SortableTrait;
use App\Traits\TabsTrait;
use Livewire\Component;

class Index extends Component
{
    use TabsTrait, FilterableTrait, SortableTrait;

    protected $queryString = ['f', 'sort', 'tab'];

    public $hasOrders;

    public function __construct()
    {
        $this->initTabs();
        $this->initSorts();
        $this->initFilters();
    }

    public function sorts(): Sorts
    {
        return new Sorts(
            Sort::make(
                key: str()->slug('sortByDateDescending'),
                field: 'created_at',
                direction: 'desc',
                title: 'новіші',
            ),
            Sort::make(
                key: str()->slug('sortByDateAscending'),
                field: 'created_at',
                title: 'старіші',
            ),
            Sort::make(
                key: 'cheap',
                field: 'amount',
                title: 'дорощі',
            ),
            Sort::make( 
                key: 'expensive',
                field: 'amount',
                direction: 'desc',
                title: 'дешевші',
            ),
        );
    }

    public function mount()
    {
        $this->hasOrders = $this->hasOrders();
    }

    private function tabs(): Tabs
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

    public function orderQuery()
    {
        return Order::query()
            ->whereHas('customer', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('orderProducts.translations', 'orderProducts.product.image');
    }

    public function hasOrders(): bool
    {
        return $this->orderQuery()->exists();
    }

    public function getOrders()
    {
        $builder = $this->orderQuery();
        $this->tabsQuery($builder);
        $this->filterQuery($builder);
        $this->sortingQuery($builder);

        return $builder->get();
    }

    public function isPaymentExpired(Payment $payment): bool
    {
        return PaymentTypeHelper::createPaymentSystem($payment)->isPaymentExpired($payment);
    }

    public function pay(Order $order)
    {
        try {
            $payment = $order->payment;

            $paymentSystem = PaymentTypeHelper::createPaymentSystem($payment);

            $paymentSystem->pay($order->payment);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.client.models.order.index', [
            'orders' => $this->getOrders(),
            'tabs' => $this->tabs,
            'filters' => $this->filters,
            'sorts' => $this->sorts,
        ]);
    }
}
