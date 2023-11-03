<?php

namespace App\DataTables;

use App\Models\VendorWithdraw;
use App\Models\WithdrawRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VendorWithdrawDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('Phương thức', function ($query){
                return $query->method;
            })
            ->addColumn('Tổng tiền', function ($query){
                return format($query->total_amount);
            })
            ->addColumn('Thực nhận', function ($query){
                return format($query->withdraw_amount);
            })
            ->addColumn('Phí', function ($query){
                return format($query->withdraw_charge);
            })
            ->addColumn('Trạng thái', function ($query){
                switch ($query){
                    case $query->status =='pending':
                        return '<i class="badge bg-warning">Đang xử lý</i>';
                    case $query->status =='paid':
                        return '<i class="badge bg-success">Thành công</i>';
                    default:
                        return '<i class="badge bg-danger">Không thành công</i>';
                }
            })
            ->addColumn('action', function ($query){
                return '<a href="'.route('vendor.withdraw-request.show', $query->id).'" class="btn btn-primary"><i class="fas fa-eye"></i></a>';
            })
            ->rawColumns(['Trạng thái', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WithdrawRequest $model): QueryBuilder
    {
        return $model->where('vendor_id', Auth::user()->vendor->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorwithdraw-table')
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
            Column::make('Phương thức'),
            Column::make('Tổng tiền'),
            Column::make('Phí'),
            Column::make('Thực nhận'),
            Column::make('Trạng thái'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorWithdraw_' . date('YmdHis');
    }
}
