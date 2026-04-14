<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Traits\media;

class ProjectController extends Controller
{
    use media;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        return view('project.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        // create project first
        $project = Project::create($data);

        // handle images (if any) and attach to project
        if ($request->hasFile('imgs')) {
            $i = 0;
            foreach ($request->file('imgs') as $img) {
                $imgName = $this->uploadPhoto($img, 'images');
                Image::create([
                    'img' => $imgName,
                    'project_id' => $project->id,
                    'sort_order' => $i++,
                ]);
            }
        }
         if ($request->button == 'all') {
            return redirect()->route('project.index')->with('successes', 'successful operation');
        } else {
            return redirect()->back()->with('successes', 'successful operation');
        }
    }

    /**
     * Update images order and deletions for a project.
     */
    public function updateImages(Request $request, Project $project)
    {
        DB::transaction(function () use ($request, $project) {
            // Handle deletions first
            $toDelete = $request->input('images_to_delete', []);
            if (!empty($toDelete)) {
                $images = Image::whereIn('id', $toDelete)->where('project_id', $project->id)->get();
                foreach ($images as $img) {
                    $this->deletePhoto(public_path("dist/img/images/{$img->img}"));
                }
                Image::whereIn('id', $toDelete)->where('project_id', $project->id)->delete();
            }

            // Update sort order for remaining images
            $order = $request->input('image_order', []);
            $pos = 0;
            foreach ($order as $id) {
                Image::where('id', $id)->where('project_id', $project->id)->update(['sort_order' => $pos++]);
            }
        });

       // return redirect()->back()->with('successes', 'Images updated successfully');
    
        if ($request->button == 'all') {
            return redirect()->route('project.index')->with('successes', 'successful operation');
        } else {
            return redirect()->back()->with('successes', 'successful operation');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $categories = Category::select('id', 'name')->get();
        return view('project.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $project->update($data);

        // Handle deletions submitted from edit form (marked client-side)
        $toDelete = $request->input('images_to_delete', []);
        if (!empty($toDelete)) {
            $images = Image::whereIn('id', $toDelete)->where('project_id', $project->id)->get();
            foreach ($images as $img) {
                $this->deletePhoto(public_path("dist/img/images/{$img->img}"));
            }
            Image::whereIn('id', $toDelete)->where('project_id', $project->id)->delete();
        }

        // Handle reordering and new images (image_order_mixed[] entries expected: 'existing:ID' or 'new:INDEX')
        if ($request->has('image_order_mixed')) {
            $mixed = $request->input('image_order_mixed');
            $newFiles = $request->file('imgs') ?? [];
            $newFiles = is_array($newFiles) ? array_values($newFiles) : [];
            $order = 0;
            foreach ($mixed as $entry) {
                if (str_starts_with($entry, 'existing:')) {
                    $id = intval(substr($entry, strlen('existing:')));
                    Image::where('id', $id)->update(['sort_order' => $order++]);
                } elseif (str_starts_with($entry, 'new:')) {
                    $index = intval(substr($entry, strlen('new:')));
                    if (isset($newFiles[$index])) {
                        $imgName = $this->uploadPhoto($newFiles[$index], 'images');
                        Image::create([
                            'img' => $imgName,
                            'project_id' => $project->id,
                            'sort_order' => $order++,
                        ]);
                    }
                }
            }
        } else {
            // If no mixed ordering provided but new files exist, append them after current max
            if ($request->hasFile('imgs')) {
                $max = $project->images()->max('sort_order');
                $next = is_null($max) ? 0 : ($max + 1);
                foreach ($request->file('imgs') as $img) {
                    $imgName = $this->uploadPhoto($img, 'images');
                    Image::create([
                        'img' => $imgName,
                        'project_id' => $project->id,
                        'sort_order' => $next++,
                    ]);
                }
            }
        }

        return redirect()->route('project.index')->with('successes', 'successful operation');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {     
        $project->delete();
        return redirect()->route('project.index')->with('successes', 'successful operation');
    }
}
