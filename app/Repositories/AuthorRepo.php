<?php 
namespace App\Repositories;

use App\Models\Author;
use Illuminate\Database\QueryException;

class AuthorRepo
{
    public function create($request)
    {
        try {
            $author = Author::create([
                'name'  => strip_tags($request->name)
            ]);
        } catch (QueryException $e) {
            throw $e;
        }

        return $author;
    }

    public function getAll()
    {
        return Author::get();
    }

    public function findById($id)
    {
        return Author::find($id);
    }

    public function update($id, $request)
    {
        $author = Author::find($id);

        try {

            $author->name = strip_tags($request->name);
            $author->save();

        } catch (QueryException $e) {
            throw $e;
        }

        return $author;
    }

    public function delete($id)
    {
        return Author::where('id',$id)->delete();
    }
}