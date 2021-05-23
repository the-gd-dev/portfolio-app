<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\DefaultCreateTrait;
use App\Models\AboutUser;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use DefaultCreateTrait;
    protected $users;
    protected $perpage = 10;
    public function __construct(User $users)
    {
        $this->middleware('superadmin', ['except' => [
            'imageUpload', 'store', 'profile','bannerUpload'
        ]]);
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
        $data['users'] =   $this->users->where('role_id', '!=', '1')->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.users.listing' : 'admin.users.index';
        return view($view, $data);
    }
    public function handleAjax($request)
    {
        $query = $this->users->where('role_id', '!=', '1');
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

    public function getDataCount()
    {
        return $this->users->where('role_id', '!=', '1')->count();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $data['about']      = AboutUser::where('user_id', auth()->user()->id)->first();
        $data['title']    = 'My Profile';
        return view('admin.user-profile', $data);
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
            'name' => 'required|min:4|max:255',
            'username' => 'required|unique:users,username,' . auth()->user()->id . ',id',
        ]);

        $meta = !empty(auth()->user()->user_meta) ?
            json_decode(auth()->user()->user_meta) :
            (object)["display_name" => '', 'social_profiles' => (object)[]];
        $meta->display_name = $request->name;
        $meta->social_profiles->facebook = $request->facebook_profile ?? '';
        $meta->social_profiles->instagram = $request->instagram_profile ?? '';
        $meta->social_profiles->twitter = $request->twitter_profile ?? '';
        $meta->social_profiles->skype = $request->skype_profile ?? '';
        $meta->social_profiles->linkedin = $request->linkedin_profile ?? '';
        $user = User::find(auth()->user()->id)->update([
            'user_meta' => json_encode($meta),
            'name' => $request->name,
            'username' => $request->username
        ]);
        AboutUser::updateOrCreate(['user_id' => auth()->user()->id], $request->about_user);
        if ($user) {
            $this->createDefaultData(User::find(auth()->user()->id));
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
        if (isset($meta->background_image)) {
            $this->deleteOldFile($meta->background_image);
        }
        $meta->background_image = $fileNameToStore;
        if (!isset($meta->social_profiles)) {
            $meta->social_profiles = (object)[];
        };
        User::find(auth()->user()->id)->update(['user_meta' => json_encode($meta)]);
        $this->createDefaultData(User::find(auth()->user()->id));
        return response()->json($this->successResponse(['url' => asset('storage/home-banners/' . $fileNameToStore)], 'File uploaded successfull'), 200);
    }

    /**
     * deleting old file from directory (Previously stored to database)
     */
    public function deleteOldFile($img)
    {
        if (isset($img)) {
            $pubPath = '/storage/home-banners';
            $path = public_path("$pubPath/$img");
            if (file_exists($path)) {
                unlink($path);
            }
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
            $user = $this->users->where('id', $id)->orWhere('secret_id', $id);
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function imageUpload(Request $request)
    {
        $oldFile = auth()->user()->display_picture ?? '';
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileNameToStore = strtoupper(auth()->user()->username) . '-' . date('d-m-Y') . '-' . time() . '.' . $extension;
        $request->file('image')->storeAs('public/display-pictures', $fileNameToStore);
        $this->deleteOldDp($oldFile);
        $data['display_picture'] = $fileNameToStore;
        User::updateOrcreate(['id' => auth()->user()->id], $data);
        return response()->json($this->successResponse(['url' => asset('storage/display-pictures/' . $fileNameToStore)], 'File uploaded successfull'), 200);
    }
    /**
     * deleting old file from directory (Previously stored to database)
     */
    public function deleteOldDp($img)
    {
        if (isset($img) && !empty($img)) {
            $pubPath = '/storage/display-pictures';
            $path = public_path("$pubPath/$img");
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }
}
