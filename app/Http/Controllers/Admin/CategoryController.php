<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use App\Http\Traits\media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditCaregoryRequest;
use App\Http\Requests\StoreCaregoryRequest;

class CategoryController extends Controller
{
    use media;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCaregoryRequest $request)
    {
        $imgName = $this->uploadPhoto($request->img,'categories');
        $data=$request->except('img','button','_token');
        $data['img'] = $imgName;
        Category::create($data);
        if ($request->button == 'all') {
            return redirect()->route('category.index')->with('successes', 'successful operation');
        } else {
            return redirect()->back()->with('successes', 'successful operation');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
       
        return view('category.show',compact('category'));   
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCaregoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if ($request->has('img')) {
            $oldName = $category->img;
            $path = public_path('dist/img/categories/' . $oldName);
            $this->deletePhoto($path);
            $imgName = $this->uploadPhoto($data['img'], 'categories');
            $data['img'] = $imgName;
        }
        Category::where('id', $category->id)->update($data);
        return redirect()->route('category.index')->with('successes', 'successful operation');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $oldName = $category->img;
        $path = public_path('dist/img/categories/' . $oldName);
        $this->deletePhoto($path);
        $category->delete();
        return redirect()->route('category.index')->with('successes', 'successful operation');
    }
}
