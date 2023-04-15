<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MailerLiteApi\MailerLite;

class ApiKeyController extends Controller
{
    public function index()
    {
        $api_key = DB::table('api_keys')->latest('created_at')->first();
        return view('api_keys.index', ['api_key' => $api_key ? $api_key->api_key : '']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
        ]);

        $api_key = $request->input('api_key');
        $mailerlite_client = new MailerLite($api_key);

        try {
            $account = $mailerlite_client->account->get();
            if ($account) {
                DB::table('api_keys')->insert(['api_key' => $api_key]);
                return redirect('/subscribers');
            }
        } catch (\Exception $e) {
            return back()->withErrors(['Invalid API key']);
        }
    }
}

