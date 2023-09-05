<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\NewsletterSubscriberDataTable;
use App\Helper\MailHepler;
use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscrible;
use Illuminate\Http\Request;
use Mail;

class SubscriblersController extends Controller
{
    public function index(NewsletterSubscriberDataTable $dataTable)
    {
        return $dataTable->render('admin.subscriber.index');
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $emails = NewsletterSubscrible::where('is_verified',1)->pluck('email')->toArray();

        //mail config
        MailHepler::setMailConfig();

        Mail::to($emails)->send(new \App\Mail\Newsletter($request->title, $request->content));
        toastr()->success('Mail sent successfully!');
        return redirect()->back();

    }

    public function destroy(string $id)
    {
        NewsletterSubscrible::find($id)->delete();
        toastr()->success('Subscriber deleted successfully');
        return redirect()->back();
    }
}
