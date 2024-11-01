<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['complaint_id', 'file_path', 'file_type'];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
}
