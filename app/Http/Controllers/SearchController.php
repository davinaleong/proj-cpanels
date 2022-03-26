<?php

namespace App\Http\Controllers;

use App\Models\Cpanel;
use App\Models\OtherSettings;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function post(Request $request)
    {
        $request->validate([
            'term' => 'nullable|string'
        ]);

        $term = request('term');

        return redirect(route('search.results', ['term' => $term]));
    }

    public function results(Request $request)
    {
        $term = $request->query('term');
        //$lower = Str::lower($term);
        $searchResultsLimit = OtherSettings::getSearchResultsLimit();

        return view('search.results', [
            'term' => $term,
            'projects' => Project::whereRaw("LOWER(name) LIKE LOWER('%$term%')")
                ->take($searchResultsLimit)
                ->get(),
            'cpanels' => Cpanel::whereRaw("LOWER(name) LIKE LOWER('%$term%')")
                ->take($searchResultsLimit)
                ->get()
            // 'projects' => Project::where('name', 'like', "%$lower%")->take($searchResultsLimit)->get(),
            // 'cpanels' => Cpanel::where('name', 'like', "%$lower%")->take($searchResultsLimit)->get()
        ]);
    }
}
