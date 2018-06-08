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

        $language->dataType->declare_string = $request->type_string;
        $language->dataType->declare_float = $request->type_float;
        $language->dataType->declare_boolean = $request->type_boolean;
        $language->dataType->declare_true = $request->type_true;
        $language->dataType->declare_false = $request->type_false;
        $language->dataType->save();

        $language->operators->equals_to = $request->op_equals;
        $language->operators->not_equal_to = $request->op_different;
        $language->operators->greater_than = $request->op_greater;
        $language->operators->greater_than_or_equals_to = $request->op_greater_equals;
        $language->operators->less_than = $request->op_less;
        $language->operators->less_than_or_equals_to = $request->op_less_equals;
        $language->operators->logical_and = $request->op_and;
        $language->operators->logical_or = $request->op_or;
        $language->operators->logical_not = $request->op_not;
        $language->operators->save();

        $language->controlFlowStatements->break_code = $request->control_flow_break;
        $language->controlFlowStatements->do_code = $request->control_flow_do;
        $language->controlFlowStatements->for_code = $request->control_flow_for;
        $language->controlFlowStatements->if_code = $request->control_flow_if;
        $language->controlFlowStatements->else_if = $request->control_flow_else_if;
        $language->controlFlowStatements->else = $request->control_flow_else;
        $language->controlFlowStatements->repeat_code = $request->control_flow_repeat;
        $language->controlFlowStatements->switch_code = $request->control_flow_switch;
        $language->controlFlowStatements->case = $request->control_flow_case;
        $language->controlFlowStatements->while_code = $request->control_flow_while;
        $language->controlFlowStatements->save();

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
