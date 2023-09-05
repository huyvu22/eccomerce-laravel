<?php

namespace App\DataTables;

use App\Models\ProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class VendorProductVariantItemDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('variant',function ($query){
                return $query->variant->name;
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : null;
                return '<label class="switch-status form-check form-switch" style="cursor: pointer"">
                            <form class="form-status" action="'.route('vendor.products-variant-item.update', $query).'" method="post" type="submit">
                                    ' . csrf_field() . '
                                    ' . method_field('PUT') . '
                                <input type="checkbox" style="cursor: pointer; width:50px;height:20px;" name="switch_status custom-switch-checkbox" id="flexSwitchCheckChecked" class="form-check-input custom-switch-input" ' . $checked . ' >
                            <span class="custom-switch-indicator"></span>
                            </form>
                        </label>';
            })
            ->addColumn('action', function ($query){
                return '<a href="'.route('vendor.products-variant-item.edit', $query).'" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <form class="form-delete me-2" style="display:inline-block" action="'.route('vendor.products-variant-item.destroy', $query).'" method="POST">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                        </form>';
            })
            ->addColumn('is_default', function ($query) {
                return '<button class="badge ' . ($query->is_default == 1 ? 'bg-success' : 'bg-info') . '">' . ($query->is_default == 1 ? 'default' : 'no') . '</a>';
            })
            ->rawColumns(['variant','status','action','is_default'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model->where('product_variant_id',request()->variantId)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorproductvariantitem-table')
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
            Column::make('id')->width(70),
            Column::make('name'),
            Column::make('variant'),
            Column::make('price'),
            Column::make('is_default'),
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
        return 'VendorProductVariantItem_' . date('YmdHis');
    }
}
