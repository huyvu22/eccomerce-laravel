<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FooterSocialDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterSocial;
use Illuminate\Http\Request;

class FooterSocialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterSocialDataTable $dataTable)
    {
        return $dataTable->render('admin.footer.footer-socials.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-socials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'icon' => 'required|max:200',
           'name' => 'required|max:200',
           'url' => 'required|url',
           'status' => 'required',
        ]);

        $footerSocial = new FooterSocial();
        $footerSocial->icon = $request->icon;
        $footerSocial->name = $request->name;
        $footerSocial->url = $request->url;
        $footerSocial->status = $request->status;
        $footerSocial->save();
        toastr()->success('Created Successfully');
        return redirect()->route('admin.footer-socials.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FooterSocial $footerSocial)
    {
        return view('admin.footer.footer-socials.edit', compact('footerSocial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FooterSocial $footerSocial)
    {
        if (!$request->has('switch_status')) {
            $request->validate([
            'icon' => 'required|not_in:empty',
            'name' => 'required|max:200' . $footerSocial->id,
            'url' => 'required|url',
            'status' => 'required',
            ]);
        }

        if ($request->has('switch_status')) {
            $footerSocial->status = $request->switch_status;
            $footerSocial->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $footerSocial->fill([
                'icon' => $request->icon,
                'name' => $request->name,
                'url' => $request->url,
                'status' => $request->status,
            ])->save();

            toastr()->success('Updated Successfully');
            return redirect()->route('admin.footer-socials.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FooterSocial $footerSocial)
    {
        $footerSocial->delete();
        toastr()->success('Deleted Successfully');
        return redirect()->back();
    }
}
