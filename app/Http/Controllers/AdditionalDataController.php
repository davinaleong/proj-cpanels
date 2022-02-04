<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\AdditionalData;
use Illuminate\Http\Request;
use App\Models\AdditionalDataGroup;
use App\Models\OtherSettings;

class AdditionalDataController extends Controller
{
    public function index()
    {
        $perPage = OtherSettings::getListPerPage();
        return view('additionalDataGroup.index', [
            'additionalDataGroups' => AdditionalDataGroup::orderByDesc('created_at')->paginate($perPage)
        ]);
    }

    public function create()
    {
        return view('additionalDataGroup.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'keys' => 'required|array|min:1',
            'keys.*' => 'required|string',
            'values' => 'required|array|min:1',
            'values.*' => 'required|string'
        ]);

        $additionalDataGroup = AdditionalDataGroup::create([
            'name' => request('name')
        ]);

        $additionalDataCount = count(request('keys'));
        for ($i = 0; $i < $additionalDataCount; $i++) {
            AdditionalData::create([
                'additional_data_group_id' => $additionalDataGroup->id,
                'key' => request("keys.$i"),
                'value' => request("values.$i")
            ]);
        }

        Activity::create([
            'log' => 'Created ' . $additionalDataGroup->name . ' additional data group.',
            'link' => route('additionalDataGroup.index'),
            'label' => 'View record'
        ]);

        return redirect(route('additionalDataGroup.index'))
            ->with('message', 'Additional Data created.');
    }

    public function edit(AdditionalDataGroup $additionalDataGroup)
    {
        return view('additionalDataGroup.edit', [
            'additionalDataGroup' => $additionalDataGroup,
            'additionalDataRow' => $additionalDataGroup->additionalData->count() - 1
        ]);
    }

    public function update(Request $request, AdditionalDataGroup $additionalDataGroup)
    {
        $request->validate([
            'name' => 'required|string',
            'keys' => 'required|array|min:1',
            'keys.*' => 'required|string',
            'values' => 'required|array|min:1',
            'values.*' => 'required|string'
        ]);

        $additionalDataGroup->name = request('name');
        $additionalDataGroup->save();

        AdditionalData::where('additional_data_group_id', $additionalDataGroup->id)->delete();
        $additionalDataCount = count(request('keys'));
        for ($i = 0; $i < $additionalDataCount; $i++) {
            AdditionalData::create([
                'additional_data_group_id' => $additionalDataGroup->id,
                'key' => request("keys.$i"),
                'value' => request("values.$i")
            ]);
        }

        Activity::create([
            'log' => 'Updated ' . $additionalDataGroup->name . ' additional data group.',
            'link' => route('additionalDataGroup.index'),
            'label' => 'View record'
        ]);

        return redirect(route('additionalDataGroup.index'))
            ->with('message', 'Additional Data updated.');
    }

    public function destroy(AdditionalDataGroup $additionalDataGroup)
    {
        AdditionalData::where('additional_data_group_id', $additionalDataGroup->id)->delete();
        $additionalDataGroup->delete();

        Activity::create([
            'log' => 'Deleted ' . $additionalDataGroup->name . ' additional data.'
        ]);

        return redirect(route('additionalDataGroup.index'))
            ->with('message', 'Additional Data deleted.');
    }
}
