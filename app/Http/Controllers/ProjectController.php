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
        //
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
