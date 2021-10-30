<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Folder;
use App\Models\OtherSettings;
use App\Models\ProjectType;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    #region Project Types
    public function projectTypeIndex()
    {
        return view('settings.project-types.index', ['projectTypes' => ProjectType::all()]);
    }

    public function projectTypeCreate()
    {
        return view('settings.project-types.create');
    }

    public function projectTypeStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $projectType = ProjectType::create([
            'name' => $request->input(['name'])
        ]);

        Activity::create([
            'log' => 'Created ' . $projectType->name . ' project type.',
            'link' => route('settings.project-types.edit', ['projectType' => $projectType]),
            'label' => 'View record'
        ]);

        return redirect(route('settings.project-types.index'))
            ->with('message', 'Project type created.');
    }

    public function projectTypeEdit(ProjectType $projectType)
    {
        return view('settings.project-types.edit', ['projectType' => $projectType]);
    }

    public function projectTypeUpdate(Request $request, ProjectType $projectType)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $projectType->name = $request->input('name');
        $projectType->save();

        Activity::create([
            'log' => 'Modified ' . $projectType->name . ' project type.',
            'link' => route('settings.project-types.index'),
            'label' => 'View record'
        ]);

        return redirect(route('settings.project-types.index'))
            ->with('message', 'Project type modified.');
    }

    public function projectTypeDestroy(ProjectType $projectType)
    {
        $projectName = $projectType->name;

        $projectType->delete();

        Activity::create([
            'log' => 'Deleted ' . $projectName . ' project type.'
        ]);

        return redirect(route('settings.project-types.index'))
            ->with('message', 'Project type deleted.');
    }
    #endregion

    #region Folders
    public function folderIndex()
    {
        return view('settings.folders.index', ['folders' => Folder::all()]);
    }

    public function folderCreate()
    {
        return view('settings.folders.create');
    }

    public function folderStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $folder = Folder::create([
            'name' => Str::slug($request->input(['name']))
        ]);

        if (env('APP_ENV') !== 'testing') {
            Storage::makeDirectory('images/' . $folder->name . '/');
        }

        Activity::create([
            'log' => 'Created ' . $folder->name . ' folder.',
            'link' => route('settings.folders.edit', ['folder' => $folder]),
            'label' => 'View record'
        ]);

        return redirect(route('settings.folders.index'))
            ->with('message', 'Folder created.');
    }

    public function folderEdit(Folder $folder)
    {
        return view('settings.folders.edit', ['folder' => $folder]);
    }

    public function folderUpdate(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $folder->name = Str::slug($request->input('name'));
        $folder->save();

        if (env('APP_ENV') !== 'testing') {
            Storage::makeDirectory('images/' . $folder->name . '/');
        }

        Activity::create([
            'log' => 'Modified ' . $folder->name . ' folder.',
            'link' => route('settings.folders.index'),
            'label' => 'View record'
        ]);

        return redirect(route('settings.folders.index'))
            ->with('message', 'Folder modified.');
    }

    public function folderDestroy(Folder $folder)
    {
        $folderName = $folder->name;

        $folder->delete();

        Activity::create([
            'log' => 'Deleted ' . $folderName . ' folder.'
        ]);

        return redirect(route('settings.folders.index'))
            ->with('message', 'Folder deleted.');
    }
    #endregion

    #region Images
    public function imageIndex()
    {
        $perPage = OtherSettings::getCardPerPage();
        return view('settings.images.index', ['images' => Image::orderByDesc('created_at')->paginate($perPage)]);
    }
    #endregion

    #region Other Settings
    public function otherSettingsIndex()
    {
        return view('settings.other-settings.index', ['otherSettings' => OtherSettings::all()]);
    }

    public function otherSettingsEdit()
    {
        $otherSettings = OtherSettings::all();

        return view('settings.other-settings.edit',
            [
                'otherSettings' => $otherSettings,
                'otherSettingsCount' => $otherSettings->count()
            ]);
    }

    public function otherSettingsUpdate(Request $request) {
        $request->validate([
            'otherSettings' => 'required|array',
            'otherSettings.*.key' => 'required|string',
            'otherSettings.*.value' => 'required|string'
        ]);

        $count = count($request->input('otherSettings'));

        if ($count > 0) {
            OtherSettings::truncate();
            for ($i = 0; $i < $count; $i++) {
                OtherSettings::create([
                    'key' => trim($request->input('otherSettings.' . $i . '.key')),
                    'value' => trim($request->input('otherSettings.' . $i . '.value'))
                ]);
            }
        }

        Activity::create([
            'log' => 'Modified other settings.',
            'link' => route('settings.other-settings.index'),
            'label' => 'View records'
        ]);

        return redirect(route('settings.other-settings.index'))
            ->with('message', 'Other Settings updated.');
    }
    #endregion
}
