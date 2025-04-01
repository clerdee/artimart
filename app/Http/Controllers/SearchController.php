<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Models\Item;
use App\Models\Customer;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // dd($request->term);
        $searchResults = (new Search())
            ->registerModel(Item::class, 'item_name')
            ->search(trim($request->term));
            
            foreach ($searchResults as $result) {
                if ($result->searchable instanceof Item) {
                    $result->searchable->load('firstImage');
                }
            }

            // dd($searchResults);
            return view('search', compact('searchResults'));
    }
}