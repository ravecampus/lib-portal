<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linkage;
use Carbon\Carbon;

class LinkageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['name','position','school','address','created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $filter = $request->filter;
        $searchValue = $request->search;
        
        $query = Linkage::orderBy($columns[$column], $dir);
       
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('name', 'like', '%'.$searchValue.'%')
                ->orWhere('position', 'like', '%'.$searchValue.'%')
                ->orWhere('school', 'like', '%'.$searchValue.'%')
                ->orWhere('address', 'like', '%'.$searchValue.'%');
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
            'name' => 'string|required',
            'position' => 'string|required',
            //'school' => 'string|required',
            'address' => 'string|required',
            ]);

        $book = Linkage::create([
            'name' => $request->name,
            'position' => $request->position,
            'school' => $request->school,
            'address' => $request->address,
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
            'name' => 'string|required',
            'position' => 'string|required',
            //'school' => 'string|required',
            'address' => 'string|required',
        ]);

        $book = Linkage::find($id);
        $book->name = $request->name;
        $book->position = $request->position;
        $book->school = $request->school;
        $book->address = $request->address;
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
        $book = Linkage::find($id);
        $book->delete();
        return response()->json($book, 200);
    }
}
