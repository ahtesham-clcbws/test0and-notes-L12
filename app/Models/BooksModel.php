<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BooksModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'books';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'sub_title',
        'sub_title_2',
        'author',
        'description',
        'age_from',
        'age_to',
        'pages',
        'language',
        'publisher',
        'publication_date',
        'isbn_10',
        'isbn_13',
        'cover_image',
        'gallery',
        'price',
        'hardcover_price',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'publication_date' => 'datetime',
        'gallery' => 'array',
        'price' => 'float',
        'hardcover_price' => 'float',
    ];


    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';
}
