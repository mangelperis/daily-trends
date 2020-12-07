<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    /**
     * @var string
     */
    protected $table = 'feed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'image',
        'source',
        'publisher',
        'article_id',
        'created_at',
        'updated_at'
    ];

}
