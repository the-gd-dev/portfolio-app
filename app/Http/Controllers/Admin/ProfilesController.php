<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUser;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\UserSkills;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    protected $profiles;
    protected $perpage = 10;
    public function __construct(Profile $profile)
    {
        $this->profiles = $profile;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            return $this->handleAjax($request);
        }
        $data['title']    = 'Profile Management ';
        return view('admin.profiles.index', $data);
    }

    protected function getView($forAjax = null){
        $data['profiles'] =  $this->profiles->orderBy('profile')->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.profiles.listing' : 'admin.profiles.index';
        return view($view, $data);
    }
    
    public function handleAjax($request)
    {
        $query = $this->profiles;
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('profile', 'like', "$search%");
        }
        $data['profiles'] =  $query->orderBy('profile')->paginate($this->perpage);
        $response['appendHtml'] = view('admin.profiles.listing', $data)->render();
        $response['count'] = $query->paginate($this->perpage)->count();
        return $response;
    }

    public function getDataCount(){
        return $this->profiles->count();
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
        $id = $request->profile_id ?? null;
        $request->validate([
            'profile' =>'required|unique:profiles,profile'.$id.',id'
        ]);
        $message = !empty($id) ? 'Successfully updated profile.' : 'Successfully created profile.';
        $profile = $this->profiles->updateOrCreate(['id' => $id],$request->all());
        $data['appendHtml'] =  $this->getView('ajax')->render();
        $data['count'] = $this->getDataCount();
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
        AboutUser::where('user_id', auth()->user()->id)->update(['work_profiles'=> json_encode($profileIds)]);
        $skills = $request->input('skills') ?? [];
        $profiles = Profile::with('skills')->whereIn('id', $profileIds)->get();
        // UserSkills::where('user_id', auth()->user()->id)->whereNotIn('skill_id', $skills)->delete();
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
            Skill::where('profile_id',$id)->delete();
            if($isDeleted){
                $message = 'Successfully deleted profile.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                $data['count'] = $this->getDataCount();
                return $this->successResponse($data, $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
     /**
     * Bulk Actions On Resources
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function bulkAction(Request $request, $action)
    {
        $payload = $request->payload;
        if($action == 'delete'){
            $profiles = $this->profiles->whereIn('id', $payload);
            if (isset($profiles)) {
                $profiles->delete();
                Skill::whereIn('profile_id', $payload)->delete();
            }
        }
        $data['appendHtml'] =  $this->getView('ajax')->render();
        return $this->successResponse($data, 'Deleted Successfully. ');
    }
}
