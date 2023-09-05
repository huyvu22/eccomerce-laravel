<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FooterColumnThreeDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterColumnThree;
use App\Models\FooterTitle;
use Illuminate\Http\Request;

class FooterColumnThreeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FooterColumnThreeDataTable $dataTable)
    {
        $footerTitle = FooterTitle::first();
        return $dataTable->render('admin.footer.footer-column-3.index', compact('footerTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer.footer-column-3.create');
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

        $footerColumn3 = new FooterColumnThree();
        $footerColumn3->name = $request->name;
        $footerColumn3->url = $request->url;
        $footerColumn3->status = $request->status;
        $footerColumn3->save();
        toastr()->success('Created Successfully');
        return redirect()->route('admin.footer-column-3.index');
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
        $footerColumn3 = FooterColumnThree::findOrFail($id);
        return view('admin.footer.footer-column-3.edit', compact('footerColumn3'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $footerColumn3 = FooterColumnThree::findOrFail($id);
        if (!$request->has('switch_status')) {
            $request->validate([
                'name' => 'required|max:200' . $footerColumn3->id,
                'url' => 'required|url',
                'status' => 'required',
            ]);
        }

        if ($request->has('switch_status')) {
            $footerColumn3->status = $request->switch_status;
            $footerColumn3->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $footerColumn3->fill([
                'name' => $request->name,
                'url' => $request->url,
                'status' => $request->status,
            ])->save();

            toastr()->success('Updated Successfully');
            return redirect()->route('admin.footer-column-3.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $footerColumn3 = FooterColumnThree::findOrFail($id);
        $footerColumn3->delete();
        toastr()->success('Deleted Successfully');
        return redirect()->back();
    }

    public function changeTitle(Request $request)
    {

        $request->validate([
            'title' => 'required|max:200',
        ]);
        FooterTitle::updateOrCreate(
            ['id' => 1],
            ['footer_column_3_title' => $request->title]
        );
        toastr()->success('Updated Successfully');
        return redirect()->back();

    }
}
