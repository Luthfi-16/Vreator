<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Software extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        // Saat create
        static::creating(function ($software) {
            $software->slug = static::generateSlug($software->name);
        });

        // Saat update title
        static::updating(function ($software) {
            if ($software->isDirty('name')) {
                $software->slug = static::generateSlug($software->name);
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
        return $this->hasMany(Template::class, 'software_id');
    }
}
