<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\ImportProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ImportProductsController extends Controller
{
    public function create(){
        return view('dashboard.products.import');
    }
public function store(Request $request)
{
    $request->validate([
        'count' => 'required|integer|min:1',
    ]);

    ImportProducts::dispatch($request->count)
        ->onQueue('import')
        ->delay(now()->addSeconds(5));

return redirect()
    ->route('products.index')
    ->with('success', 'Import is runing....');}

}
