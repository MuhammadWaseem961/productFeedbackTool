<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= "feedbacks";
    protected $fillable = ['product_id', 'feedback_category_id', 'user_id', 'title', 'description', 'files'];
}
