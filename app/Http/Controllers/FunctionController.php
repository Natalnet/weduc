<?php

namespace App\Http\Controllers;

use App\ProgrammingLanguage;
use App\ReducFunction;
use Illuminate\Http\Request;

class FunctionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of functions by language.
     *
     * @return \Illuminate\Http\Response
     */
    public function byLanguage(ProgrammingLanguage $language)
    {
        $functions = $language->functions()->get();
        return view('functions.by-language')->with(['language' => $language, 'functions' => $functions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProgrammingLanguage $language)
    {
        return view('functions.create', ['language' => $language]);
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
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'return_type' => 'required',
            'parameters' => 'required',
            'code' => 'required'
        ]);

        $function = ReducFunction::create($request->all());
        return $this->byLanguage($function->language);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ReducFunction $function)
    {
        return view('functions.edit')->with(['function' => $function]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'type' => 'required',
            'return_type' => 'required',
            'parameters' => 'required',
            'code' => 'required'
        ]);

        $function = ReducFunction::find($id);
        $function->fill($request->all())->save();
        return $this->byLanguage($function->language);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
