<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Project;

class ProjectController extends Controller
{
    private $statuses = ['planned', 'running', 'on hold', 'finished', 'cancel'];

    public function createProject (Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'numeric|min:1|max:255',
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:4000',
            'status' => 'required|min:2|max:255',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        } else if (!in_array ($request->status, $this->statuses)) {
            return response()->json(['error' => 'incorrect status']);
        }

        $id = $this->updateCreateProject($request);

        return response($id, 200)->header('Content-Type', 'text/plain');
    }

    public function getProject (Request $request)
    {
        $id = preg_replace('#[^0-9]#', '', $request->id);

        $project = Project::where('id', '=', $id)->where('deleted', '!=', 1)->get();

        return response()->json($project);
    }

    public function getProjects ()
    {
        $projects = Project::where('deleted', '!=', 1)->get();

        return response()->json($projects);
    }

    public function updateProject (Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'numeric|min:1|max:255',
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:4000',
            'status' => 'required|min:2|max:255',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        } else if (!in_array ($request->status, $this->statuses)) {
            return response()->json(['error' => 'incorrect status']);
        }

        $id = $this->updateCreateProject($data);

        return response()->json(['id' => $id]);
    }

    public function deleteProject (Request $request)
    {
        $id = preg_replace('#[^0-9]#', '', $request->id);

        $project = Project::find($id);

        if ($project === null) {
            return response()->json(['status' => 'not_found']);
        }

        $this->updateCreateProject (['id' => $id, 'deleted' => 1]);

        return response()->json(['status' => 'done']);
    }

    private function updateCreateProject ($data)
    {
        $project = Project::updateOrCreate(
          ['id' => $data->id],[
            'name' => $data->name,
            'description' => $data->description,
            'status' => $data->status,
          ]
        );

        $id = Project::where([
            'updated_at' => $project->updated_at, 'status' => $project->status
          ])->pluck('id')->first();

        return $id;
    }
}
