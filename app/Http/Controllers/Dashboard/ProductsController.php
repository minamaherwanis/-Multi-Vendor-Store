<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Str;
use Illuminate\Support\Facades\Storage;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::with(relations: ['category','store'])-> paginate();

        return view('dashboard.products.index' ,compact('products'));    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    // تحديث باقي بيانات المنتج ماعدا التاجز والصورة
    $data = $request->except(['tags', 'image']);

    // التعامل مع التاجز
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

    // معالجة الصورة
    $old_image = $product->image;

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $path = $file->store('uploads', 'public');
        $data['image'] = $path;

        // حذف الصورة القديمة
        if ($old_image) {
            Storage::disk('public')->delete($old_image);
        }
    } else {
        // احتفظ بالصورة القديمة
        $data['image'] = $old_image;
    }

    // تحديث بيانات المنتج
    $product->update($data);

    return redirect()->route('products.index')->with('success', 'تم التحديث بنجاح');
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
