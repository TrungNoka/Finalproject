<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    use HasFactory;
    protected $table = 'shoppingcarts';
   protected $fillable = [
        'user_id',
        'post_name', 
  ];
}
