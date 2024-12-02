<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SubscriberJob;
use App\Models\Contact;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriberController extends Controller
{

    public function index(): View
    {
        $setTitle = "All Subscribers";
        $subscribers = Subscriber::latest()->paginate(getPaginate());

        return view('admin.subscriber', compact(
            'setTitle',
            'subscribers'
        ));
    }


    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);

        $subscribers = Subscriber::cursor();

        foreach ($subscribers as $subscriber){
            SubscriberJob::dispatch([
                'email' => $subscriber->email,
                'subject' => $request->input('subject'),
                'content' => $request->input('body'),
            ]);
        }

        return back()->with('notify', [['success', __('Email will be send to all subscribers')]]);
    }


    public function contacts(): View
    {
        $setTitle = "Manage Contacts";
        $contacts = Contact::latest()->paginate(getPaginate());

        return view('admin.contact', compact(
            'setTitle',
            'contacts'
        ));
    }
}
