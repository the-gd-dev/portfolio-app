<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class RootController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);
        if ($user && !empty($user->user_meta)) {
            $user_meta = json_decode($user->user_meta);
            $data['display_name'] = $user_meta->display_name;
            $data['bg_banner'] = $user_meta->background_image;
            $data['skills'] = implode(',', $user_meta->skills);
            $data['facebook'] = $user_meta->social_profiles->facebook;
            $data['instagram'] = $user_meta->social_profiles->instagram;
            $data['skype'] = $user_meta->social_profiles->skype;
            $data['linkedin'] = $user_meta->social_profiles->linkedin;
            $data['twitter'] = $user_meta->social_profiles->twitter;
        }
        $data['title'] = 'My Portfolio';
        return view('welcome', $data);
    }
}
