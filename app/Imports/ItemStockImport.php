<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Stock;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Illuminate\Support\Collection;

class ItemStockImport implements ToCollection, WithHeadingRow, WithDrawings
{
    protected $drawings = [];

    public function drawings()
    {
        return $this->drawings;
    }

    public function collection(Collection $rows)
    {
        $drawingMap = [];

        foreach ($this->drawings as $drawing) {
            if ($drawing instanceof Drawing && $drawing->getCoordinates()) {
                $coordinate = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::coordinateFromString($drawing->getCoordinates());
                $rowNumber = $coordinate[1];
                $drawingMap[$rowNumber][] = $drawing;
            }
        }

        $excelDataStartRow = 2;

        foreach ($rows as $index => $row) {
            $currentRow = $index + $excelDataStartRow;
            $category = Category::where('description', $row['category_name'])->first();

            $item = Item::create([
                'item_name'   => $row['item_name'],
                'description' => $row['description'] ?? null,
                'cost_price'  => $row['cost_price'],
                'sell_price'  => $row['sell_price'],
                'category_id' => $category ? $category->category_id : null,
            ]);

            Stock::create([
                'item_id'  => $item->item_id,
                'quantity' => $row['quantity'],
            ]);

            if (isset($row['image_path'])) {
                $imagePaths = explode(',', $row['image_path']); 
                foreach ($imagePaths as $imagePath) {
                    $imagePath = trim($imagePath); 
            
                    // Check if the path is a URL
                    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                        $imageContent = file_get_contents($imagePath); 
                        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            
                        $hashName = Str::random(40) . '.' . $extension;
                        $storagePath = 'public/images/' . $hashName;
            
                        Storage::put($storagePath, $imageContent); 
            
                        ItemImage::create([
                            'item_id'    => $item->item_id,
                            'image_path' => $storagePath,
                        ]);
                    }
                }
            }
        }
    }
}
