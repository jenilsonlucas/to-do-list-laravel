<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    
    /**
     * @var list<string>
     */

     protected $fillable = [
        "name",
        "description",
        "completed",
        "due_at",
        "user_id",
        "category_id"
     ];



    /**
     * Get the user that owns the task
     */

     public function user():BelongsTo
     {
        return $this->belongsTo(User::class);
     }

     /**
      * get the category that owns the task
      */

      public function category():BelongsTo
      {
        return $this->belongsTo(Category::class);
      }
}
