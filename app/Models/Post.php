<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete

class Post extends Model
{
    use HasFactory, SoftDeletes;// add soft delete

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
