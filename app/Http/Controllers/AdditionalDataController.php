<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdditionalDataGroup;
use App\Models\OtherSettings;

class AdditionalDataController extends Controller
{
    public function index()
    {
        $perPage = OtherSettings::getListPerPage();
        return view('additionalData.index', [
            'additionalDataGroups' => AdditionalDataGroup::orderByDesc('created_at')->paginate($perPage)
        ]);
    }

    public function create()
    {
        return view('additionalData.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function edit(AdditionalDataGroup $additionalDataGroup)
    {
        //
    }

    public function update(Request $request, AdditionalDataGroup $additionalDataGroup)
    {
        //
    }

    public function destroy(AdditionalDataGroup $additionalDataGroup)
    {
        //
    }
}
