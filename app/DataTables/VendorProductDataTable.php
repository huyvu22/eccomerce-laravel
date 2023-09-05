<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VendorProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('thumb_image',function ($query){
                $img = '<img width="70" src="'.asset($query->thumb_image).'">';
                return $img;
            })
            ->addColumn('action', function ($query){
                $editBtn = '<a href="'.route('vendor.products.edit', $query).'" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
                $deleteBtn = ' <form class="form-delete" style="display:inline-block" action="'.route('vendor.products.destroy', $query).'" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                            </form>';
                $moreAction = '<div class="btn-group dropstart m-1">
                                  <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                  </button>
                                  <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="'.route('vendor.products-image-gallery.index',['product'=>$query]).'"><i class="fas fa-images"></i> Image Galleries</a></li>
                                    <li><a class="dropdown-item" href="'.route('vendor.products-variant.index',['product'=>$query]).'"><i class="fas fa-file"></i> Variants</a></li>
                                  </ul>
                                </div>';
                return $moreAction.$editBtn.$deleteBtn;

            })

            ->addColumn('price',function ($query){
                return number_format($query->price,0,',','.').'₫';
            })

            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : null;
                return '<label class="switch-status form-check form-switch">
                            <form class="form-status" action="'.route('vendor.products.update', $query).'" method="post" type="submit" >
                                    ' . csrf_field() . '
                                    ' . method_field('PUT') . '
                                <input type="checkbox" style="cursor: pointer; width:50px;height:20px;" name="switch_status custom-switch-checkbox" id="flexSwitchCheckChecked" class="form-check-input custom-switch-input" ' . $checked . ' >
                                <span class="custom-switch-indicator"></span>
                            </form>
                        </label>';
            })

            ->addColumn('product_type', function ($query){
                switch ($query){
                    case $query->product_type =='top_product':
                        return '<i class="badge bg-success">Top Product</i>';
                    case $query->product_type =='new_arrival':
                        return '<i class="badge bg-primary">New Arrival</i>';
                    case $query->product_type =='best_product':
                        return '<i class="badge bg-info">Best Product</i>';
                    case $query->product_type =='featured':
                        return '<i class="badge bg-secondary">Featured Product</i>';
                    default:
                        return '<i class="badge bg-dark">None</i>';
                }
            })

            ->addColumn('approved', function ($query){
               if($query->is_approved === 0){
                   return '<i class="badge bg-danger">pending</i>';
               }else {
                   return '<i class="badge bg-success">approved</i>';
               }
            })

            ->rawColumns(['thumb_image','action','status','approved','product_type'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->where('vendor_id',\Auth::user()->vendor->id)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproduct-table')
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
            Column::make('name'),
            Column::make('thumb_image'),
            Column::make('price'),
            Column::make('approved'),
            Column::make('product_type'),
            Column::make('status'),
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
        return 'VendorProduct_' . date('YmdHis');
    }
}
