<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    public mixed $notes;
    /**
     * @var Authenticatable|mixed|null
     */
    public mixed $user;
    protected $fillable = ['notes'];
}
