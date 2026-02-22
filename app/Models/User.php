<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'password',
        'role',
        'bio',
        'whatsapp',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function templates()
    {
        return $this->hasMany(Template::class);
    }

    public function downloadedTemplates()
    {
        return $this->belongsToMany(
            Template::class,
            'template_downloads',
            'user_id',
            'template_id'
        );
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function templateRatings()
    {
        return $this->hasMany(TemplateRating::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Saat create
        static::creating(function ($user) {
            $user->slug = static::generateSlug($user->name);
        });

        // Saat update name
        static::updating(function ($user) {
            if ($user->isDirty('name')) {
                $user->slug = static::generateSlug($user->name);
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

}
