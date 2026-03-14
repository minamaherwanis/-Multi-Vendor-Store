<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products=Product::with(relations: ['category','store'])->filter( $request->query())-> paginate();

        return view('dashboard.products.index' ,compact('products'));    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
 $product = new Product();
        return View('dashboard.products.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'status'      => 'required|in:active,inactive',
        'category_id' => 'required|exists:categories,id',
        'tags'        => 'nullable|string',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $data = $request->except(['tags', 'image']);

    $data['store_id'] = Auth::user()->store_id;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $path = $file->store('uploads', 'public');
        $data['image'] = $path;
    }

    $product = Product::create($data);

    $tags = explode(',', $request->input('tags'));
    $tags_ids = [];
    foreach ($tags as $tag_name) {
        $tag_name = trim($tag_name);
        if ($tag_name == '') continue;

        $slug = Str::slug($tag_name);
        $tag = Tag::firstOrCreate(['slug' => $slug], ['name' => $tag_name]);
        $tags_ids[] = $tag->id;
    }
    $product->tags()->sync($tags_ids);

    return redirect()->route('products.index')->with('success', 'تم إنشاء المنتج بنجاح');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $product=Product::findOrFail($id);
       $tags=implode( ' , ',$product->tags->pluck('name')->toArray());

        return View('dashboard.products.edit',compact('tags','product'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Product $product)
{
        $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'status'      => 'required|in:active,inactive',
        'category_id' => 'required|exists:categories,id',
        'tags'        => 'nullable|string',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);


    $data = $request->except(['tags', 'image']);

    $tags = explode(',', $request->input('tags'));
    $tags_ids = [];

    foreach ($tags as $tag_name) {
        $slug = Str::slug($tag_name);
        $tag = Tag::where('slug', $slug)->first();

        if (!$tag) {
            $tag = Tag::create([
                'name' => $tag_name,
                'slug' => $slug,
            ]);
        }

        $tags_ids[] = $tag->id;
    }

    $product->tags()->sync($tags_ids);

    $old_image = $product->image;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $path = $file->store('uploads', 'public');
        $data['image'] = $path;

        if ($old_image) {
            Storage::disk('public')->delete($old_image);
        }
    } else {
        $data['image'] = $old_image;
    }

    $product->update($data);

    return redirect()->route('products.index')->with('success', 'تم التحديث بنجاح');
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
         return redirect()->route('products.index')->with('success', 'deleted');
    }

}
