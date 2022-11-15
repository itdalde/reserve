<?php

namespace App\Models;

use App\Models\Auth\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiries extends Model
{
    use HasFactory;

    public function inquiryAttachments() {
        return $this->hasMany(InquiryAttachments::class, 'inquiries_id', 'id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function inquiryReplies() {
        return $this->hasMany(InquiryReply::class, 'inquiries_id', 'id');
    }
}
