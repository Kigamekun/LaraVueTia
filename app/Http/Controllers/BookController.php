<?php

namespace App\Http\Controllers;

use App\Models\{Book,Category};
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::latest()->paginate(10);
        $books->getCollection()->transform(function ($value) {
            $datas = [];
            $datas['id'] = $value->id;
            $datas['title'] = $value->title;
            $datas['pengarang'] = $value->pengarang;
            $datas['penerbit'] = $value->penerbit;
            $datas['category'] = Category::where('id', $value->category_id)->first()->name;
            $datas['category_id'] = $value->category_id;

            if (!is_null($value->thumb)) {
                $datas['thumb'] = env('APP_URL').'/thumb/'.$value->thumb;
            } else {
                $datas['thumb'] = null;
            }
            return $datas;
        });
        $category = Category::all();
        return Inertia::render('Book/Index', ['books' => $books,'categories'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {

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
