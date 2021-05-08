<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\UserSkills;
use Illuminate\Http\Request;

class SkillsController extends Controller
{
    protected $skills;
    public function __construct(Skill $skill)
    {
        $this->skills = $skill;
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
        $data['title']    = 'Skills Management';
        $data['profiles'] = Profile::orderBy('profile')->get();
        $data['skills'] =  $this->skills->with('profile')->orderBy('skill')->paginate(10);
        $view = ($forAjax === 'ajax') ? 'admin.skills.listing' : 'admin.skills.index';
        return view($view, $data);
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
            'skill' =>'required',
            'profile_id' => 'required'
        ]);
        $id = $request->skill_id ?? null;
        $message = !empty($id) ? 'Successfully updated skill.' : 'Successfully created skill.';
        $skill = $this->skills->updateOrCreate(['id' => $id],$request->all());
        $data['appendHtml'] =  $this->getView('ajax')->render();
        return $this->successResponse($data, $message);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setColors(Request $request)
    {
        $id = $request->skill_id ?? null;
        $skill = $this->skills->find($id);
        if(!$skill){ return response()->json(404);}
        if($request->has('text_color')){  $skill->update(['text_color' => trim($request->text_color)]); }
        if($request->has('background_color')){  $skill->update(['background_color' => trim($request->background_color)]); }
        // return $this->successResponse([], 'Icon set successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveIcon(Request $request)
    {
        $id = $request->skill_id ?? null;
        $skill = $this->skills->find($id);
        if(!$skill){ return response()->json(404);}
        $skill->update(['icon' => trim($request->icon)]);
        return $this->successResponse([], 'Icon set successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $skill = $this->skills->find($id);
            if(!isset($skill)){ return response()->json(['message' => 'No Skills Found.'],404); }
            return response()->json(['skill' => $skill],200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
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
            $skill = $this->skills->find($id);
            if(!isset($skill)){ return response()->json(['message' => 'No Skills Found.'],404); }
            $isDeleted = $skill->delete();
            if($isDeleted){
                $message = 'Successfully deleted skill.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                return $this->successResponse($data, $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}
