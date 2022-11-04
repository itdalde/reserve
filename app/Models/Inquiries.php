<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiries extends Model
{
    use HasFactory;

    public function inquiryAttachments() {
        return $this->hasMany(InquiryAttachments::class, 'inquiries_id', 'id');
    }
}
