<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    }

    public function create()
    {
        $companies = Company::all();
        $subscription_types = SubscriptionType::all();

        return view('subscription/create', compact('companies', 'subscription_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'nullable|exists:companies,id',
            'type' => 'nullable|exists:subscription_types,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'price' => 'required|numeric',
            'notes' => 'nullable|max:256',
            'identifier' => 'required|max:45',
            'token' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();
        $data['start_date'] = $data['start_date'] ?? now();
        $data['price'] = $data['price'] ?? 0;
        $data['token'] = $data['token'] ?? '';
        $data['identifier'] = $data['identifier'] ?? '';

        Subscription::create($data);
        return redirect()->route('subscription.index')
            ->with('success', 'Subscription created successfully');
    }

    public function edit(Subscription $subscription)
    {
        return view('subscription/edit', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $subscription->update($request->only(['']));
        return redirect()->back()->with('success', 'Subscription updated successfully');
    }
}
