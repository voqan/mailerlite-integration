<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MailerLiteApi\MailerLite;
use Yajra\DataTables\DataTables;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $api_key = DB::table('api_keys')->latest('created_at')->first();
            if (!$api_key) {
                return response()->json(['error' => 'No API key found.'], 404);
            }
            $mailerlite_client = new MailerLite($api_key->api_key);
            $subscribers = $mailerlite_client->subscribers->get();

            return DataTables::of($subscribers)
                ->addColumn('action', function ($subscriber) {
                    return '<a href="/subscribers/' . $subscriber->id . '/edit" class="btn btn-sm btn-primary">Edit</a> ' .
                           '<button data-id="' . $subscriber->id . '" class="btn btn-sm btn-danger delete-subscriber">Delete</button>';
                })
                ->editColumn('date_subscribe', function ($subscriber) {
                    return date('d/m/Y', strtotime($subscriber->date_subscribe));
                })
                ->editColumn('time_subscribe', function ($subscriber) {
                    return date('H:i', strtotime($subscriber->time_subscribe));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('subscribers.index');
    }

    public function create()
    {
        return view('subscribers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'country' => 'required|string',
        ]);

        $api_key = DB::table('api_keys')->latest('created_at')->first();
        if (!$api_key) {
            return back()->withErrors(['No API key found.']);
        }
        $mailerlite_client = new MailerLite($api_key->api_key);

        $subscriber_data = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'country' => $request->input('country'),
        ];

        try {
            $subscriber = $mailerlite_client->subscribers->create($subscriber_data);
            return redirect('/subscribers')->with('success', 'Subscriber created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $api_key = DB::table('api_keys')->latest('created_at')->first();
        if (!$api_key) {
            return response()->json(['error' => 'No API key found.'], 404);
        }
        $mailerlite_client = new MailerLite($api_key->api_key);

        try {
            $mailerlite_client->subscribers->delete($id);
            return response()->json(['message' => 'Subscriber deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function edit($id)
    {
        $api_key = DB::table('api_keys')->latest('created_at')->first();
        if (!$api_key) {
            return back()->withErrors(['No API key found.']);
        }
        $mailerlite_client = new MailerLite($api_key->api_key);
        $subscriber = $mailerlite_client->subscribers->find($id);

        return view('subscribers.edit', ['subscriber' => $subscriber]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'country' => 'required|string',
        ]);

        $api_key = DB::table('api_keys')->latest('created_at')->first();
        if (!$api_key) {
            return back()->withErrors(['No API key found.']);
        }
        $mailerlite_client = new MailerLite($api_key->api_key);

        $subscriber_data = [
            'name' => $request->input('name'),
            'country' => $request->input('country'),
        ];

        try {
            $subscriber = $mailerlite_client->subscribers->update($id, $subscriber_data);
            return redirect('/subscribers')->with('success', 'Subscriber updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }
}


