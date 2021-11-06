<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cpanel;
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
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Cpanel $cpanel)
    {
        //
    }

    public function edit(Cpanel $cpanel)
    {
        //
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
