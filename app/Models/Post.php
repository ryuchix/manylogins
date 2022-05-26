<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use QCod\ImageUp\HasImageUploads;

use App\Models\User;
use App\Models\Category;

class Post extends Model implements Viewable
{
    use HasFactory, InteractsWithViews, HasImageUploads;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'cover',
        'user_id',
        'status',
    ];

    protected $imagesUploadDisk = 'local';
    protected $imagesUploadPath = 'images/posts';
    protected $autoUploadImages = true;
    
    protected static $imageFields = [
        'cover' => [
            'width' => 1280,
            'height' => 720,
            'crop' => true,
            'rules' => 'image|max:5000',
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
