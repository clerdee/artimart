<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ItemsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param mixed $query Results from query() method.
     */
    public function dataTable($query)
    {
        return datatables()->query($query)
            ->filter(function ($query) {
                if ($search = request('search')['value'] ?? null) {
                    $query->where('i.item_name', 'like', "%{$search}%")
                          ->orWhere('i.description', 'like', "%{$search}%")
                          ->orWhere('c.description', 'like', "%{$search}%")
                          ->orWhere('i.item_id', 'like', "%{$search}%");
                }
            })
            ->editColumn('images', function ($row) {
                if (!$row->images) return '-';
                $paths = explode(',', $row->images);
                $html = '';
                foreach ($paths as $path) {
                    $url = asset('storage/images/' . basename($path));
                    $html .= "<img src='{$url}' width='60' class='img-thumbnail me-1 mb-1' />";
                }
                return $html;
            })
            ->addColumn('action', function ($row) {
                if ($row->deleted_at) {
                    return '
                        <div class="d-flex justify-content-center">
                            <form method="POST" action="' . route('items.restore', $row->item_id) . '">
                                ' . csrf_field() . '
                                <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                            </form>
                        </div>
                    ';
                } else {
                    return '
                        <div class="d-flex justify-content-center gap-2">
                            <a href="' . route('items.edit', $row->item_id) . '" class="btn btn-sm btn-primary">Edit</a>
                            <form method="POST" action="' . route('items.destroy', $row->item_id) . '" onsubmit="return confirm(\'Are you sure you want to delete this item?\');">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    ';
                }
            })
            ->rawColumns(['action', 'images'])
            ->setRowId('item_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query()
    {
        $items = DB::table('item as i')
            ->leftJoin('category as c', 'i.category_id', '=', 'c.category_id')
            ->leftJoin('item_images as ii', 'i.item_id', '=', 'ii.item_id')
            ->leftJoin('stock as s', 'i.item_id', '=', 's.item_id') // Join stock table
            ->select(
                'i.item_id',
                'i.item_name',
                'i.description',
                'i.cost_price',
                'i.sell_price',
                's.quantity', 
                'i.deleted_at',
                'i.category_id',
                'c.description as category',
                DB::raw('GROUP_CONCAT(ii.image_path) as images')
            )
            ->groupBy(
                'i.item_id',
                'i.item_name',
                'i.description',
                'i.cost_price',
                'i.sell_price',
                's.quantity', 
                'i.deleted_at',
                'i.category_id',
                'c.description'
            );

        return $items;
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
                    'searchPlaceholder' => 'Search item...',
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
                ->width(100)
                ->addClass('text-center'),

            Column::make('item_id')->title('Item ID'),
            Column::make('item_name')->title('Item Name')->searchable(true),
            Column::make('description')->title('Description')->searchable(true),
            Column::make('cost_price')->title('Cost Price'),
            Column::make('sell_price')->title('Sell Price'),
            Column::make('quantity')->title('Quantity'),
            Column::make('category')->title('Category')->searchable(true),
            Column::make('images')->title('Images')->orderable(false)->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Items_' . date('YmdHis');
    }
}