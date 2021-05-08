<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AboutUser;
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
        $meta = !empty(auth()->user()->user_meta) ? json_decode(auth()->user()->user_meta) : (object)[];
        $meta->display_name = $request->display_name;
        $meta->social_profiles->facebook = $request->facebook_profile ?? '';
        $meta->social_profiles->instagram = $request->instagram_profile ?? '';
        $meta->social_profiles->twitter = $request->twitter_profile ?? '';
        $meta->social_profiles->skype = $request->skype_profile ?? '';
        $meta->social_profiles->linkedin = $request->linkedin_profile ?? '';
        $user = User::find(auth()->user()->id)->update([
            'user_meta' => json_encode($meta)
        ]);
        $this->createAbout($request);
        if ($user) {
            return $this->successResponse([], 'Successfull.');
        }
    }

    public function createAbout($request)
    {
        $about = AboutUser::where('user_id', auth()->user()->id)->first();
        if (!$about) {
            AboutUser::create([
                'user_id' => auth()->user()->id,
                'about_image' => 'none',
                'work_profiles' => $request->skills,
                'birthday' => '',
                'age' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bannerUpload(Request $request)
    {
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileNameToStore = 'Home-Banner-' . (auth()->user()->id) . '-' . date('d-m-Y') . '-' . time() . '.' . $extension;
        $request->file('image')->storeAs('public/home-banners', $fileNameToStore);
        $meta = !empty(auth()->user()->user_meta) ? json_decode(auth()->user()->user_meta) : (object)[];
        $meta->background_image = $fileNameToStore;
        if(!isset($meta->social_profiles)){
            $meta->social_profiles = (object)[];
        };
        User::find(auth()->user()->id)->update(['user_meta' => json_encode($meta)]);
        return response()->json($this->successResponse(['url' => asset('storage/home-banners/' . $fileNameToStore)], 'File uploaded successfull'), 200);
    }
}
