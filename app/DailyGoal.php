<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyGoal extends Model
{

    
   protected $fillable = [
    'calories','carbohydrate','protein','fat',
];

/**
 * The attributes that should be hidden for arrays.
 *
 * @var array
 */
protected $hidden = [
    
];

/**
 * The attributes that should be cast to native types.
 *
 * @var array
 */
protected $casts = [
    
];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
