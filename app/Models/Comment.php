<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'file',
        'topic_id',
        'user_id'
    ];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }
     public function user(){
        return $this->belongsTo(User::class);
    }
}
