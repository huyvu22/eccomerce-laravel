<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EmailConfig;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $emailSettings = EmailConfig::first();
        return view('admin.setting.index', compact('emailSettings'));
    }

    public function emailConfigSettingUpdate(Request $request)
    {
       $request->validate([
           'email' =>'required|email',
           'host' =>'required|max:200',
           'username' =>'required|max:200',
           'password' =>'required|max:200',
           'port' =>'required',
           'encryption' =>'required',

       ]);
      EmailConfig::updateOrCreate(
           ['id' => 1],
           [
               'email' => $request->email,
               'host' => $request->host,
               'username' => $request->username,
               'password' => $request->password,
               'port' => $request->port,
               'encryption' => $request->encryption,
           ]
      );

      toastr()->success('Updated successfully');
      return redirect()->back();
    }
}
