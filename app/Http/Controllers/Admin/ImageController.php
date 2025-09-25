<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Traits\media;
use App\Models\Image;
use App\Models\Project;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use media;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects =  Project::with('images')->get();
        //dd($projects->first()->images);
        return view('image.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('image.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageRequest $request)
    {
        $data = [];
        if ($request->has('imgs')) {
            foreach ($request->imgs as $img) {

                $data = [
                    'img' => $this->uploadPhoto($img, 'images'),
                    'project_id' => $request->project_id,
                ];
                Image::create($data);
            }
            
            if ($request->button == 'all') {
                return redirect()->route('img.index')->with('successes', 'successful operation');
            } else {
                return redirect()->back()->with('successes', 'successful operation');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404, 'page not found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404, 'page not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404, 'page not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $img)
    {
        $oldName = $img->img;
        $path = public_path('dist/img/images/' . $oldName);
        $this->deletePhoto($path);
        $img->delete();
        return redirect()->back()->with('successes', 'successful operation');
    }
}
