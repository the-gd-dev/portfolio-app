<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\CustomHttpResponse;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\UserSkills;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    protected $profiles;
    public function __construct(Profile $profile)
    {
        $this->profiles = $profile;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->getView();
    }

    protected function getView($forAjax = null){
        $data['title']    = 'Profile Management ';
        $data['profiles'] =  $this->profiles->orderBy('profile')->paginate(25);
        $view = ($forAjax === 'ajax') ? 'admin.profiles.listing' : 'admin.profiles.index';
        return view($view, $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'profile' =>'required|unique:profiles'
        ]);
        $id = $request->profile_id ?? null;
        $message = !empty($id) ? 'Successfully updated profile.' : 'Successfully created profile.';
        $profile = $this->profiles->updateOrCreate(['id' => $id],$request->all());
        $data['appendHtml'] =  $this->getView('ajax')->render();
        return $this->successResponse($data, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSkills(Request $request)
    {
        $profileIds = $request->input('profiles') ?? [];  
        $skills = $request->input('skills') ?? [];
        $profiles = Profile::with('skills')->whereIn('id', $profileIds)->get();
        $user_skills = UserSkills::where('user_id', auth()->user()->id)->pluck('skill_id')->toArray();
        return  response()->json(compact('profiles','user_skills'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $profile = $this->profiles->find($id);
            if(!isset($profile)){ return response()->json(['message' => 'No Profile Found.'],404); }
            $isDeleted = $profile->delete();
            if($isDeleted){
                $message = 'Successfully deleted profile.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                return $this->successResponse($data, $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}
