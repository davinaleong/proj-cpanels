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

        if (env('APP_ENV') !== 'testing') {
            Storage::makeDirectory(OtherSettings::getImagesFolder() . '/' . $request->input('name') . '/');
        }
        $folder = Folder::create([
            'name' => Str::slug($request->input('name'))
        ]);

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

        if (env('APP_ENV') !== 'testing') {
            Storage::deleteDirectory(OtherSettings::getImagesFolder() . '/' . $folder->name . '/');
        }
        $folder->name = Str::slug($request->input('name'));

        if (env('APP_ENV') !== 'testing') {
            Storage::makeDirectory(OtherSettings::getImagesFolder() . '/' . $folder->name . '/');
        }

        $folder->save();

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

        if (env('APP_ENV') !== 'testing') {
            Storage::deleteDirectory(OtherSettings::getImagesFolder() . '/' . $folderName . '/');
        }
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

    public function imageCreate()
    {
        return view('settings.images.create', ['folders' => Folder::all()]);
    }

    public function imageStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'folder_id' => 'required|integer|exists:folders,id',
            'file' => 'required|file|mimes:jpg,bmp,png,gif|max:5120'
        ]);

        if ($request->file()) {
            $folder = Folder::find($request->input('folder_id'));
            $filename = now()->format('YmdHis') . '-' . urlencode(Str::snake($request->file->getClientOriginalName()));
            $request->file('file')->storeAs(OtherSettings::getImagesFolder() . '/' . $folder->name . '/', $filename, OtherSettings::getFilesystemDriver());

            $image = Image::create([
                'name' => $request->input('name'),
                'folder_id' => $request->input('folder_id'),
                'filename' => $filename
            ]);

            Activity::create([
                'log' => 'Created ' . $image->name . ' image.',
                'link' => route('settings.images.edit', ['image' => $image]),
                'label' => 'View record'
            ]);
        }

        return redirect(route('settings.images.index'))
            ->with('message', 'Image created.');
    }

    public function imageEdit(Request $request, Image $image)
    {
        return view('settings.images.edit', ['image' => $image]);
    }

    public function imageUpdate(Request $request, Image $image)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpg,bmp,png,gif|max:5120'
        ]);

        $image->name = $request->input('name');

        if ($request->file()) {
            $folder = OtherSettings::getImagesFolder() . '/' . $image->getFolderName();
            Storage::disk(OtherSettings::getFilesystemDriver())->delete($folder . $image->filename);
            $filename = now()->format('YmdHis') . '-' . urlencode(Str::snake($request->file->getClientOriginalName()));
            $request->file('file')->storeAs($folder, $filename, OtherSettings::getFilesystemDriver());

            $image->filename = $filename;
        }

        $image->save();

        Activity::create([
            'log' => 'Modified ' . $image->name . ' image.',
            'link' => route('settings.images.edit', ['image' => $image]),
            'label' => 'View record'
        ]);

        return redirect(route('settings.images.index'))
            ->with('message', 'Image modified.');
    }

    public function imageDestroy(Image $image)
    {
        Storage::disk(OtherSettings::getFilesystemDriver())->delete(OtherSettings::getImagesFolder() . '/' . $image->getFolderName() . $image->filename);

        $imageName = $image->name;
        $image->delete();

        Activity::create([
            'log' => 'Deleted ' . $imageName . ' image.'
        ]);

        return redirect(route('settings.images.index'))
            ->with('message', 'Image deleted.');
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
