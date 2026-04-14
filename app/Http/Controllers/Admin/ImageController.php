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
        // Image creation is now handled within the Project creation form.
        // Redirect to project.create and suggest selecting/adding images there.
        return redirect()->route('project.create')->with('info', 'Add images while creating a project.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageRequest $request)
    {
        $data = [];
        if ($request->has('imgs')) {
            $max = Image::where('project_id', $request->project_id)->max('sort_order');
            $next = is_null($max) ? 0 : ($max + 1);
            foreach ($request->imgs as $img) {
                $data = [
                    'img' => $this->uploadPhoto($img, 'images'),
                    'project_id' => $request->project_id,
                    'sort_order' => $next++,
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
