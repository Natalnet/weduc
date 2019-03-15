<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ObrSimuladaController extends Controller
{
    public function version($os)
    {
        switch ($os) {
            case 'windows':
                $version = 'v1.0-beta';
                break;
            case 'osx':
                $version = 'v1.0-beta';
                break;
            default:
                $version = null;
        }

        return response()->json([
            'version' => $version
        ]);
    }
}
