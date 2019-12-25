<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\DailyGoal;
use App\Meal;
use App\Activity;
use Auth;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{

    public function index()


    {

        
        return DailyGoal::where('user_id',Auth::user()->id)->get();
     
    }

    public function getMeals()
    {
       $meals =  Meal::all()->where('user_id',Auth::user()->id)
                            ->where('created_at', '>=', date('Y-m-d').' 00:00:00');
        return $meals; 
    }

    public function getActivities()
    {
        $activities =  Activity::all()->where('user_id',Auth::user()->id)
                                        ->where('created_at', '>=', date('Y-m-d').' 00:00:00');;
        return $activities;   
    }

    public function getJournal()
    {

        
        $journal = User::with(
            ['Activities'=> function($query) {
                         $query->orderBy('created_at', 'desc'); }, 
             'Meals'=> function($query) {
                         $query->orderBy('created_at', 'desc');
              }])->where('id',Auth::user()->id)->get();
      
        return $journal;   
    }

    

    public function updateUser(Request $request)
    {
        if (!isset($request[0]['name']) || !isset($request[0]['alter'])
        || !isset($request[0]['gewicht'])
        || !isset($request[0]['groesse'])
        || !isset( $request[1]['calories']))
        {
            return 'error';
        }
        else{
        $user =  User::find(Auth::user()->id);
        $dailyGoal= DailyGoal::where('user_id',Auth::user()->id)->get();

        $user->update(['name' => $request[0]['name'],'alter' => $request[0]['alter'],
        'gewicht' => $request[0]['gewicht'],'groesse' => $request[0]['groesse'],'geschlecht' => $request[0]['geschlecht']]);
    

        $dailyGoal[0]->update(['calories' => $request[1]['calories'],'carbohydrate' => $request[1]['carbohydrate'],
        'protein' => $request[1]['protein'],'fat' => $request[1]['fat']]);
        
        return 'success';
    }}

    public function createMeal(Request $request)
    {
        if (!isset($request->name) || !isset($request->calories) || !isset($request->carbohydrate)
        || !isset($request->protein)  || !isset($request->fat))
        {   return 'error';   }
        else{
        $user =  User::find(Auth::user()->id);
        $user->meals()->create([
            'name' => $request->name,  'calories' => $request->calories,
            'carbohydrate' => $request->carbohydrate,'protein' => $request->protein, 'fat' =>$request->fat,       
        ]);
        }
        return 'success';
    }
    public function createActivity(Request $request)
    {
        if (!isset($request->name)  || !isset($request->caloriesBurned) )
        {
        return "error";
        }
        else{
        $user =  User::find(Auth::user()->id);
        $user->activities()->create([
            'activity' => $request->name,
            'caloriesBurned' => $request->caloriesBurned,     
        ]);
            return "success";
        }
    }





}
