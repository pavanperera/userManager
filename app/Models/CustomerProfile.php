<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CustomerProfile extends Model
{
    use HasFactory;

    protected $table = 'customer_profiles';

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'contact_email', 'phone_number',  'address', 'dob', 'gender', 'is_active',
    ];

    /**
     * Accessor for Age.
     */
    public function age()
    {
        return Carbon::parse($this->attributes['dob'])->age;
    }
}
