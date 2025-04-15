<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
   /**
    * @use HasFactory<\Database\Factories\TaskFactory>
    */
    use HasFactory;
    /**
     * @var list<string>
     */

     protected $fillable = [
        "name",
        "description",
        "completed",
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
