<?php 
namespace App\Repositories;

use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class BookRepo
{
    public function create($request)
    {
        try {
            $cover       = $request->file('cover');
            $cover_name  = Str::random(16).'.'.$cover->extension();
            $cover->storeAs('public/books', $cover_name);

        } catch (\Exception $e) {
            throw $e;
        }

        try {
           $book = Book::create([
                'author_id'      => $request->authorId,
                'title'          => strip_tags($request->title),
                'published_date' => strip_tags($request->publishedDate),
                'description'    => strip_tags($request->description),
                'cover'          => $cover_name
            ]);  
        } catch (QueryException $e) {
            throw $e;
        }

        return $book;
    }

    public function getAll()
    {
        return Book::get();
    }

    public function findById($id)
    {
        return Book::find($id);
    }

    public function update($id, $request)
    {   
        $cover_name = null;
        if($request->hasFile('cover')) :
            try {
                $cover       = $request->file('cover');
                $cover_name  = Str::random(16).'.'.$cover->extension();
                $cover->storeAs('public/books', $cover_name);
    
            } catch (\Exception $e) {
                throw $e;
            }
        endif;

        try {
            $book = Book::find($id);
            $book->title            = strip_tags($request->title);
            $book->author_id        = $request->authorId;
            $book->description      = strip_tags($request->description);
            $book->published_date   = $request->publishedDate;
            $book->cover            = $cover_name ?? $book->cover;
            $book->save();
        } catch (QueryException $e) {
            throw $e;
        }

        return $book;
    }

    public function delete($id)
    {
        return Book::where("id",$id)->delete();
    }
}