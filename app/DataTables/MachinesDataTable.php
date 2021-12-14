<?php

namespace App\DataTables;

use App\Models\Machine;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MachinesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $page = "machines";
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) use ($page) {
                return view('admin/components/datatable/actions', compact("data", "page"));
            })
            ->addColumn("category", function ($data) {
                $category = $data->category()->pluck("title_en")->toArray();
                return ucfirst($category[0]);
            })
            ->addColumn("sub_category", function ($data) {
                $sub_category = $data->sub_category()->pluck("title_en")->toArray();
                return ucfirst($sub_category[0]);
            })
            ->addColumn("manufacture", function ($data) {
                $manufacture = $data->manufacture()->pluck("title_en")->toArray();
                return ucfirst($manufacture[0]);
            })
            ->addColumn("model", function ($data) {
                $model = $data->model()->pluck("title_en")->toArray();
                return ucfirst($model[0]);
            })
            ->editColumn("created_at", function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
            ->editColumn("title_en", function ($data) {
                return ucfirst($data->title_en);
            })
            ->editColumn("approved", function ($data) {
                if($data->approved) return 'Yes';
                else return 'No';
            })
            ->editColumn("featured", function ($data) {
                if($data->featured) return 'Yes';
                else return 'No';
            })
            ->editColumn("verified", function ($data) {
                if($data->verified) return 'Yes';
                else return 'No';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Machine $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Machine $model)
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
            Column::make('model'),
            Column::make('manufacture'),
            Column::make('sub_category'),
            Column::make('category'),
            Column::make('year'),
            Column::make('sell_type'),
            Column::make('price'),
            Column::make('approved'),
            Column::make('featured'),
            Column::make('verified'),
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
        return 'Machines_' . date('YmdHis');
    }
}
