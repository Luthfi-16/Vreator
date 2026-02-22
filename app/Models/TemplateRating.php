<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateRating extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'rating',
        'review',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
