<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSkills;

class UserSkillsController extends Controller
{
    protected $userSkills;
    public function __construct(UserSkills $userSkills)
    {
        $this->userSkills = $userSkills;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Get specified resources.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserSkills(Request $request)
    {
        $skillIds = $request->query('skills') ?? [];
        foreach ($skillIds as $key => $skill_id) {
            $userSkilll =  $this->userSkills->where('skill_id', $skill_id)->first();
            $this->userSkills->updateOrCreate(['user_id'   =>  auth()->user()->id, 'skill_id'   =>  $skill_id], [
                'skill_accuracy'   =>  $userSkilll->skill_accuracy ?? 0,
                'skill_summery'    => $userSkilll->skill_summery ?? '',
            ]);
        }
        $skills =  $this->userSkills
                        ->with('skill')
                        ->where('user_id', auth()->user()->id)
                        ->whereIn('skill_id', $skillIds)
                        ->orderBy('skills_order')
                        ->get();

        return  response()->json(compact('skills'));
    }

    /**
     * Set order of resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setOrder(Request $request)
    {
        try {
            $orders = $request->sorted_data;
            foreach ($orders as $o) {
                $userSkillDB = $this->userSkills
                    ->where('user_id', auth()->user()->id)
                    ->where('skill_id', $o['id'])
                    ->first();
                if ($userSkillDB) {
                    $userSkillDB->update(['skills_order' => $o['order']]);
                }
            }
            $skills = $this->userSkills
                        ->with('skill')
                        ->where('user_id', auth()->user()->id)
                        ->orderBy('skills_order')
                        ->get();
            return $this->successResponse(['skills' => $skills], 'Re-Ordered Successfully.');
        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->userSkills->where('user_id', auth()->user()->id)->delete();
            $skillsDetails = $request->input('skills') ?? [];
            foreach ($skillsDetails as $item) {
                $this->userSkills->updateOrCreate(
                    [
                        'user_id'   =>  auth()->user()->id, 
                        'skill_id'   => $item['skill_id']
                    ], 
                    [
                        'skill_accuracy'   =>  $item['skill_accuracy'] ??  0,
                        'skill_summery'    => $item['skill_summery'] ?? '',
                    ]
                );
            }
            return $this->successResponse([], 'Skills Details Saved Successfully.');
        } catch (\Exception $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
