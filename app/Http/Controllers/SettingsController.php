<?php

namespace App\Http\Controllers;

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
        return view('settings.other-settings.index');
    }

    public function sourceIndex()
    {
        return view('settings.sources.index', ['sources' => Source::all()]);
    }
}
