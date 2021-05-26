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
}
