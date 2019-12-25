<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    
    protected $fillable = [
        'activity', 'caloriesBurned',
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
