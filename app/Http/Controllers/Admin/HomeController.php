<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\CustomHttpResponse;
use App\Models\User;

class HomeController extends Controller
{
    use CustomHttpResponse;
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
        return view('admin.dashboard',$data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'display_name' => 'required|min:4|max:50',
        ]);
        $metaData = [
            'display_name' => $request->display_name,
            'background_image' => '',
            'skills' => explode(',' , $request->skills ?? ''),
            'social_profiles' => [
                'facebook' => $request->facebook_profile ?? '',
                'instagram' => $request->instagram_profile ?? '',
                'twitter' => $request->twitter_profile ?? '',
                'skype' => $request->skype_profile ?? '',
                'linkedin' => $request->linkedin_profile ?? '',
            ],
        ];
        $user =  User::find(auth()->user()->id)->update([
            'user_meta' => json_encode($metaData)
        ]);
        if($user){
            return $this->successResponse([], 'Successfull.');
        }

    }
}
