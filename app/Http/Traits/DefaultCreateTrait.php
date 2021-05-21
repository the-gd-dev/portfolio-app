<?php
namespace App\Http\Traits;

use App\Models\AboutUser;
use App\Models\Resume;

trait DefaultCreateTrait
{
    public function createDefaultData($user){
        $this->createAbout($user);
        $this->createResume($user);
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
}