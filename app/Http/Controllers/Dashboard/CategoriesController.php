<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\NullableType;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();

        $categories = Category::with('parent')->filter(filter: $request->query())->paginate();
        // leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        //     ->select([
        //         'categories.*',
        //         'parents.name as parent_name'
        //     ])


        //  ✅parents بنسخة تانية من نفسه اسمناها categories اربط جدول 
        // ✅ ووصّل بين الاتنين عن طريق
        // parents.id (رقم الأب)    *الوهمي من الجدول ال اخترعناه*
        // categories.parent_id ( للي بيشاور على الأب)     *الحقيقي *
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());

        $request->merge([
            'slug' => Str::slug($request->name)
        ]);

        // $name = request()->name;
        // $parent_id = request()->parent_id;
        // $description = request()->description;
        // $image = request()->image;
        // $status = request()->status;
        // $slug = $request->slug;



        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', 'public');
            $data['image'] = $path;
        } else {
            $data['image'] = null;

        }

        Category::create($data);
        return to_route('categories.index')->with('success', 'Category Created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $th) {
            return to_route('categories.index')->with('info', 'Record not found');

        }
        // هاتلي كل الداتا من جدول الكاتيجري ماعادا الصف الي 
        //  بتاعه هو ال بينعدل فيه حاليا id  (يعني ميجيبش نفسه )

        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {

                $query->whereNull('parent_id')
                    ->orwhere('parent_id', '<>', $id); //يعني الي البارينت اي دي بتاعه يساوي اي دي ال بنعدل فيه متجبهوش
            })->get();


        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**s
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(Category::rules($id));

        $singleCategoryFromDB = Category::findOrFail($id);
        $old_image = $singleCategoryFromDB->image;

        $data = $request->except('image');

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

        $singleCategoryFromDB->update($data);

        return to_route('categories.index')->with('success', 'Category Updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ssinglecategoryfromDB = Category::findOrFail($id);
        $ssinglecategoryfromDB->delete();

        return to_route('categories.index')->with('success', 'Category deleted');

    }
    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();



        return view('dashboard.categories.trash', compact('categories'));

    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();




        return to_route('categories.trash')->with('success', 'Category restore!');

    }
    public function forceDelete($id)
    {
        $ssinglecategoryfromDB = Category::onlyTrashed()->findOrFail($id);
        $ssinglecategoryfromDB->forceDelete();

        if ($ssinglecategoryfromDB->image) {
            Storage::disk('public')->delete($ssinglecategoryfromDB->image);

        }

        return to_route('categories.trash')->with('success', 'Category deleted forever !');

    }

}
