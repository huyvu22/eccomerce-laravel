<?php

namespace App\DataTables;

use App\Models\WithdrawMethod;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WithdrawMethodDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('minimum_amount', function ($query){
                return format($query->minimum_amount);
            })
            ->addColumn('maximum_amount', function ($query){
                return format($query->maximum_amount);
            })
            ->addColumn('withdraw_charge', function ($query){
                return ($query->withdraw_charge).'%';
            })
            ->addColumn('Chi tiết', function ($query){
                return '<a href="'.route('admin.withdraw-method.edit', $query).'" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                    <form class="form-delete" style="display:inline-block" action="'.route('admin.withdraw-method.destroy', $query).'" method="POST">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                    </form>';

            })
            ->rawColumns(['Chi tiết'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawMethod $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('withdrawmethod-table')
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
            Column::make('id'),
            Column::make('name'),
            Column::make('minimum_amount'),
            Column::make('maximum_amount'),
            Column::make('withdraw_charge'),
            Column::computed('Chi tiết')
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
        return 'WithdrawMethod_' . date('YmdHis');
    }
}
