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
        $contracts = Contract::with('company')->paginate(15);
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
