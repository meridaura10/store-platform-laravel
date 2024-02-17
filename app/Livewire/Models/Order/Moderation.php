<?php

namespace App\Livewire\Models\Order;

use App\Enums\Moderation\ModerationStatusesEnum;
use App\Enums\Order\OrderStatusEnum;
use App\Models\Order;
use Livewire\Component;

class Moderation extends Component
{
    public Order $order;

    public $moderationStatuses;

    public $selectedStatusModeration;

    public $orderStatuses;

    public $selectedStatusOrder;

    public function mount(Order $order)
    {
        $this->order = $order->load('payment', 'moderation');

        $this->moderationStatuses = ModerationStatusesEnum::values();
        $this->selectedStatusModeration = $this->order->moderation->status;

        $this->orderStatuses = OrderStatusEnum::values();
        $this->selectedStatusOrder = $this->order->status;
    }

    public function updatedSelectedStatusModeration($status)
    {
        $this->order->moderation()->update([
            'status' => $status,
            'user_id' => auth()->id(),
        ]);
    }

    public function updatedSelectedStatusOrder($status)
    {
        $this->order->update([
            'status' => $status,
            'user_id' => auth()->id(),
        ]);
    }

    public function render()
    {
        return view('livewire.models.order.moderation');
    }
}
