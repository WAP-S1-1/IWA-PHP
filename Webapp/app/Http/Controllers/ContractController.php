<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Company;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    // READ - Get all contracts
    public function index()
    {
        // Fetch contracts with company relationship AND queries
        $contracts = Contract::with('company', 'queries')->paginate(15);

        // MAP the data to match what the view expects
        $contracts = $contracts->map(function($contract) {
            return (object) [
                'id' => $contract->id,
                'company_name' => $contract->company->name ?? 'N/A',
                'start_date' => $contract->start_datum?->format('d-m-Y'),
                'end_date' => $contract->eind_datum?->format('d-m-Y'),
                'omschrijving' => $contract->omschrijving,
                'url' => $contract->url,
                'company_id' => $contract->company_id,
                'queries_count' => $contract->queries->count(), // Add this
               ];
        });

        return view('contracts.index', compact('contracts'));
    }

    // READ - Show single contract
    public function show(Contract $contract)
    {
        $contract->load('company', 'queries');
        return view('contracts.show', compact('contract'));
    }

    // CREATE - Show form
    public function create()
    {
        $companies = Company::all();
        return view('contracts.create', compact('companies'));
    }

    // CREATE - Store in database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'omschrijving' => 'required|string|max:45',
            'start_datum' => 'required|date',
            'eind_datum' => 'nullable|date|after:start_datum',
            'url' => 'required|url|max:100',
        ]);

        Contract::create($validated);

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully!');
    }

    // UPDATE - Show edit form
    public function edit(Contract $contract)
    {
        $companies = Company::all();
        return view('contracts.edit', compact('contract', 'companies'));
    }

    // UPDATE - Save changes
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'omschrijving' => 'required|string|max:45',
            'start_datum' => 'required|date',
            'eind_datum' => 'nullable|date|after:start_datum',
            'url' => 'required|url|max:100',
        ]);

        $contract->update($validated);

        return redirect()->route('contracts.show', $contract)->with('success', 'Contract updated successfully!');
    }

    // DELETE
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully!');
    }
}
