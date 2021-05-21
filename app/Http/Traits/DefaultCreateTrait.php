<?php

namespace App\Http\Traits;

use App\Models\AboutUser;
use App\Models\Resume;
use App\Models\Setting;

trait DefaultCreateTrait
{
    public function createDefaultData($user)
    {
        $this->createAbout($user);
        $this->createResume($user);
        $this->createSectionSettings($user);
    }
    public function createAbout($user)
    {
        $about = AboutUser::where('user_id', $user->id)->first();
        if (!$about) {
            AboutUser::create([
                'user_id' => $user->id,
                'about_image' => 'none',
                'work_profiles' => json_encode([]),
                'birthday' => '2001-01-01',
                'age' => '20'
            ]);
        }
    }
    public function createResume($user)
    {
        $resume = Resume::where('user_id', $user->id)->first();
        if (!$resume) {
            Resume::create([
                'user_id' => $user->id
            ]);
        }
    }
    public function createSectionSettings($user)
    {
        $contact_form_setting = Setting::where('user_id', $user->id)
            ->where('setting', 'hide_contact_form')
            ->where('page', 'contact_form')
            ->first();

        if (!$contact_form_setting) {
            Setting::create([
                'value' => '0',
                'setting' => 'hide_contact_form',
                'user_id' => $user->id,
                'page' => 'contact_form',
                'is_apply' => '1'
            ]);
        }
    }
}
