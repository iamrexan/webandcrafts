<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
      "name",
      "email",
      "photo",
      "designation_id",
      "password"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
      "password"
    ];

    /**
     * The method which used to make relaitonship between designation and employee
     *
     * @var object
     */
    public function designation() {
      return $this->belongsTo(Designation::class);
    }
}
