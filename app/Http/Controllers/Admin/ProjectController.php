<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
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
        //dd($data);
        Project::create($data);
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
        Project::where('id', $project->id)->update($data);
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
