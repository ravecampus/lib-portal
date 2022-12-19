<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LibProfile;

class LibProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prof = LibProfile::where("id", 1)->first();
        return response()->json($prof, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $libprof = LibProfile::create([
            'school_history' => $request->school_history,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'rules_regulation' => $request->rules_regulation,

        ]);

        return response()->json($libprof, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $libprof = LibProfile::find($id);
        return response()->json($libprof, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $libprof = LibProfile::find($id);
        $libprof->school_history = $request->school_history;
        $libprof->mission = $request->mission;
        $libprof->vision = $request->vision;
        $libprof->rules_regulation = $request->rules_regulation;
        $libprof->save();

        return response()->json($libprof, 200);
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
