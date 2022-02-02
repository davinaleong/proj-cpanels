<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\DefaultCredential;
use App\Models\Folder;
use App\Models\ProjectType;
use App\Models\Image;
use App\Models\OtherSettings;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $perPage = OtherSettings::getListPerPage();
        return view('projects.index', ['projects' => Project::orderByDesc('created_at')->paginate($perPage)]);
    }

    public function create()
    {
        $folder = Folder::where('name', Project::$SUB_FOLDER)->first();

        return view('projects.create', [
            'projectTypes' => ProjectType::orderBy('name')
                ->get(),
            'images' => Image::where('folder_id', $folder->id)
                ->orderBy('name')
                ->get(),
            'oc_default_credentials' => DefaultCredential::getOc(),
            'wp_default_credentials' => DefaultCredential::getWp()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_type_id' => 'required|integer|exists:project_types,id',
            'image_id' => 'required|integer|exists:images,id',
            'name' => 'required|string|max:255',
            'project_executive' => 'nullable|string|max:255',
            'is_full_project' => 'nullable|in:yes',
            'notes' => 'nullable|string',

            // Demo CPanel
            'demo.site_url' => 'nullable|string|max:255',
            'demo.admin_url' => 'nullable|string|max:255',
            'demo.cpanel_url' => 'nullable|string|max:255',
            'demo.design_url' => 'nullable|string|max:255',
            'demo.programming_brief_url' => 'nullable|string|max:255',

            'demo.cpanel_username' => 'nullable|string|max:255',
            'demo.cpanel_password' => 'nullable|string|max:255',

            'demo.db_username' => 'nullable|string|max:255',
            'demo.db_password' => 'nullable|string|max:255',
            'demo.db_name' => 'nullable|string|max:255',

            'demo.backend_username' => 'nullable|string|max:255',
            'demo.backend_password' => 'nullable|string|max:255',

            'demo.started_at' => 'nullable|string|max:255',
            'demo.ended_at' => 'nullable|string|max:255',
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
