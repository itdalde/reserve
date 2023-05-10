<?php

namespace App\Models;

use App\Models\Auth\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    public function createdBy() {
        return $this->hasOne(User::class,'id','created_by');
    }
}
