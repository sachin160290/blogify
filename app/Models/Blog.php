<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','description','author_id','publish_at','time_to_read','status',
    ];

    public function author()      { return $this->belongsTo(User::class, 'author_id'); }
    public function categories()  { return $this->belongsToMany(Category::class, 'blog_category'); }
    public function tags()        { return $this->belongsToMany(Tag::class, 'blog_tag'); }

    // Visible on frontend: published and publish_at <= now
    public function scopeVisible($q)
    {
        return $q->where('status','published')
                 ->where('publish_at','<=', now());
    }
}
