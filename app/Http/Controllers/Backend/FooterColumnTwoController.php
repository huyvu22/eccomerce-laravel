<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FooterColumnTwoDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterColumnTwo;
use App\Models\FooterTitle;
use Illuminate\Http\Request;

class FooterColumnTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterColumnTwoDataTable $dataTable)
    {
        $footerTitle = FooterTitle::first();
        return $dataTable->render('admin.footer.footer-column-2.index', compact('footerTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-column-2.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'url' => 'required|url',
            'status' => 'required',
        ]);

        $footerColumn2 = new FooterColumnTwo();
        $footerColumn2->name = $request->name;
        $footerColumn2->url = $request->url;
        $footerColumn2->status = $request->status;
        $footerColumn2->save();
        toastr()->success('Created Successfully');
        return redirect()->route('admin.footer-column-2.index');
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
    public function edit(string $id)
    {
        $footerColumn2 = FooterColumnTwo::findOrFail($id);
        return view('admin.footer.footer-column-2.edit', compact('footerColumn2'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $footerColumn2 = FooterColumnTwo::findOrFail($id);
        if (!$request->has('switch_status')) {
            $request->validate([
                'name' => 'required|max:200' . $footerColumn2->id,
                'url' => 'required|url',
                'status' => 'required',
            ]);
        }

        if ($request->has('switch_status')) {
            $footerColumn2->status = $request->switch_status;
            $footerColumn2->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $footerColumn2->fill([
                'name' => $request->name,
                'url' => $request->url,
                'status' => $request->status,
            ])->save();

            toastr()->success('Updated Successfully');
            return redirect()->route('admin.footer-column-2.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $footerColumn2 = FooterColumnTwo::findOrFail($id);
        $footerColumn2->delete();
        toastr()->success('Deleted Successfully');
        return redirect()->back();
    }

    public function changeTitle(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);
        $footerColumn2 = FooterTitle::find(1);
        $footerColumn2->footer_column_2_title = $request->title;
        $footerColumn2->save();

        toastr()->success('Updated Successfully');
        return redirect()->back();
    }
}
