<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Company;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->query('mode', 'view');
        $contracts = Contract::with('company', 'queries')->paginate(15);

        $contracts = $contracts->map(function($contract) {
            return (object) [
                'id' => $contract->id,
                'company_name' => $contract->company->name ?? 'N/A',
                'start_date' => $contract->start_datum?->format('d-m-Y'),
                'end_date' => $contract->eind_datum?->format('d-m-Y'),
                'omschrijving' => $contract->omschrijving,
                'url' => $contract->url,
                'company_id' => $contract->company_id,
                'queries_count' => $contract->queries->count(),
               ];
        });

        return view('contracts.index', compact('contracts', 'mode'));
    }

    public function show(Contract $contract)
    {
        $contract->load('company', 'queries');
        return view('contracts.show', compact('contract'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('contracts.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'omschrijving' => 'required|string|max:256',
            'start_datum' => 'required|date',
            'eind_datum' => 'nullable|date|after:start_datum',
            'url' => 'nullable|url|max:100',
        ]);

        Contract::create($validated);
        return redirect()->route('contracts.index')->with('success', 'Contract aangemaakt');
    }

    public function edit(Contract $contract)
    {
        $companies = Company::all();
        return view('contracts.edit', compact('contract', 'companies'));
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'company_id' => 'nullable|exists:companies,id',
            'omschrijving' => 'required|string|max:45',
            'start_datum' => 'nullable|date',
            'eind_datum' => 'nullable|date|after_or_equal:start_datum',
            'url' => 'nullable|url|max:100',
        ]);

        $contract->update(array_filter($validated, fn($value) => $value !== null));

        return redirect()->route('contracts.index')->with('success', 'Contract geüpdate');
    }


    public function destroy(Contract $contract){
        $contract->delete();
        return redirect()->route('contracts.index')
            ->with('success', 'Contract verwijderd');
    }
}


