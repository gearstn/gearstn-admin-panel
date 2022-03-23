<?php

namespace App\DataTables;

use App\Models\Conversation;
use App\Models\Machine;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;

class ConversationsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $page = "conversations";
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) use ($page) {
                return view('admin/components/datatable/actions', compact("data", "page"));
            })
            ->editColumn("acquire_done", function ($data) {
                return $data->acquire_done ? 'Done' : 'Not Done';
            })
            ->editColumn("owner_done", function ($data) {
                return $data->owner_done ? 'Done' : 'Not Done';
            })
            ->editColumn("acquire_id", function ($data) {
                $acquire = User::find($data->acquire_id)->first();
                return $acquire->first_name . ' | ' . $acquire->last_name . ' | ' . $acquire->company_name;
            })
            ->editColumn("owner_id", function ($data) {
                $owner = User::find($data->owner_id)->first();
                return $owner->first_name . ' | ' . $owner->last_name . ' | ' . $owner->company_name;
            })
            ->editColumn("machine_id", function ($data) {
                $machine = Machine::find($data->machine_id)->first();
                $link = env('APP_URL') . '/machines' . '/' . $machine->slug;
                return $link ;
            })
            ->editColumn("created_at", function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Conversation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Conversation $model)
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
            Column::make('acquire_done'),
            Column::make('owner_done'),
            Column::make('acquire_id'),
            Column::make('owner_id'),
            Column::make('machine_id'),
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
        return 'Conversations_' . date('YmdHis');
    }
}
