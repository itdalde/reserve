<?php

namespace App\Models;

use App\Models\Auth\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryReply extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
}
