<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\VnPaySetting;
use Illuminate\Http\Request;

class VnPaySettingController extends Controller
{
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required',
            'mode' => 'required',
            'country' => 'required',
            'currency_name' => 'required',
            'currency_rate' => 'required',
            'client_id' => 'required',
            'secret_key' => 'required',
        ]);
        VnPaySetting::updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->status,
                'mode' => $request->mode,
                'country_name' => $request->currency_name,
                'currency_name' => $request->currency_name,
                'currency_rate' => $request->currency_rate,
                'client_id' => $request->client_id,
                'secret_key' => $request->secret_key,
            ]
        );
        \toastr()->success('Updated Successfully');
        return \redirect()->back();
    }
}
