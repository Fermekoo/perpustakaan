<?php

namespace App\Http\Controllers;

use App\Repositories\AuthorRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AuthorController extends Controller
{
    protected $author;
    public function __construct(AuthorRepo $author)
    {   
        $this->author = $author;
    }

    public function index()
    {
        return view('author.index');
    }

    public function dataAuthor()
    {
        $authors = $this->author->getAll();
        $data = DataTables::of($authors)
                ->addColumn('total_book', function($row){
                    return $row->books->count();
                })
                ->make(true);

        return $data;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->author->create($request);
        } catch (\Exception $e) {
            return redirect()->route('author.index')->with('error', $e->getMessage());
        }

        return redirect()->route('author.index')->with('success',' Author created successfully');
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->author->update($id, $request);
        } catch (\Exception $e) {
            return redirect()->route('author.index')->with('error', $e->getMessage());
        }

        return redirect()->route('author.index')->with('success',' Author updated successfully');
    }

    public function delete($id, Request $request)
    {
        try {
            $this->author->delete($id);
        } catch (\Exception $e) {
            return redirect()->route('author.index')->with('error', $e->getMessage());
        }

        return redirect()->route('author.index')->with('success',' Author deleted successfully');
    }
}
