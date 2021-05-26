<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    protected $activities;
    protected $perpage = 10;
    public function __construct(Activity $activities)
    {
        $this->middleware('superadmin', [
            'except' => [
                'index'
            ]
        ]);
        $this->activities = $activities;
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
        $data['title']    = 'Activities Management ';
        return view('admin.activities.index', $data);
    }

    protected function getView($forAjax = null)
    {
        $data['activities'] =  $this->activities->latest()->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.activities.listing' : 'admin.activities.index';
        return view($view, $data);
    }
    public function handleAjax($request)
    {
        $is_superadmin =  auth()->user()->role_id == 1;
        $user_id = auth()->user()->id;
        $query = $this->activities->with('user');
        if(!$is_superadmin){
            $query = $query->where('user_id', $user_id);
        }
        
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('activity', 'like', "$search%");
        }
        $data1['activities'] =  $query->paginate($this->perpage);
        $response['appendHtml'] = view('admin.activities.listing', $data1)->render();
        $response['count'] = $query->get()->count();
        return $response;
    }

    public function getDataCount(){
        $is_superadmin =  auth()->user()->role_id == 1;
        $user_id = auth()->user()->id;
        return  $is_superadmin ? 
                    $this->portfolio->get()->count():
                    $this->activities->where('user_id', $user_id)->count();
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
        //
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
        try {
            $activity = $this->activities->find($id);
            if (!isset($activity)){
                return response()->json(['message' => 'No  Found.'], 404);
            }
            $isDeleted = $activity->delete();
            if ($isDeleted) {
                $message = 'Successfully deleted activity.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                $data['count'] = $this->getDataCount();
                return $this->successResponse($data, $message);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
            $activity = $this->activities->whereIn('id', $payload);
            if (isset($activity)) {
                $activity->delete();
            }
        }
        $data['count'] = $this->getDataCount();
        $data['appendHtml'] =  $this->getView('ajax')->render();
        return $this->successResponse($data, 'Deleted Successfully. ');
    }
}
