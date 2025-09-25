<?php

namespace App\Http\Controllers\User;

use App\Http\Traits\ApiTrait;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;


class ProjectsController extends Controller
{
    use ApiTrait;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
         $projects =  Project::with('images')->get();
         return $this->dataResponse(ProjectResource::collection($projects));
    }
}
