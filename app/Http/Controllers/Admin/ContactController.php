<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactedPeople;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $contacts;
    protected $perpage = 10;
    public function __construct(ContactedPeople $contact)
    {
        $this->contacts = $contact;
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
        $data['title']    = 'Contacts Management ';
        return view('admin.contacts.index', $data);
    }

    protected function getView($forAjax = null)
    {
        $data['contacts'] =  $this->contacts->orderBy('name')->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.contacts.listing' : 'admin.contacts.index';
        return view($view, $data);
    }

    public function handleAjax($request)
    {
        $query = $this->contacts;
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('name', 'like', "$search%")
                           ->orWhere('email', 'like', "$search%");
        }
        $data['contacts'] =  $query->orderBy('name')->paginate($this->perpage);
        return  ['appendHtml' => view('admin.contacts.listing', $data)->render()];
    }
    /**
     * Updating Settings
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->except('hide_contact_form');
        Setting::updateOrCreate(['setting' => 'hide_contact_form', 'page' => 'contact_form', 'user_id' => $user_id], [
            'value' => isset($request->hide_contact_form) ? '1' : '0',
            'setting' => 'hide_contact_form',
            'user_id' => $user_id,
            'page' => 'contact_form',
            'is_apply' => '1'
        ]);
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['setting' => $key, 'page' => 'contact_form',  'user_id' => $user_id], [
                'value' => $value['value'],
                'user_id' => $user_id,
                'page' => 'contact_form',
                'setting' => $key,
                'is_apply' => isset($value['apply']) ? '1' : '0'
            ]);
        }
        $message = 'Successfully updated contact form settings.';
        $response = $this->successResponse([], $message);
        return response()->json($response, 200);
    }
    /**
     * Fetch Settings
     * @return \Illuminate\Http\Response
     */
    public function getContactSettings()
    {
        $user_id = auth()->user()->id;
        $responseData = $this->getSettings($user_id, 'contact_form', 'true');
        return response()->json(['data' => $responseData], 200);
    }
    public function create(){}
    public function store(Request $request){}
    public function show($id){}
    public function edit($id){}
    public function update(Request $request, $id){}
    public function destroy($id){}
}
