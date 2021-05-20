<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\DefaultCreateTrait;
use App\Models\User;

class HomeController extends Controller
{
    use DefaultCreateTrait;
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
        $meta = !empty(auth()->user()->user_meta) ? 
                    json_decode(auth()->user()->user_meta) :
                        (object)["display_name" => '', 'social_profiles' => (object)[]];
        $meta->display_name = $request->display_name;
        $meta->social_profiles->facebook = $request->facebook_profile ?? '';
        $meta->social_profiles->instagram = $request->instagram_profile ?? '';
        $meta->social_profiles->twitter = $request->twitter_profile ?? '';
        $meta->social_profiles->skype = $request->skype_profile ?? '';
        $meta->social_profiles->linkedin = $request->linkedin_profile ?? '';
        $user = User::find(auth()->user()->id)->update([
            'user_meta' => json_encode($meta)
        ]);
        $this->createDefaultData($request);
        if ($user) {
            return $this->successResponse([], 'Successfull.');
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
        $this->deleteOldFile($meta->background_image);
        $meta->background_image = $fileNameToStore;
        if (!isset($meta->social_profiles)) {
            $meta->social_profiles = (object)[];
        };
        User::find(auth()->user()->id)->update(['user_meta' => json_encode($meta)]);
        $this->createDefaultData($request);
        return response()->json($this->successResponse(['url' => asset('storage/home-banners/' . $fileNameToStore)], 'File uploaded successfull'), 200);
    }
    
    /**
     * deleting old file from directory (Previously stored to database)
     */
    public function deleteOldFile($img)
    {
        if(isset($img)){
            $pubPath = '/storage/home-banners';
            $path = public_path("$pubPath/$img");
            if (file_exists($path)) {
                unlink($path);
            } 
        }
    }
}
