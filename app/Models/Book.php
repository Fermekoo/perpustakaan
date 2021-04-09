<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    
    protected $table    = 'books';
    protected $fillable = ['author_id','title','description','published_date','cover'];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
