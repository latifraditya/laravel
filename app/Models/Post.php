<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory, Sluggable;

    //protected $fillable = ['title', 'excerpt', 'body']; //array yang boleh diisi fillable
    protected $guarded = ['id'];                      //array yang tidak boleh diisi guarded
    protected $with = ['category', 'author'];          //mengambil data category dan author secara otomatis
    
    public function scopeFilter($query,array $filters)
    {
      $query->when($filters['search'] ?? false, function($query, $search) {
        return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
      });

      $query->when($filters['category'] ?? false, function($query, $category) {
        return $query->whereHas('category', function($query) use ($category) {
          $query->where('slug', $category);
        });
      });

      $query->when($filters['author'] ?? false, function($query, $author) {
        return $query->whereHas('author', function($query) use ($author) {
          $query->where('username', $author);
        });
      });

    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRouteKeyName()
    {
      return 'slug';
    }


    // ***********
    // Slug otomatis di create new post
    // ***********
    public function sluggable(): array
    {
      return [
        'slug' => [
          'source' => 'title'
        ]
      ];
    }
}
