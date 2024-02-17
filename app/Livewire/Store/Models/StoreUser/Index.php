<?php

namespace App\Livewire\Store\Models\StoreUser;

use App\Enums\User\UserStoreRoleEnum;
use App\Livewire\Datatables\Table;
use App\Livewire\Datatables\Utils\Actions;
use App\Livewire\Datatables\Utils\Actions\ActionDelete;
use App\Livewire\Datatables\Utils\Actions\ActionEdit;
use App\Livewire\Datatables\Utils\Columns;
use App\Livewire\Datatables\Utils\Columns\Column;
use App\Livewire\Datatables\Utils\Columns\ColumnDate;
use App\Livewire\Datatables\Utils\Columns\ColumnList;
use App\Livewire\Datatables\Utils\Columns\ColumnSwitch;
use App\Livewire\Datatables\Utils\Filters;
use App\Livewire\Datatables\Utils\Filters\DatatableFilter;
use App\Livewire\Datatables\Utils\Filters\Filter;
use App\Livewire\Utils\Tabs\Tabs;
use App\Livewire\Utils\Tabs\Tab;
use App\Models\StoreUser;
use App\Models\StoreUserRole;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Table
{
    public $store_id = null;

    public function mount()
    {
        $this->store_id = request()->route('store');
    }

    public function getTitle(): string
    {
        return 'Персонал';
    }

    public function model(): string
    {
        return StoreUser::class;
    }

    public function extendQuery(\Illuminate\Database\Eloquent\Builder $builder)
    {

        $builder->with('user', 'roles')
            ->whereNot('user_id',auth()->id())
            ->whereStore($this->store_id);
    }

    public function columns(): Columns
    {
        return new Columns(
            Column::make(
                key: 'id',
                title: 'Id',
            ),
            ColumnList::make(
                key: 'roles.title',
                title: 'roles',
                sortable: false,
            ),
            Column::make(
                key: 'user.name',
                title: 'Ім`я'
            ),
            Column::make(
                key: 'user.email',
                title: 'Email',
            ),
            ColumnSwitch::make(
                key: 'status',
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
                confirmTitle: 'видалити цього користувача ?',
                confirmText: 'ви впевнені що хочете видалити цього користувача ?',
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
                key: "role$item->name",
                title: "роль користувача: $item->value",
                field: 'roles.role',
                value: $item,
            );
        }, UserStoreRoleEnum::cases());

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
    
    public function actionEdit(StoreUser $storeUser)
    {
        redirect()->route('store.admin.staff.edit', [
            'store' => $this->store_id,
            'storeUser' => $storeUser->id,
        ]);
    }

    public function actionDelete(StoreUser $storeUser)
    {
        $this->authorize('delete', [$storeUser]);
        $storeUser->delete();
    }

    public function switchStatus(StoreUser $storeUser)
    {
        $this->authorize('update', [$storeUser]);
        $storeUser->update(['status' => !$storeUser->status]);
    }

    public function getCreatedLink()
    {
        return route('store.admin.staff.create', $this->store_id);
    }
}
