<?php

namespace App\DataTables;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BlogDataTable extends DataTable
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
                $editButton = '';
                $deleteForm = '';

                if (Gate::check('blog.edit', $query)) {
                    $editButton = '<a href="'.route('admin.blog.edit', $query).'" class="btn btn-primary"><i class="fas fa-edit"></i></a>';
                }
                if (Gate::check('blog.delete', $query)) {
                    $deleteForm = '
                                 <form class="form-delete" style="display:inline-block" action="'.route('admin.blog.destroy', $query).'" method="POST">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger btn-delete-item"><i class="fas fa-trash"></i></button>
                                </form>';
                }
                return $editButton . $deleteForm;

            })
            ->addColumn('image',function ($query){
                $img = '<img width="100" src="'.asset($query->image).'">';
                return $img;
            })
            ->addColumn('publish_date',function ($query){
                return $query->created_at->format('d-m-Y');
            })
            ->addColumn('category',function ($query){
                return $query->category->name;
            })
            ->addColumn('author', function ($query){
                return $query->user->name;
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? 'checked' : null;
                $statusButton = '';
                if (Gate::check('blog.edit', $query)) {
                    $statusButton = '<label class="custom-switch switch-status mt-2" style="cursor: pointer">
                            <form class="form-status" action="'.route('admin.blog.update', $query).'" method="post" type="submit">
                                    ' . csrf_field() . '
                                    ' . method_field('PUT') . '
                            <input type="checkbox" name="custom-switch-checkbox switch_status" class="custom-switch-input" ' . $checked . '>
                            <span class="custom-switch-indicator"></span>
                            </form>
                        </label>';
                }
                return $statusButton;
            })
            ->rawColumns(['image','action','status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Blog $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('blog-table')
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
            Column::make('image'),
            Column::make('title'),
            Column::make('category'),
            Column::make('status'),
            Column::make('author'),
            Column::make('publish_date'),
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
        return 'Blog_' . date('YmdHis');
    }
}
