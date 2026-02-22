<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'price',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        // Saat create
        static::creating(function ($service) {
            $service->slug = static::generateSlug($service->title);
        });

        // Saat update title
        static::updating(function ($service) {
            if ($service->isDirty('title')) {
                $service->slug = static::generateSlug($service->title);
            }
        });
    }

    private static function generateSlug($title)
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'LIKE', "$slug%")->count();

        return $count ? "{$slug}-" . ($count + 1) : $slug;
    }   

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
