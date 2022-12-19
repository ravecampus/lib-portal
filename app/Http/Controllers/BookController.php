<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['title','author', 'copyright', 'publisher', 'isbn', 'created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $filter = $request->filter;
        $searchValue = $request->search;
        
            $query = Book::orderBy($columns[$column], $dir);
       
            
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('title', 'like', '%'.$searchValue.'%')
                ->orWhere('author', 'like', '%'.$searchValue.'%')
                ->orWhere('copyright', 'like', '%'.$searchValue.'%')
                ->orWhere('publisher', 'like', '%'.$searchValue.'%')
                ->orWhere('isbn', 'like', '%'.$searchValue.'%');
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
            'author' => 'string|required',
            'copyright' => 'string|required',
            'publisher' => 'string|required',
            'isbn' => 'string|required',
            ]);

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'copyright' => $request->copyright,
            'publisher' => $request->publisher,
            'isbn' => $request->isbn,
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
            'author' => 'string|required',
            'copyright' => 'string|required',
            'publisher' => 'string|required',
            'isbn' => 'string|required',
            ]);

        $book = Book::find($id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->copyright = $request->copyright;
        $book->publisher = $request->publisher;
        $book->isbn = $request->isbn;
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
        $book = Book::find($id);
        $book->delete();
        return response()->json($book, 200);
    }
}
