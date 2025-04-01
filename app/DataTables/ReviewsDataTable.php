<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReviewsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param mixed $query Results from query() method.
     */
    public function dataTable($query)
    {
        return datatables()
            ->query($query)
            ->editColumn('images', function ($row) {
                if (!$row->images) return '-';
                $paths = explode(',', $row->images);
                $html = '';
                foreach ($paths as $path) {
                    $url = asset('storage/review_media/' . basename($path));
                    $html .= "<a href='{$url}' target='_blank'><img src='{$url}' width='60' class='img-thumbnail me-1 mb-1' /></a>";
                }
                return $html;
            })
            ->addColumn('action', function ($row) {
                if ($row->deleted_at) {
                    return '
                        <form method="POST" action="' . route('reviews.restore', $row->review_id) . '" style="display:inline-block;">
                            ' . csrf_field() . '
                            <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                        </form>
                    ';
                } else {
                    return '
                        <form method="POST" action="' . route('reviews.destroy', $row->review_id) . '" style="display:inline-block;" onsubmit="return confirm(\'Are you sure you want to delete this review?\');">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    ';
                }
            })
            ->filterColumn('orderinfo_id', function ($query, $keyword) {
                $query->where('r.orderinfo_id', 'like', "%{$keyword}%");
            })
            ->filterColumn('item', function ($query, $keyword) {
                $query->where('i.item_name', 'like', "%{$keyword}%");
            })
            ->filterColumn('customer', function ($query, $keyword) {
                $query->whereRaw("LOWER(CONCAT(c.fname, ' ', c.lname)) like ?", ["%" . strtolower($keyword) . "%"]);
            })
            ->rawColumns(['action', 'images'])
            ->setRowId('review_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query()
    {
        $reviews = DB::table('reviews as r')
            ->leftJoin('customer as c', 'r.customer_id', '=', 'c.customer_id')
            ->leftJoin('item as i', 'r.item_id', '=', 'i.item_id')
            ->leftJoin('review_images as ri', 'r.review_id', '=', 'ri.review_id')
            ->select(
                'r.review_id',
                'r.orderinfo_id',
                'r.customer_id',
                'r.item_id',
                'r.rating',
                'r.review_text',
                'r.deleted_at',
                DB::raw('GROUP_CONCAT(ri.image_path) as images'),
                DB::raw("CONCAT(c.fname, ' ', c.lname) as customer"),
                'i.item_name as item'
            )
            ->groupBy(
                'r.review_id',
                'r.orderinfo_id',
                'r.customer_id',
                'r.item_id',
                'r.rating',
                'r.review_text',
                'r.deleted_at',
                'c.fname',
                'c.lname',
                'i.item_name'
            );

        return $reviews;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('reviews-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom(
                "<'row mb-3'<'col-md-6 d-flex align-items-center gap-2'B><'col-md-6 text-end'f>>" . // Buttons and search bar in one row
                "rt" . // Table
                "<'row mt-3'<'col-md-6'i><'col-md-6 text-end'p>>" // Info and pagination in one row
            )
            ->orderBy(1)
            ->parameters([
                'buttons' =>  ['export', 'print', 'reset', 'reload', 'pdf', 'excel'],
                'language' => [
                    'search' => '_INPUT_',
                    'searchPlaceholder' => 'Search reviews...',
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
                ->title('Actions'),

            Column::make('review_id')->title('Review ID'),
            Column::make('orderinfo_id')->title('Order ID'),
            Column::make('customer')->title('Customer Name')->name('customer'),
            Column::make('item')->title('Item Name')->name('item'),
            Column::make('rating')->title('Rating'),
            Column::make('review_text')->title('Review Text'),
            Column::make('images')
                ->title('Media Files')
                ->name('images')
                ->orderable(false)
                ->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Reviews_' . date('YmdHis');
    }
}