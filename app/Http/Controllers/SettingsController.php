<?php

namespace App\Http\Controllers;

use App\Models\OtherSettings;
use App\Models\Source;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

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

    public function sourceIndex()
    {
        return view('settings.sources.index', ['sources' => Source::all()]);
    }
}
