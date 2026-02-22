<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateDownload extends Model
{
        protected $fillable = [
        'user_id',
        'template_id',
    ];
}
