<?php

namespace App\Http\Controllers;

use App\Models\ContactedPeople;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    protected $contact;
    public function __construct(ContactedPeople $people)
    {
        $this->contact  = $people;   
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
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|max:1000'
        ]);
        $condition  = $this->contact->where('email', $request->email)->where('email_checked', '0')->first();
        if($condition){
            return response()->json(['errors' => ['message' => 'Please wait your message has not seen yet.']], 500);
        }
        
        $data =  $request->all();
        $data['secret_id'] = Str::random(16);
        $this->contact->create($data);
        $message = 'Successfull.';
        $response = $this->successResponse([], $message);
        return response()->json($response, 200);
    }

}
