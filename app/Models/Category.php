<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

}
