<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

     public function dataTable($query)
     {
         return datatables()
             ->of($query)
             ->addColumn('role', function ($row) {
                 // Display the current role of the user with an editable dropdown
                 return view('users.role', compact('row'));
             })
             ->addColumn('status', function ($row) {
                 // Display the current status of the user
                 return view('users.status', compact('row'));
             })
             ->addColumn('action', function ($row) {
                 return '
                     <div class="d-flex justify-content-center gap-2">
                         <button class="btn btn-sm btn-primary update-btn" 
                                 data-id="' . $row->id . '"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#updateModal">
                             <i class="fas fa-edit"></i> Update
                         </button>
                     </div>
                 ';
             })
             ->rawColumns(['role', 'status', 'action'])
             ->setRowId('id');
     }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model)
    {
        return DB::table('users')
        ->join('customer', 'users.id', '=', 'customer.user_id')
        ->select(
            'users.id AS id',
            'users.name',
            'users.email',
            'users.role',
            'users.status',
            'customer.addressline',
            'customer.phone',
            'users.created_at'
        )
        ->where('users.id', '<>', Auth::id());
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom(
                "<'row mb-3'<'col-md-6 d-flex align-items-center gap-2'B><'col-md-6 text-end'f>>" . // Buttons and search bar in one row
                "rt" . // Table
                "<'row mt-3'<'col-md-6'i><'col-md-6 text-end'p>>" // Info and pagination in one row
            )
            ->orderBy(1)
            ->parameters([
                'buttons' => ['export', 'print', 'reset', 'reload', 'pdf', 'excel'],
                'language' => [
                    'search' => '_INPUT_',
                    'searchPlaceholder' => 'Search user...',
                    'paginate' => [
                        'previous' => '&laquo;',
                        'next' => '&raquo;',
                    ],
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('Customer ID'),
            Column::make('name'),
            Column::make('email'),
            Column::make('addressline')->title('Address')->searchable(false),
            Column::make('phone')->searchable(false),
            Column::make('created_at'),
            Column::computed('role'),
            Column::computed('status')
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
        return 'Users_' . date('YmdHis');
    }
}
