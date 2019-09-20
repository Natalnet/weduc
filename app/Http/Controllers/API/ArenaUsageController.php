<?php

namespace App\Http\Controllers\API;

use App\Arena;
use App\ArenaUsage;
use App\Http\Resources\ArenaUsage as ArenaUsageResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArenaUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function arenaIndex(Arena $arena)
    {
        return ArenaUsageResource::collection($arena->usages);
    }

    /**
     * Display the average points for an arena.
     *
     * @param  \App\Arena  $arena
     * @return \Illuminate\Http\Response
     */
    public function average(Arena $arena)
    {
        $average = (int) $arena->usages()->average('points');

        return response([
            'data' => [
                'average' => $average
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Arena $arena)
    {
        $request->validate([
            'points' => 'integer|min:0'
        ]);

        $arenaUsage = $arena->usages()->create(array_merge(
            ['user_id' => auth()->id()],
            $request->only('points')
        ));

        return (new ArenaUsageResource($arenaUsage))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ArenaUsage  $arenaUsage
     * @return \Illuminate\Http\Response
     */
    public function show(ArenaUsage $arenaUsage)
    {
        //
    }
}
