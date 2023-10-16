<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['feedback_id', 'user_id', 'comment'];
    protected $casts = [
        'created_at' => 'datetime:h:i a d/m/y'
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function feedback(){
        return $this->belongsTo(Feedback::class);
    }

}
