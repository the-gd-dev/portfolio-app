<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $users;
    protected $perpage = 10;
    public function __construct(User $users)
    {
        $this->middleware('superadmin');
        $this->users = $users;
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
        $data['title']    = 'Users Management ';
        return view('admin.users.index', $data);
    }

    protected function getView($forAjax = null)
    {
        $data['users'] =   $this->users->where('role_id','!=', '1')->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.users.listing' : 'admin.users.index';
        return view($view, $data);
    }
    public function handleAjax($request)
    {
        $query = $this->users->where('role_id','!=', '1');
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('name', 'like', "$search%")
                           ->orWhere('email', 'like', "$search%")
                           ->orWhere('username', 'like', "$search%");
        }
        $data['users'] =  $query->paginate($this->perpage);
        $response['appendHtml'] = view('admin.users.listing', $data)->render();
        $response['count'] = $query->paginate($this->perpage)->count();
        return $response;
    }
    
    public function getDataCount(){
        return $this->users->where('role_id','!=', '1')->count();
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
        return $this->users
            ->updateOrCreate(['id' => $id], $request->all());
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
            $user = $this->users->where('id',$id)->orWhere('secret_id',$id);
            if (!isset($user)) {
                return response()->json(['message' => 'No user Found.'], 404);
            }
            $isDeleted = $user->delete();
            if ($isDeleted) {
                $message = 'Successfully deleted user.';
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
        $message = '';
        switch ($action) {
            case 'delete':
                $user = $this->users->whereIn('id', $payload);
                    if (isset($user)) {
                        $user->delete();
                    }
                $message = 'Deleted Successfully.';
                break;
            case 'active':
                $user = $this->users->whereIn('id', $payload);
                    if (isset($user)) {
                        $user->update(['is_active' =>  '1']);
                    }
                $message = 'Activated Successfully.';
                break;
            case 'inactive':
                $user = $this->users->whereIn('id', $payload);
                    if (isset($user)) {
                        $user->update(['is_active' => '0']);
                    }
                $message = 'Deactivated Successfully.';
                break;
            default:
                break;
        }
        $data['appendHtml'] =  $this->getView('ajax')->render();
        $data['count'] = $this->getDataCount();
        return $this->successResponse($data, $message);
    }
}
