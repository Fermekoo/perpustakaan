<?php

namespace App\Http\Controllers;

use App\Repositories\AuthorRepo;
use App\Repositories\BookRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    protected $book;
    protected $author;
    public function __construct(BookRepo $book, AuthorRepo $author)
    {
        $this->book     = $book;
        $this->author   = $author;
    }

    public function index()
    {
        return view('book.index');
    }

    public function dataBook()
    {
        $books = $this->book->getAll();
        $data  = DataTables::of($books)
                ->addColumn('author', function($row){
                    return $row->author->name;
                }) 
                ->addColumn('detail', function($row){
                    return route('book.detail',$row->id);
                })
                ->make(true);
        return $data;
    }

    public function create()
    {
        $authors = $this->author->getAll();
        return view('book.create', compact('authors'));
    }

    public function detail($id)
    {   $book = $this->book->findById($id);
        if(!$book) return redirect()->route('book.index')->with('error', 'Book not found');
        $authors = $this->author->getAll();
        return view('book.detail', compact('book','authors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'authorId'      => 'required|exists:author,id',
            'title'         => 'required',
            'publishedDate' => 'required|date_format:Y-m-d',
            'description'   => 'required',
            'cover'         => 'required|image|mimes:jpg,png,jpeg'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->book->create($request);
        } catch (\Exception $e) {
            return redirect()->route('book.index')->with('error', $e->getMessage());
        }

        return redirect()->route('book.index')->with('success',' Book created successfully');

    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'authorId'      => 'required|exists:author,id',
            'title'         => 'required',
            'publishedDate' => 'required|date_format:Y-m-d',
            'description'   => 'required',
            'cover'         => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        if($validator->fails()){
            return redirect()->back()->withInput($request->all())->with('error',$validator->getMessageBag()->first());
        }

        try {
            $this->book->update($id, $request);
        } catch (\Exception $e) {
            return redirect()->route('book.index')->with('error', $e->getMessage());
        }

        return redirect()->route('book.index')->with('success',' Book updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->book->delete($id);
        } catch (\Exception $e) {
            return redirect()->route('book.index')->with('error', $e->getMessage());
        }

        return redirect()->route('book.index')->with('success',' Book deleted successfully');
    }
}
