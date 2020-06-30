<?php

namespace App\Http\Controllers\API;

use App\SBoticsRelease;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObrSimuladaController extends Controller
{
    public function version($os)
    {
        $release = SBoticsRelease::where('os', $os)->orderByDesc('released_at')->latest()->firstOrFail();

        return response()->json([
            'version' => $release->version,
            'release_notes' => $release->release_notes
        ]);
    }
}
