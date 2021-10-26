<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        return view('activities.index', ['activities' => Activity::limit(50)->get()]);
    }
}
