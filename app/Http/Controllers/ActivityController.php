<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\OtherSettings;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $perPage = OtherSettings::getListPerPage();
        return view('activities.index', ['activities' => Activity::orderByDesc('created_at')->paginate($perPage)]);
    }
}
