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

            'live.noreply_email' => 'nullable|string|max:255',
            'live.noreply_password' => 'nullable|string|max:255',

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

            'noreply_email' => trim(request('live.noreply_email')),
            'noreply_password' => trim(request('live.noreply_password')),

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

    public function show(Project $project)
    {
        return view('projects.show', ['project' => $project]);
    }

    public function edit(Project $project)
    {
        $folder = Folder::where('name', Project::$SUB_FOLDER)->first();

        return view('projects.edit', [
            'project' => $project,
            'projectTypes' => ProjectType::orderBy('name')
                ->get(),
            'images' => Image::where('folder_id', $folder->id)
                ->orderBy('name')
                ->get(),
            'oc_default_credentials' => DefaultCredential::getOc(),
            'wp_default_credentials' => DefaultCredential::getWp()
        ]);
    }

    public function update(Request $request, Project $project)
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

            'live.noreply_email' => 'nullable|string|max:255',
            'live.noreply_password' => 'nullable|string|max:255',

            'live.lived_at' => 'nullable|string|max:255',
        ]);

        // Project
        $project->project_type_id = request('project_type_id');
        $project->image_id = request('image_id');
        $project->name = trim(request('name'));
        $project->project_executive = trim(request('project_executive'));
        $project->is_full_project = request('is_full_project') == 'yes' ? true : false;
        $project->notes = request('notes');
        $project->save();

        // Demo CPanel
        $project->demoCpanel->site_url = trim(request('demo.site_url'));
        $project->demoCpanel->admin_url = trim(request('demo.admin_url'));
        $project->demoCpanel->cpanel_url = trim(request('demo.cpanel_url'));
        $project->demoCpanel->design_url = trim(request('demo.design_url'));
        $project->demoCpanel->programming_brief_url = trim(request('demo.programming_brief_url'));

        $project->demoCpanel->cpanel_username = trim(request('demo.cpanel_username'));
        $project->demoCpanel->cpanel_password = trim(request('demo.cpanel_password'));

        $project->demoCpanel->db_username = trim(request('demo.db_username'));
        $project->demoCpanel->db_password = trim(request('demo.db_password'));
        $project->demoCpanel->db_name = trim(request('demo.db_name'));

        $project->demoCpanel->backend_username = trim(request('demo.backend_username'));
        $project->demoCpanel->backend_password = trim(request('demo.backend_password'));

        $project->demoCpanel->started_at = trim(request('demo.started_at'));
        $project->demoCpanel->ended_at = trim(request('demo.ended_at'));

        $project->demoCpanel->save();

        // Live CPanel
        $project->liveCpanel->site_url = trim(request('live.site_url'));
        $project->liveCpanel->admin_url = trim(request('live.admin_url'));
        $project->liveCpanel->cpanel_url = trim(request('live.cpanel_url'));

        $project->liveCpanel->cpanel_username = trim(request('live.cpanel_username'));
        $project->liveCpanel->cpanel_password = trim(request('live.cpanel_password'));

        $project->liveCpanel->db_username = trim(request('live.db_username'));
        $project->liveCpanel->db_password = trim(request('live.db_password'));
        $project->liveCpanel->db_name = trim(request('live.db_name'));

        $project->liveCpanel->admin_panel = trim(request('live.admin_panel'));
        $project->liveCpanel->backend_username = trim(request('live.backend_username'));
        $project->liveCpanel->backend_password = trim(request('live.backend_password'));

        $project->liveCpanel->noreply_email = trim(request('live.noreply_email'));
        $project->liveCpanel->noreply_password = trim(request('live.noreply_password'));

        $project->liveCpanel->lived_at = trim(request('live.lived_at'));
        $project->liveCpanel->save();

        Activity::create([
            'log' => 'Modified ' . $project->name . ' project.',
            'link' => route('projects.show', ['project' => $project]),
            'label' => 'View record'
        ]);

        return redirect(route('projects.show', ['project' => $project]))
            ->with('message', 'Project modified.');
    }

    public function destroy(Project $project)
    {
        $project_name = $project->name;
        $project->demoCpanel->delete();
        $project->liveCpanel->delete();
        $project->delete();

        Activity::create([
            'log' => 'Deleted ' . $project_name . ' project.'
        ]);

        return redirect(route('projects.index'))
            ->with('message', 'Project deleted.');
    }
}
