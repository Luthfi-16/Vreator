<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'software_id',
        'category_id',
        'slug',
        'description',
        'status',
        'price',
        'file',
        'preview',
        'preview_video',
        'download_count',
        'average_rating',
        'rating_count',        
    ];

    protected static function boot()
    {
        parent::boot();

        // Saat create
        static::creating(function ($template) {
            $template->slug = static::generateSlug($template->title);
        });

        // Saat update title
        static::updating(function ($template) {
            if ($template->isDirty('title')) {
                $template->slug = static::generateSlug($template->title);
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

    public function downloads()
    {
        return $this->belongsToMany(
            User::class,
            'template_downloads',
            'template_id',
            'user_id'
        );
    }

    public function software()
    {
        return $this->belongsTo(Software::class);
    }

    public function category()
    {
        return $this->belongsTo(TemplateCategory::class);
    }

    public function ratings()
    {
        return $this->hasMany(TemplateRating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    public function ratingCount()
    {
        return $this->ratings()->count();
    }

    public function Transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
