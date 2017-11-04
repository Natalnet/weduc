<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProgrammingLanguage;
use App\ProgrammingLanguage;
use Illuminate\Http\Request;

class ProgrammingLanguageController extends Controller
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
        $languages = ProgrammingLanguage::all();
        return view('languages.list')->with(['languages' => $languages]);
    }

    /**
     * Display a listing of the languages owned by the current user.
     *
     * @return \Illuminate\Http\Response
     */
    public function byUser()
    {
        $languages = auth()->user()->languages()->get();
        return view('languages.list')->with(['languages' => $languages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('languages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $language = ProgrammingLanguage::first();
        $language->addMedia($request->file('sending_files'))->toMediaCollection('send');
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
     * @param  ProgrammingLanguage  $language
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgrammingLanguage $language)
    {
        return view('languages.edit')->with(['language' => $language]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProgrammingLanguage $request
     * @param  ProgrammingLanguage  $language
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgrammingLanguage $request, ProgrammingLanguage $language)
    {
        $langauge_fields = $request->only([
            'call_function',
            'compile_code',
            'compiler_file',
            'description',
            'extension',
            'header',
            'footnote',
            'main_function',
            'name',
            'other_functions',
            'robot',
            'send_code',
            'sent_extension'
        ]);

        $language->fill($langauge_fields)->save();

        return redirect()->route('languages.by-user');
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
