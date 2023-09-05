<?php

namespace App\DataTables;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'permission.action')
            ->addColumn('stt', function ($query){
                static $rowNumber = 0;
                return ++$rowNumber;
            })
            ->addColumn('all_permission', function ($query) {
                $permissionsArray = [];
              foreach (json_decode($query->name) as $permission) {
                  $parts = explode(".", $permission);
                  $permissionsArray[] = $parts[1];
              }

                $permissionBadges = '';
                foreach ($permissionsArray as $permission) {
                    if($permission  == 'view'){
                        $permissionBadges .= '<span class="badge badge-success">' . $permission . '</span> ';
                    }elseif ($permission  == 'add'){
                        $permissionBadges .= '<span class="badge badge-info">' . $permission . '</span> ';
                    }elseif ($permission  == 'edit'){
                        $permissionBadges .= '<span class="badge badge-primary">' . $permission . '</span> ';
                    }elseif ($permission  == 'delete'){
                        $permissionBadges .= '<span class="badge badge-danger">' . $permission . '</span> ';
                    }else{
                        $permissionBadges .= '<span class="badge badge-dark">authorization</span> ';
                    }

                }
                return rtrim($permissionBadges);

            })
            ->rawColumns(['all_permission'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Permission $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('permission-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('stt'),
            Column::make('group_name'),
            Column::make('all_permission'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Permission_' . date('YmdHis');
    }
}
