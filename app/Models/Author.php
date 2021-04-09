<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $table        = 'author';
    protected $fillable     = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }
}
