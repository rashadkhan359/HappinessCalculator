<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\contactdetails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactusController extends Controller
{
    public function contactuspost(Request $request){
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'message' => 'required',
               
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 400);
        }
        $contactus=new ContactUs;
        $contactus->name=$request->name;
        $contactus->message=$request->message;
        $contactus->save();
        return response()->json([
            'status' => 'success',
            'message' => 'successfully submitted',
        ], 200);
    }
    public function contactdetails(){
        $contactdetails= contactdetails::all();
        return response()->json([
            'status' => 'success',
            'message' => 'successfully submitted',
            'data'=>$contactdetails
        ], 200);
    }
}
