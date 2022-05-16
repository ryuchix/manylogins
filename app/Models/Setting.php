<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_title',
        'site_keywords',
        'site_description',
        'banned_keywords',
        'copyright_text',
        'facebook_url',
        'twitter_url',
        'google_url',
        'youtube_url',
        'footer_logo',
        'header_logo',
    ];
}

