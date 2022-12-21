<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['title','description','created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $filter = $request->filter;
        $searchValue = $request->search;
        
            $query = Event::orderBy($columns[$column], $dir);
       
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('title', 'like', '%'.$searchValue.'%')
                ->orWhere('description', 'like', '%'.$searchValue.'%');
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
            'title' => 'string|required',
            'description' => 'string|required',
            ]);

        $book = Event::create([
            'title' => $request->title,
            'description' =>$request->description,
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
            'title' => 'string|required',
            'description' => 'string|required',
        ]);

        $book = Event::find($id);
        $book->title = $request->title;
        $book->description = $request->description;
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
        $book = Event::find($id);
        $book->delete();
        return response()->json($book, 200);
    }

    public function eventUpload(Request $request){
        $id = $request->id;
        $file = $request->file('image');

        $ran = Str::random(5);

        $date = Carbon::now()->toDateString();
        $file_ =  $date.'-'.$ran.'-'.$file->getClientOriginalName();
       
        $file->storeAs('event',$file_, 'public');
        $item = Event::find($id);

        $file_d = storage_path('/app/public/event/').$item->image;
        if(is_file($file_d))
            @unlink($file_d); 
        $item->image =  $file_;
        $item->save();
    }
}
