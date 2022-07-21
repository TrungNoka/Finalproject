<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes; // add soft delete


class Post extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    use HasFactory,
        SoftDeletes;
   protected $fillable = [
        'post_name',
        'category_id',
        'color',
        'size',
        'price',
        'img',
        'imgadd',
        'content',
        'description',
  ];

    protected $casts = [
            'color' => 'json',
            'size' => 'json',
        ];

    public function category (){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function colors (){
        return $this->belongsToJson(Color::class, 'color');
    }

    public function sizes (){
        return $this->belongsToJson(Size::class, 'size');
    }

    public function getColorsAttribute(){
            $color = $this->color;    
            $nameColor = Color::whereIn('id', $color)->select('color')->get();
            
            return $nameColor;
        }

        public function getSizesAttribute(){
            $size = $this->size;
            $nameSize = Size::whereIn('id', $size)->select('size_name')->get();
            
            return $nameSize;
        }
}
