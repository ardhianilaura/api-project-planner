<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlannerModel extends Model
{
    protected $fillable = ['task', 'description', 'image'];
}
