<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\OtherSettings;
use App\Models\ProjectType;
use App\Models\Source;
use Illuminate\Http\Request;

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
            'log' => 'New project type created.',
            'link' => route('settings.project-types.edit', ['projectType' => $projectType]),
            'label' => 'View record'
        ]);

        return redirect(route('settings.project-types.edit', ['projectType' => $projectType]))
            ->with('message', 'New project type created.');
    }

    public function projectTypeEdit(ProjectType $projectType)
    {
        return view('settings.project-types.edit', ['projectType' => $projectType]);
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
