<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['title'] = 'Home - Management ';
        return view('admin.home', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name' => 'required|min:4|max:50',
        ]);
        if($request->bg_banner) {
            $extension = $request->file('bg_banner')->getClientOriginalExtension();
            $fileNameToStore = 'BG-BANNER-' . date('d-m-Y') . '-' . time() . '.' . $extension;
            $request->file('bg_banner')->storeAs('public/home-banners', $fileNameToStore);
        }
        $metaData = [
            'display_name' => $request->display_name,
            'background_image' => $fileNameToStore ?? '',
            'skills' => explode(',', $request->skills ?? ''),
            'social_profiles' => [
                'facebook' => $request->facebook_profile ?? '',
                'instagram' => $request->instagram_profile ?? '',
                'twitter' => $request->twitter_profile ?? '',
                'skype' => $request->skype_profile ?? '',
                'linkedin' => $request->linkedin_profile ?? '',
            ]
        ];
        $user = User::find(auth()->user()->id)->update([
            'user_meta' => json_encode($metaData)
        ]);
        if ($user) {
            return $this->successResponse([], 'Successfull.');
        }
    }

    public function uploadImage()
    {
    }
}
