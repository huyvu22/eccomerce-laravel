<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\VendorOrder;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserOrderDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))

//            ->addColumn('Stt', function ($query) use (&$count) {
//               $count++;
//               return $count;
//            })
            ->addColumn('Chi tiết', function ($query){
                return '<a href="'. \route('user.orders.show', $query) .'" class="btn btn-primary mr-1"><i class="fas fa-eye"></i></a>';
            })
            ->addColumn('Người mua', function ($query){
                return $query->user->name;
            })
            ->addColumn('Ngày mua', function ($query){
                return Carbon::parse($query->created_at)->format('d-m-Y');
            })
            ->addColumn('Số lượng', function ($query){
                return ($query->product_quantity);
            })

            ->addColumn('Tổng tiền', function ($query){
                return format($query->amount);
            })

            ->addColumn('Thanh toán qua', function ($query){
                return ($query->payment_method);
            })

            ->addColumn('Trạng thái', function ($query){

                if($query->order_status == 'pending' ){
                    return '<i class="badge bg-danger">'.$query->order_status.'</i>';
                }elseif ($query->order_status == 'canceled'){
                    return '<i class="badge bg-dark">'.$query->order_status.'</i>';
                } elseif ($query->order_status == 'delivered'){
                    return '<i class="badge bg-success">'.$query->order_status.'</i>';
                }else{
                    return '<i class="badge bg-info">'.$query->order_status.'</i>';
                }
            })

            ->addColumn('Thanh toán', function ($query){
                if($query->payment_status == 1){
                    return '<i class="badge bg-success">Đã thanh toán</i>';

                }else{
                    return '<i class="badge bg-danger">Chưa thanh toán</i>';
                }
            })
            ->rawColumns(['Trạng thái', 'Chi tiết','Thanh toán'])
            ->setRowId('id');
    }
    /**
     * Get the query source of dataTable.
     */
    public function query(Order $model): QueryBuilder
    {
        return $model::where('user_id', Auth::user()->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendororder-table')
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
//            Column::make('stt'),
            Column::make('invoice_id'),
            Column::make('Người mua'),
            Column::make('Ngày mua'),
            Column::make('Số lượng') ->addClass('text-center'),
            Column::make('Tổng tiền'),
            Column::make('Trạng thái'),
            Column::make('Thanh toán'),
            Column::make('Thanh toán qua') ->addClass('text-center'),
            Column::computed('Chi tiết')
                ->exportable(false)
                ->printable(false)
                ->width(70)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorOrder_' . date('YmdHis');
    }
}
