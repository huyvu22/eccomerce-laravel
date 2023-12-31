<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserProductReviewsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('Stt', function ($query) use (&$count) {
            $count++;
            return $count;
         })
            ->addColumn('Sản phẩm', function($query){
                return '<a href="'.route('product-detail',$query->product->slug).'">'.$query->product->name.'</a>';
            })
            ->addColumn('rating', function($query){
                return $query->rating.' <span style="font-size: 12px; color: orange;" class="fas fa-star"></i></span>';
            })
            ->addColumn('Trạng thái',function ($query){
                return $query->status ==1 ?'<i class="badge bg-success">approved</i>' :'<i class="badge bg-danger">Pending</i>';
            })
			->rawColumns(['rating', 'Sản phẩm','Trạng thái'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(\App\Models\ProductReview $model): QueryBuilder
    {
        return $model::with('product')->where('user_id',\Auth::user()->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('userproductreviews-table')
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
            Column::make('Stt'),
            Column::make('Sản phẩm'),
            Column::make('rating'),
            Column::make('review'),
            Column::make('Trạng thái'),
            ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserProductReviews_' . date('YmdHis');
    }
}
