<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['title', 'slug', 'summary', 'price', 'image'];

    public function setSlugAttribute($title){
        $this->attributes['slug'] = self::uniqueSlug($title);
    }

    public static function uniqueSlug($title){
        $slug = str_replace(' ', '-', strtolower($title)); // Replaces all spaces with hyphens.
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug); // Removes special chars.
        $slug = preg_replace('/-+/', '-', $slug); // Replaces multiple hyphens with single one.
        return $slug;
    }

    // product feedbacks
    public function feedbacks(){
        return $this->hasMany(Feedback::class);
    }

    // get list of of user id whose give feedbacks
    public function feedbacksUsersID(){
        return Feedback::where('product_id',$this->id)->distinct('user_id')->pluck('user_id')->toArray();
    }
}
