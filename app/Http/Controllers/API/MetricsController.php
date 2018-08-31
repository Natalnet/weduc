<?php

namespace App\Http\Controllers\API;

use App\Metrics\CompilationErrors;
use App\Metrics\CompilationsPerDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MetricsController extends Controller
{
    /**
     * Get the specified metric's value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function compilationErrors(Request $request)
    {
        return response()->json([
            'value' => (new CompilationErrors)->resolve($request),
        ]);
    }

    /**
     * Get the specified metric's value.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function compilationsPerDay(Request $request)
    {
        return response()->json([
            'value' => (new CompilationsPerDay)->resolve($request),
        ]);
    }
}
