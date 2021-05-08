<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AboutUser;
use App\Models\Profile;
use App\Models\UserSkills;

class RootController extends Controller
{
    public function index($id)
    {
        $data['title'] = 'My Portfolio';
        $user = User::findOrFail($id);
        if ($user && !empty($user->user_meta)) {
            $user_meta = json_decode($user->user_meta);
            $data['title'] = "$user_meta->display_name - Portfolio";
            $data['display_name'] = $user_meta->display_name;
            $data['bg_banner'] = $user_meta->background_image;
            $data['facebook'] = $user_meta->social_profiles->facebook;
            $data['instagram'] = $user_meta->social_profiles->instagram;
            $data['skype'] = $user_meta->social_profiles->skype;
            $data['linkedin'] = $user_meta->social_profiles->linkedin;
            $data['twitter'] = $user_meta->social_profiles->twitter;
            $data['about'] = AboutUser::where('user_id', $id)->first();
            $data['skills'] = UserSkills::with('skill')->where('user_id', $id)->get();
            if (isset($data['about']->work_profiles)) {
                $data['work_profiles'] = Profile::whereIn('id', json_decode($data['about']->work_profiles))->pluck('profile')->toArray();
            }
        }
        
        return view('welcome', $data);
    }
}
