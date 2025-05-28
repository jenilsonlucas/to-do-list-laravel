<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    
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
     public function user(): BelongsTo
     {
        return $this->belongsTo(User::class);
     }

     /**
      * Get the task for the category
      */

      public function tasks():HasMany
      {
         return $this->hasMany(Task::class);
      }
     
      public function tasksDone(): HasMany
      {
         return $this->tasks()->where('completed', true)->orderBy('updated_at', 'desc');
      }

      public function tasksUndone():HasMany
      {
         return $this->tasks()->where('completed', false)->orderBy('created_at', 'desc');
      }
}
