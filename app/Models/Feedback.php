<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Feedback extends Model
{
    use HasFactory,SoftDeletes;
    protected $table= "feedbacks";
    protected $casts = [
        'created_at' => 'datetime:h:i a d/m/y'
    ];
    protected $fillable = ['product_id', 'feedback_category_id', 'user_id', 'title', 'description', 'files'];
    public function category(){
        return $this->belongsTo(FeedbackCategory::class,"feedback_category_id",'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    // public function getCreatedAtAttribute($date)
    // {
    //     return $date->format('Y-m-d h:i');
    // }
}
