<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AboutUser;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Profile;
use App\Models\Resume;
use App\Models\Service;
use App\Models\UserSkills;

class RootController extends Controller
{
    public function index($id)
    {
        $data['title'] = 'My Portfolio';
        $user = User::findOrFail($id);
        if ($user && !empty($user->user_meta)) {
            $user_meta = json_decode($user->user_meta);
            $displayName = $user_meta->display_name ?? $user->name;
            $data['user_id'] = $id;
            $data['title'] = "$displayName - Portfolio";
            $data['display_name'] = $displayName;
            $data['bg_banner'] = $user_meta->background_image ?? '';
            $data['facebook'] = $user_meta->social_profiles->facebook ?? '';
            $data['instagram'] = $user_meta->social_profiles->instagram ?? '';
            $data['skype'] = $user_meta->social_profiles->skype ?? '';
            $data['linkedin'] = $user_meta->social_profiles->linkedin ?? '';
            $data['twitter'] = $user_meta->social_profiles->twitter ?? '';
            $data['about']  = AboutUser::where('user_id', $id)->first();
            $data['skills'] = UserSkills::with('skill')->where('user_id', $id)->get();
            $data['portfolio_settings'] = $this->getSettings($id, 'portfolio');
            $data['service_settings'] = $this->getSettings($id, 'service');
            $data['contact_settings'] = $this->getSettings($id, 'contact_form');
            $data['resume'] = Resume::with('experiences', 'qualifications')->where('user_id', $id)->first();
            $data['pcats'] = PortfolioCategory::where('user_id', $id)->get();
            $data['portfolios'] = Portfolio::with('images', 'category')->where('user_id', $id)->get();
            $data['services'] = Service::where('user_id', $id)->get();
            if (isset($data['about']->work_profiles)) {
                $data['work_profiles'] = Profile::whereIn('id', json_decode($data['about']->work_profiles))->pluck('profile')->toArray();
            }
        }else{
            return 'please add info by logging in into your panel.';
        }

        return view('welcome', $data);
    }

    public function getProjectDetails($id)
    {
        $portfolio =  Portfolio::with('images', 'category')->find($id);
        if (!isset($portfolio)) {
            abort(404);
        }
        $data['title']      = 'Edit Portfolio';
        $data['portfolio']  =  $portfolio;
        return view('portfolio-details', $data);
    }
}
