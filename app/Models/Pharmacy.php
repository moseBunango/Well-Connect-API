<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable=[
        'user_id',
        'name',
        'location',
        'distance',
        'image',
    ];
    public function medicines()
{
    return $this->hasMany(Medicine::class);
}
public function orders()
{
    return $this->hasMany(PharmacyOrder::class);
}

}
