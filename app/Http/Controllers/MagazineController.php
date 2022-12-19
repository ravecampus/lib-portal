<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magazine;
use Carbon\Carbon;

class MagazineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['magazine_title','date_issued','created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $filter = $request->filter;
        $searchValue = $request->search;
        
            $query = Magazine::orderBy($columns[$column], $dir);
       
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('magazine_title', 'like', '%'.$searchValue.'%');
            });
        }
       
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
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
        $request->validate([
            'magazine_title' => 'string|required',
            'date_issued' => 'string|required',
            ]);

        $book = Magazine::create([
            'magazine_title' => $request->magazine_title,
            'date_issued' =>Carbon::parse($request->date_issued)->format('Y-m-d'),
        ]);

        return response()->json($book, 200);
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
        $request->validate([
            'magazine_title' => 'string|required',
            'date_issued' => 'string|required',
        ]);

        $book = Magazine::find($id);
        $book->magazine_title = $request->magazine_title;
        $book->date_issued = Carbon::parse($request->date_issued)->format('Y-m-d');
        $book->save();

        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Magazine::find($id);
        $book->delete();
        return response()->json($book, 200);
    }
}
