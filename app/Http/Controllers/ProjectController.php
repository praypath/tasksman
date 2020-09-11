<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller
{
    /*
     * @pathname: /projects
     * @request: get
     * @response: json
     */
    public function index(){
        $projects = Project::where('is_completed', false)
                    ->orderby('created_at', 'desc')
                    ->withCount(['tasks'=>function($query){
                        $query->where('is_completed', false);
                    }])
                    ->get();
        return $projects->toJson();
    }

    /*
     * @pathname: /projects
     * @request: post
     * @response: json
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $project = Project::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        return response()->json('Project created!');
    }

    /*
     * @pathname: /projects/{id}
     * @request: get
     * @response: json
     */
    public function show($id)
    {
        $project = Project::with(['tasks' => function ($query) {
            $query->where('is_completed', false);
        }])->find($id);

        return $project->toJson();
    }

    /*
     * @pathname: /projects/{project}
     * @request: put
     * @response: json
     */
    public function markAsCompleted(Project $project)
    {
        $project->is_completed = true;
        $project->update();

        return response()->json('Project updated!');
    }
}
