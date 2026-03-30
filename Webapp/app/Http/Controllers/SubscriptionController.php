<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller{
    public function index(Request $request)
    {
        $subscriptions = DB::table('subscriptions')
            ->join('companies', 'subscriptions.company', '=', 'companies.id')
            ->join('subscription_types', 'subscriptions.type', '=', 'subscription_types.id')
            ->select(
                'subscriptions.*',
                'companies.name as company_name',
                'subscription_types.name as type_name',
                'subscription_types.description'
            )
            ->orderBy('subscriptions.id')
            ->get();

        return view('subscription.index', compact('subscriptions'));
    }}
