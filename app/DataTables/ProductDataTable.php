<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
                $editBtn = '';
                $deleteBtn = '';
                $moreBtn = '';
                if(Gate::check('product.edit', $query)){
                    $editBtn= '<a href="'.route('admin.products.edit', $query).'" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
                }

                if(Gate::check('product.delete', $query)){
                    $deleteBtn= ' <form class="form-delete" style="display:inline-block" action="'.route('admin.products.destroy', $query).'" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                            </form>';
                }

                if(Gate::check('product.edit', $query)){
                    $moreBtn= '<div class="dropdown d-inline dropleft">
                              <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fas fa-cog"></i>
                              </button>
                              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 28px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item has-icon" href="'.route('admin.products-image-gallery.index',['product'=>$query]).'"><i class="far fa-heart"></i> Image Gallery</a>
                                <a class="dropdown-item has-icon" href="'.route('admin.products-variant.index',['product'=>$query]).'"><i class="far fa-file"></i>Variants </a>
                                <a class="dropdown-item has-icon" href="#"><i class="far fa-clock"></i> Something else here</a>
                              </div>
                        </div>';
                }

                return $editBtn.$deleteBtn.$moreBtn;

            })

            ->addColumn('price',function ($query){
                return number_format($query->price,0,',','.').'₫';
            })

            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : null;
                return '<label class="custom-switch switch-status mt-2" style="cursor: pointer">
                            <form class="form-status" action="'.route('admin.products.update', $query).'" method="post" type="submit">
                                    ' . csrf_field() . '
                                    ' . method_field('PUT') . '
                            <input type="hidden" name="switch_status" value=""/>
                            <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" ' . $checked . '>
                            <span class="custom-switch-indicator"></span>
                            </form>
                        </label>';
            })

            ->addColumn('product_type', function ($query){
                switch ($query){
                    case $query->product_type =='top_product':
                        return '<i class="badge badge-success">Top Product</i>';
                    case $query->product_type =='new_arrival':
                        return '<i class="badge badge-primary">New Arrival</i>';
                    case $query->product_type =='best_product':
                        return '<i class="badge badge-info">Best Product</i>';
                    case $query->product_type =='featured':
                        return '<i class="badge badge-danger">Featured Product</i>';
                    default:
                        return '<i class="badge badge-dark">None</i>';
                }
            })

            ->rawColumns(['thumb_image','action','status','product_type'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
//        return $model->where('vendor_id',\Auth::user()->vendor->id)->newQuery();
        $user = \Auth::user();

        if ($user->role == 'staff') {
            return $model->where('vendor_id', 1)->newQuery();
        } else {
            return $model->where('vendor_id', $user->vendor->id)->newQuery();
        }
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
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
            Column::make('product_type'),
            Column::make('status')->addClass('text-center'),
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
        return 'Product_' . date('YmdHis');
    }
}
