<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Project;

class ProjectController extends Controller
{
    public function createProject (Request $request)
    {
        $data = $this->validateData($request);

        $id = $this->updateCreateProject($data);

        return response($id, 200)->header('Content-Type', 'text/plain');
    }

    public function getProject (Request $request)
    {
        $id = preg_replace('#[^0-9]#', '', $request->id);

        $project = Project::find($id);

        return response()->json($project);
    }

    public function getProjects ()
    {
        $projects = Project::where(['deleted', '!=', 0]);

        return response()->json($projects);
    }

    public function updateProject (Request $request)
    {
        $data = $this->validateData($request);

        $id = $this->updateCreateProject($data);

        return response($id, 200)->header('Content-Type', 'text/plain');
    }

    public function deleteProject (Request $request)
    {
        $id = preg_replace('#[^0-9]#', '', $request->id);

        $project = Project::find($id);

        if ($project === null) {
            return response('not_found', 200)->header('Content-Type', 'text/plain');
        }

        $this->updateCreateProject (['id' => $id, 'deleted' => 1]);

        return response('done', 200)->header('Content-Type', 'text/plain');
    }

    private function validateData ($data)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'numeric|min:1|max:255',
            'name' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:1',
            'status' => 'required|min:2|max:255',
        ]);

        if($validate->fails()){
            return response()->json($validate->errors());
        }

        return $data;
    }

    private function updateCreateProject ($data)
    {
        $project = Project::updateOrCreate(['id' => $data['id'], $data]);

        $id = Project::where([
            'updated_at' => $project->updated_at, 'status' => $project->status
          ])->pluck('id')->first();

        return $id;
    }
}
