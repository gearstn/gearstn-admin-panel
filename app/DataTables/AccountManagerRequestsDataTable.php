<?php

namespace App\DataTables;

use App\Models\AccountManager;
use App\Models\AccountManagerRequest;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AccountManagerRequestsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $page = "account-managers";
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) use ($page) {
                return view('admin/components/datatable/actions', compact("data", "page"));
            })
            ->editColumn("created_at", function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
            ->editColumn("assigned_to_id", function ($data) {
                $user = User::find($data->assigned_to_id);
                return $user != null ? $user->email : 'Not Assigned';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AccountManager $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AccountManager $model)
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
            Column::make('company_name'),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('email'),
            Column::make('assigned_to_id')->title('Assigned To'),
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
        return 'AccountManagerRequests_' . date('YmdHis');
    }
}
