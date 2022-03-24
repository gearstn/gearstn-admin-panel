<?php

namespace App\DataTables;

use App\Models\News;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str ;
class NewsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $page = "news";
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) use ($page) {
                return view('admin/components/datatable/actions', compact("data", "page"));
            })
            ->editColumn('slug', function ($data) use ($page) {
                return view("admin/components/datatable/link")->with("link", env('APP_URL'). "/news/" . $data->slug);
            })
            ->editColumn("created_at", function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
            ->editColumn("bodytext_en", function ($data) {
                return Str::limit($data->bodytext_en, 30, '.......');
            })
            ->editColumn("bodytext_ar", function ($data) {
                return Str::limit($data->bodytext_en, 30, '.......');
            })
            ->editColumn("title", function ($data) {
                return ucfirst($data->title);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\News $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(News $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('datatable')
            ->rowId("id")
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Blfrtip')
            ->lengthMenu([5, 10, 25, 50, 100])
            ->pageLength(25)
            ->orderBy(0, "asce")
            ->buttons(
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title("ID"),
            Column::make('title_en'),
            Column::make('title_ar'),
            Column::make('post_date'),
            // Column::make('image_url')->title('Image Link'),
            Column::make('bodytext_en')->title('Body Text EN'),
            Column::make('bodytext_ar')->title('Body Text AR'),
            Column::make('slug'),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'News_' . date('YmdHis');
    }
}
