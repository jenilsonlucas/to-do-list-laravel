<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    /**
     * The attributes that are mass assignable.
     * @var list<string>
     */

     protected $fillable = [
        'name',
        'description',
        'user_id'
     ];

     /**
      * Get the user that owns the Category.
      */
     public function user()
     {
        return $this->belongsTo(User::class);
     }

}
