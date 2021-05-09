<?php
namespace App\Http\Traits;

use App\Models\AboutUser;
use App\Models\Resume;

trait DefaultCreateTrait
{
    public function createDefaultData($request){
        $this->createAbout($request);
        $this->createResume($request);
    }
    public function createAbout($request)
    {
        $about = AboutUser::where('user_id', auth()->user()->id)->first();
        if (!$about) {
            AboutUser::create([
                'user_id' => auth()->user()->id,
                'about_image' => 'none',
                'work_profiles' => json_encode([]),
                'birthday' => '2001-01-01',
                'age' => '20'
            ]);
        }
    }
    public function createResume($request)
    {
        $resume = Resume::where('user_id', auth()->user()->id)->first();
        if (!$resume) {
            Resume::create([
                'user_id' => auth()->user()->id
            ]);
        }
    }
}