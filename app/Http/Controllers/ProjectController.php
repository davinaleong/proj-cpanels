<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
        //
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
