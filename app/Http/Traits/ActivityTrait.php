<?php
namespace App\Http\Traits;
use App\Models\Activity;
trait ActivityTrait {
    public function createActivity($user, $type = null, $page = null , $data = []){
        if($user->role_id !== 1){
            Activity::create([
                'user_id' => $user->id,
                'activity_data' => json_encode($data),
                'activity' => $type,
                'page' => $page
            ]);
        }
    }
}