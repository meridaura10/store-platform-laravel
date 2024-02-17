<?php

namespace App\Livewire\Store\Models\Role;

use App\Livewire\Datatables\Table;
use App\Livewire\Datatables\Utils\Actions;
use App\Livewire\Datatables\Utils\Actions\ActionDelete;
use App\Livewire\Datatables\Utils\Actions\ActionEdit;
use App\Livewire\Datatables\Utils\Columns;
use App\Livewire\Datatables\Utils\Columns\Column;
use App\Livewire\Datatables\Utils\Columns\ColumnDate;
use App\Livewire\Datatables\Utils\Columns\ColumnList;
use App\Models\Role;
use Livewire\Component;

class Index extends Table
{
    public $store_id = null;

    public function getTitle(): string
    {
        return 'Ролі';
    }

    public function mount()
    {
        $this->store_id = (int) request()->route('store');
    }

    public function model(): string
    {
        return Role::class;
    }

    public function extendQuery(\Illuminate\Database\Eloquent\Builder $builder)
    {
        return $builder->with('permissions')->where('store_id', $this->store_id);
    }

    public function columns(): Columns
    {
        return new columns(
            Column::make(
                key: 'id',
            ),
            Column::make(
                key: 'title',
            ),
            ColumnList::make(
                key: 'permissions.title',
            ),
            ColumnDate::make(
                key: 'created_at',
                title: 'дата створення',
            ),
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

    public function actionDelete(Role $role)
    {
        $this->authorize('delete', [$role, $this->store_id]);
        $role->delete();
    }

    public function getCreatedLink(): string
    {
        return route('store.admin.role.create', [
            'store' => $this->store_id,
        ]);
    }

    public function actionEdit(Role $role)
    {
        redirect()->route('store.admin.role.edit', [
            'store' => $this->store_id,
            'role' => $role->id,
        ]);
    }
}
