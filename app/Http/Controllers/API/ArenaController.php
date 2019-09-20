<?php

namespace App\Http\Controllers\API;

use App\Arena;
use App\Http\Resources\Arena as ArenaResource;
use App\Http\Resources\ArenaCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArenaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Arena::class, 'arena');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ArenaCollection(Arena::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $arena = auth()->user()->arenas()->create(
            $request->only('code')
        );

        return (new ArenaResource($arena))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Arena  $arena
     * @return \Illuminate\Http\Response
     */
    public function show(Arena $arena)
    {
        return new ArenaResource($arena);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Arena  $arena
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arena $arena)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $arena->code = $request->code;
        $arena->save();

        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Arena  $arena
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arena $arena)
    {
        $arena->delete();

        return response(null, 204);
    }
}
