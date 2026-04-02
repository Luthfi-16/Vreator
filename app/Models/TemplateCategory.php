<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class TemplateCategory extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        // Saat create
        static::creating(function ($category) {
            $category->slug = static::generateSlug($category->name);
        });

        // Saat update title
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = static::generateSlug($category->name);
            }
        });
    }

    private static function generateSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'LIKE', "$slug%")->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }   

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function template()
    {
        return $this->hasMany(Template::class, 'category_id');
    }
}
