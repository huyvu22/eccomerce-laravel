<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\PendingOrder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OutOfDeliveryOrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query){
                $showBtn= '<a href="'. \route('admin.order.show', $query) .'" class="btn btn-primary mr-1"><i class="fas fa-eye"></i></a>';
                $deleteBtn= ' <form class="form-delete" style="display:inline-block" action="'. \route('admin.order.destroy', $query) .'" method="POST">
                                ' . \csrf_field() . '
                                ' . \method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                            </form>';

                return $showBtn.$deleteBtn;

            })
            ->addColumn('customer', function ($query){
                return $query->user->name;
            })
            ->addColumn('date', function ($query){
                return Carbon::parse($query->created_at)->format('d-m-Y');
            })

            ->addColumn('order_status', function ($query){
                return '<span class="badge badge-info">'.$query->order_status.'</span>';
            })
            ->addColumn('payment_status', function ($query){
                if($query->payment_status == 1){
                    return '<span class="badge badge-success">Complete</span>';
                }else{
                    return '<span class="badge badge-danger">Pending</span>';
                }
            })
            ->rawColumns(['order_status', 'action','payment_status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model::with('user')->where('order_status','out_of_delivery')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pendingorder-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
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
            Column::make('invoice_id'),
            Column::make('customer'),
            Column::make('date'),
            Column::make('product_quantity'),
            Column::make('amount'),
            Column::make('order_status'),
            Column::make('payment_status'),
            Column::make('payment_method'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(220)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PendingOrder_' . date('YmdHis');
    }
}
