<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Cpanel;
use App\Models\DefaultCredential;
use App\Models\Folder;
use App\Models\ProjectType;
use App\Models\Image;
use App\Models\OtherSettings;

class CpanelController extends Controller
{
    public function index()
    {
        $perPage = OtherSettings::getListPerPage();
        return view('cpanels.index', ['cpanels' => Cpanel::orderByDesc('created_at')->paginate($perPage)]);
    }

    public function create()
    {
        $folder = Folder::where('name', Cpanel::$SUB_FOLDER)->first();

        return view('cpanels.create', [
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
            'site_url' => 'nullable|string',
            'admin_url' => 'nullable|string',
            'cpanel_url' => 'nullable|string',
            'cpanel_username' => 'nullable|string',
            'cpanel_password' => 'nullable|string',
            'backend_username' => 'nullable|string',
            'backend_password' => 'nullable|string'
        ]);

        $cpanel = Cpanel::create([
            'project_type_id' => request('project_type_id'),
            'image_id' => request('image_id'),
            'name' => trim(request('name')),
            'site_url' => trim(request('site_url')),
            'admin_url' => trim(request('admin_url')),
            'cpanel_url' => trim(request('cpanel_url')),
            'cpanel_username' => trim(request('cpanel_username')),
            'cpanel_password' => request('cpanel_password'),
            'backend_username' => trim(request('backend_username')),
            'backend_password' => request('backend_password')
        ]);

        Activity::create([
            'log' => 'Created ' . $cpanel->name . ' cpanel.',
            'link' => route('cpanels.show', ['cpanel' => $cpanel]),
            'label' => 'View record'
        ]);

        return redirect(route('cpanels.show', ['cpanel' => $cpanel]))
            ->with('message', 'CPanel created.');
    }

    public function show(Cpanel $cpanel)
    {
        return view('cpanels.show', ['cpanel' => $cpanel]);
    }

    public function edit(Cpanel $cpanel)
    {
        $folder = Folder::where('name', Cpanel::$SUB_FOLDER)->first();

        return view('cpanels.edit', [
            'cpanel' => $cpanel,
            'projectTypes' => ProjectType::orderBy('name')
                ->get(),
            'images' => Image::where('folder_id', $folder->id)
                ->orderBy('name')
                ->get(),
            'oc_default_credentials' => DefaultCredential::getOc(),
            'wp_default_credentials' => DefaultCredential::getWp()
        ]);
    }

    public function update(Request $request, Cpanel $cpanel)
    {
        //
    }

    public function destroy(Cpanel $cpanel)
    {
        //
    }
}
