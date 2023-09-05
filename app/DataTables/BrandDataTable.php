<?php

namespace App\DataTables;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BrandDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query)) // $query is instance of Slider Model
        ->addColumn('action', function ($query) {
            $editButton = '';
            $deleteForm = '';

            if (Gate::check('brand.edit', $query)) {
                $editButton = '<a href="'.route('admin.brand.edit', $query).'" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
            }

            if (Gate::check('brand.delete', $query)) {
                $deleteForm = '
                        <form class="form-delete" style="display:inline-block" action="'.route('admin.brand.destroy', $query).'" method="POST">'
                                . csrf_field()
                                . method_field('DELETE') .
                                '<button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                        </form>';
                        }
            return $editButton . $deleteForm;
        })


            ->addColumn('logo',function ($query){
                $img = '<img width="100" src="'.asset($query->logo).'">';
                return $img;
            })
            ->addColumn('is_featured',function ($query){
                return $query->is_featured ==1 ?'<i class="badge badge-success">Yes</i>' :'<i class="badge badge-danger">No</i>';
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : null;
                $statusButton = '';
                if (Gate::check('brand.edit', $query)) {
                    $statusButton = '<label class="custom-switch switch-status mt-2" style="cursor: pointer">
                            <form class="form-status" action="'.route('admin.brand.update', $query).'" method="post" type="submit">
                                    ' . csrf_field() . '
                                    ' . method_field('PUT') . '
                            <input type="checkbox" name="custom-switch-checkbox switch_status" class="custom-switch-input" ' . $checked . '>
                            <span class="custom-switch-indicator"></span>
                            </form>
                        </label>';
                }
                return $statusButton;
            })
            ->rawColumns(['logo','action','status','is_featured'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Brand $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('brand-table')
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
            Column::make('id')->width(50),
            Column::make('logo')->width(300),
            Column::make('name')->width(200),
            Column::make('is_featured') ->width(200),
            Column::make('status') ->width(200),
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
        return 'Brand_' . date('YmdHis');
    }
}
