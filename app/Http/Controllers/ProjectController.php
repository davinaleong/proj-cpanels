<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\DefaultCredential;
use App\Models\Folder;
use App\Models\ProjectType;
use App\Models\Image;
use App\Models\OtherSettings;
use App\Models\Activity;
use App\Models\DemoCpanel;
use App\Models\LiveCpanel;
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

            // Live CPanel
            'live.site_url' => 'nullable|string|max:255',
            'live.admin_url' => 'nullable|string|max:255',
            'live.cpanel_url' => 'nullable|string|max:255',

            'live.cpanel_username' => 'nullable|string|max:255',
            'live.cpanel_password' => 'nullable|string|max:255',

            'live.db_username' => 'nullable|string|max:255',
            'live.db_password' => 'nullable|string|max:255',
            'live.db_name' => 'nullable|string|max:255',

            'live.admin_panel' => 'nullable|string|max:255',
            'live.backend_username' => 'nullable|string|max:255',
            'live.backend_password' => 'nullable|string|max:255',

            'live.lived_at' => 'nullable|string|max:255',
        ]);

        $project = Project::create([
            'project_type_id' => request('project_type_id'),
            'image_id' => request('image_id'),
            'name' => trim(request('name')),
            'project_executive' => trim(request('project_executive')),
            'is_full_project' => request('is_full_project') == 'yes' ? true : false,
            'notes' => request('notes'),
        ]);

        DemoCpanel::create([
            'project_id' => $project->id,

            'site_url' => trim(request('demo.site_url')),
            'admin_url' => trim(request('demo.admin_url')),
            'cpanel_url' => trim(request('demo.cpanel_url')),
            'design_url' => trim(request('demo.design_url')),
            'programming_brief_url' => trim(request('demo.programming_brief_url')),

            'cpanel_username' => trim(request('demo.cpanel_username')),
            'cpanel_password' => trim(request('demo.cpanel_password')),

            'db_username' => trim(request('demo.db_username')),
            'db_password' => trim(request('demo.db_password')),
            'db_name' => trim(request('demo.db_name')),

            'backend_username' => trim(request('demo.backend_username')),
            'backend_password' => trim(request('demo.backend_password')),

            'started_at' => trim(request('demo.started_at')),
            'ended_at' => trim(request('demo.ended_at'))
        ]);

        LiveCpanel::create([
            'project_id' => $project->id,

            'site_url' => trim(request('live.site_url')),
            'admin_url' => trim(request('live.admin_url')),
            'cpanel_url' => trim(request('live.cpanel_url')),

            'cpanel_username' => trim(request('live.cpanel_username')),
            'cpanel_password' => trim(request('live.cpanel_password')),

            'db_username' => trim(request('live.db_username')),
            'db_password' => trim(request('live.db_password')),
            'db_name' => trim(request('live.db_name')),

            'admin_panel' => trim(request('live.admin_panel')),
            'backend_username' => trim(request('live.backend_username')),
            'backend_password' => trim(request('live.backend_password')),

            'lived_at' => trim(request('live.lived_at'))
        ]);

        Activity::create([
            'log' => 'Created ' . $project->name . ' project.',
            'link' => route('projects.show', ['project' => $project]),
            'label' => 'View record'
        ]);

        return redirect(route('projects.show', ['project' => $project]))
            ->with('message', 'Project created.');
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
