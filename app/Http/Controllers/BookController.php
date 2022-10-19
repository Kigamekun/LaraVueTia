<?php

namespace App\Http\Controllers;

use App\Models\{Book,Category};
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = new BookCollection(BookResource::collection(Book::latest()->paginate(10)));
        $category = Category::all();
        return Inertia::render('Book/Index', ['books' => $books,'categories'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        if ($request->validated()) {
            if ($request->hasFile('thumb')) {
                $file = $request->file('thumb');
                $thumbname = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path() . '/thumb' . '/', $thumbname);
                Book::create([
                    'title'=>$request->title,
                    'penerbit'=>$request->penerbit,
                    'pengarang'=>$request->pengarang,
                    'category_id'=>$request->category_id,
                    'thumb'=>$thumbname,
                    ]);
            } else {
                Book::create([
                    'title'=>$request->title,
                    'penerbit'=>$request->penerbit,
                    'pengarang'=>$request->pengarang,
                    'category_id'=>$request->category_id,
                    ]);
            }
            return Redirect::route('books.index');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBookRequest $request, Book $book)
    {
        if ($request->validated()) {
            if ($request->hasFile('thumb')) {
                $file = $request->file('thumb');
                $thumbname = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path() . '/thumb' . '/', $thumbname);
                $book->update([
                    'title'=>$request->title,
                    'penerbit'=>$request->penerbit,
                    'pengarang'=>$request->pengarang,
                    'category_id'=>$request->category_id,
                    'thumb'=>$thumbname,
                ]);
            } else {
                $book->update([
                    'title'=>$request->title,
                    'penerbit'=>$request->penerbit,
                    'pengarang'=>$request->pengarang,
                    'category_id'=>$request->category_id,
                ]);
            }

            return Redirect::route('books.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return Redirect::route('books.index');
    }
}
