<?php

namespace App\Http\Controllers;

use App\SBoticsRelease;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SBoticsReleaseController extends Controller
{
    public function latest()
    {
        $windowsRelease = SBoticsRelease::where('os', 'windows')->orderByDesc('released_at')->latest()->first();
        $osxRelease = SBoticsRelease::where('os', 'osx')->orderByDesc('released_at')->latest()->first();
        $linuxRelease = SBoticsRelease::where('os', 'linux')->orderByDesc('released_at')->latest()->first();

        $releases = array_filter([
            'Windows' => $windowsRelease,
            'OSx' => $osxRelease,
            'Linux' => $linuxRelease,
        ]);

        return view('s_botics.latest_releases', compact('releases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'os' => 'required|max:15',
            'version' => 'required|max:20',
            'released_at' => 'date_format:d/m/Y'
        ]);

        $release = new SBoticsRelease();
        $release->fill($request->only('os', 'version', 'release_notes'));
        $release->released_at = Carbon::createFromFormat('d/m/Y', $request->released_at);
        $release->saveOrFail();

        return redirect()->back();
    }
}
