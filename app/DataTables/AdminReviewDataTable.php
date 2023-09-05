<?php

namespace App\DataTables;

use App\Models\AdminReview;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AdminReviewDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('product', function($query){
                return '<a href="'.route('product-detail',$query->product->slug).'">'.$query->product->name.'</a>';
            })
            ->addColumn('rating', function($query){
                return $query->rating.' <span style="font-size: 12px; color: orange;" class="fas fa-star"></i></span>';
            })
            ->addColumn('username', function($query){
                return $query->user->name;
            })
            ->addColumn('vendor', function($query){
                return $query->vendor->shop_name;
            })
            ->addColumn('status',function ($query){
                $selectedApprove = $query->status === 1 ? 'selected' : null;
                $selectedPending = $query->status === 0 ? 'selected' : null;
                return '<select class="is_approved_review form-control" name="status"  data-product-id="' . $query->id . '">
                            <option value="1" ' . $selectedApprove . '>Approve</option>
                            <option value="0" ' . $selectedPending . '>Pending</option>
                        </select>';
            })
            ->addColumn('action', function ($query){
                return '
                    <form class="form-delete me-2" style="display:inline-block" action="'.route('admin.review.destroy', $query).'" method="POST">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                    </form>';
            })
            ->rawColumns(['rating', 'product','status','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(\App\Models\ProductReview $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('adminreview-table')
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
            Column::make('product'),
            Column::make('rating'),
            Column::make('review'),
            Column::make('username'),
            Column::make('vendor'),
            Column::make('status'),
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
        return 'AdminReview_' . date('YmdHis');
    }
}
