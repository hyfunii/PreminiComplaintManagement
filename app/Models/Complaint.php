<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'status_id',
        'title',
        'description',
        'file_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(ComplaintCategory::class);
    }

    public function status()
    {
        return $this->belongsTo(ComplaintStatus::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
