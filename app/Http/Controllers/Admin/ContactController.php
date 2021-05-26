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
        $data['contacts'] =  $this->contacts
            ->where('recipient', auth()->user()->id)
            ->orderBy('name')
            ->paginate($this->perpage);
        $view = ($forAjax === 'ajax') ? 'admin.contacts.listing' : 'admin.contacts.index';
        return view($view, $data);
    }

    public function handleAjax($request)
    {
        $query = $this->contacts->where('recipient', auth()->user()->id);
        if ($request->Has('search') && !empty($request->search)) {
            $search = $request->search;
            $query = $query->where('name', 'like', "$search%")
                ->orWhere('email', 'like', "$search%");
        }
        $data['contacts'] =  $query->orderBy('name')->paginate($this->perpage);
        $response['appendHtml'] = view('admin.contacts.listing', $data)->render();
        $response['count'] = $query->paginate($this->perpage)->count();
        return $response;
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
        $response = $this->successResponse(['count' => $this->getDataCount()], $message);
        $this->createActivity(auth()->user(), 'updated_contact_form', 'contact-form', $data);
        return response()->json($response, 200);
    }
    public function getDataCount()
    {
        $user_id = auth()->user()->id;
        return $this->contacts->where('recipient', $user_id)->count();
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
    public function create()
    {
    }
    public function store(Request $request)
    {
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $this->createActivity(auth()->user(), 'updated_contact_form', 'contact-form', $request->except('_method'));
        return $this->contacts->where('secret_id', $id)->update($request->except('_method'));
    }
    public function destroy($id)
    {
        try {
            $contacts = $this->contacts->where('secret_id', $id)->first();
            if (!isset($contacts)) {
                return response()->json(['message' => 'No message Found.'], 404);
            }
            $isDeleted = $contacts->delete();
            if ($isDeleted) {
                $message = 'Successfully deleted message.';
                $data['appendHtml'] =  $this->getView('ajax')->render();
                $data['count'] = $this->getDataCount();
                $this->createActivity(auth()->user(), 'deleted_contact_messages', 'contact-form');
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
            case 'read':
                $contacts = $this->contacts->whereIn('secret_id', $payload);
                if (isset($contacts)) {
                    $contacts->update(['email_checked' => '1']);
                }
                $message = 'Read All Messages.';
                break;
            case 'unread':
                $contacts = $this->contacts->whereIn('secret_id', $payload);
                if (isset($contacts)) {
                    $contacts->update(['email_checked' => '0']);
                }
                $message = 'Unread All Messages.';
                break;
            default:
                break;
        }
        $data['appendHtml'] =  $this->getView('ajax')->render();
        $data['count'] = $this->getDataCount();
        return $this->successResponse($data, $message);
    }
}
