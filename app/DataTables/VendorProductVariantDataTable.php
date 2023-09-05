<?php

namespace App\DataTables;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VendorProductVariantDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : null;
                return '<label class="switch-status form-check form-switch" style="cursor: pointer">
                            <form class="form-status" action="'.route('vendor.products-variant.update', $query).'" method="post" type="submit">
                                    ' . csrf_field() . '
                                    ' . method_field('PUT') . '
                                <input type="checkbox" style="cursor: pointer; width:50px;height:20px;" name="switch_status custom-switch-checkbox" id="flexSwitchCheckChecked" class="form-check-input custom-switch-input" ' . $checked . ' >
                           <span class="custom-switch-indicator"></span>
                            </form>
                        </label>';
            })
            ->addColumn('action', function ($query){
                $variantBtn = '<a href="'.route('vendor.products-variant-item.index',['productId' => request()->product, 'variantId' => $query->id]).'" class="btn btn-info me-1"><i class="fa fa-edit"></i> Variant Items</a>';
//                $variantBtn = '<a href="'.route('admin.products-variant-item.index').'?productId='.request()->product.'&variantId='.$query->id.'" class="btn btn-info mr-1"><i class="fa fa-edit"></i> Variant Items</a>';
                $editBtn= '<a href="'.route('vendor.products-variant.edit', $query).'" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
                $deleteBtn= ' <form class="form-delete" style="display:inline-block" action="'.route('vendor.products-variant.destroy', $query).'" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                            </form>';
                return $variantBtn.$editBtn.$deleteBtn;

            })
            ->rawColumns(['status','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariant $model): QueryBuilder
    {
        return $model->where('product_id',request()->product)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproductvariant-table')
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
            Column::make('status')->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(310)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorProductVariant_' . date('YmdHis');
    }
}
