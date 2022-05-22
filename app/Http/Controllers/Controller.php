<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('table');
    }

    public function showform()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'mobile' => 'required|unique:users,mobile_no|regex:/^[0-9]*$/|min:10|max:10',
            'dob' => 'required|before:-21 years',
            'image' => 'required|image|mimes:jpg|max:2048',
        ], [
            'name.required' => 'Name is required',
            'name.regex' => 'Only letters and space allowed',
            'mobile.required' => 'Mobile Number is required',
            'mobile.unique' => 'This Mobile Number is already taken',
            'mobile.regex' => 'Only numeric allowed',
            'dob.required' => 'Date of Birth is required',
            'dob.before' => 'Only 21+ Year old allowed',
            'image.required' => 'Image is required',
            'image.image' => 'Only Image allowed',
            'image.mimes' => 'Only .jpg extension allowed',

        ]);

        if ($validator->fails()) {
            // return response($validator->messages(), 200);
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('images'), $imageName);

            $data = [
                'name' => $request->name,
                'mobile_no' => $request->mobile,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'image' => $imageName,
            ];

            if (User::create($data)) {
                return response(["success" => "Successfully Added"], 200);
            } else {
                return response(["error" => "Error"], 200);
            }
        }
    }

    public function getdata()
    {
        $data = User::orderBy('id', 'desc')->get();
        return $data;
    }

    public function deletedata(Request $request)
    {
        // dd($request->all());
        $data = User::find($request->id);

        if ($data->delete()) {
            return response(["success" => "Deleted Successfully"], 200);
        }
        return response(["success" => "Error"], 200);
    }
}
