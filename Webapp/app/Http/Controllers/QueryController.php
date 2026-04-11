<?php

namespace App\Http\Controllers;

use App\Models\Query;
use App\Models\Contract;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function index(Contract $contract)
    {
        $queries = $contract->queries()->paginate(15);
        return view('queries.index', compact('contract', 'queries'));
    }

    public function create(Contract $contract)
    {
        return view('queries.create', compact('contract'));
    }

    public function store(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'omschrijving' => 'required|string|max:256',
        ]);

        $contract->queries()->create($validated);

        return redirect()->route('queries.index', $contract)->with('success', 'Query created!');
    }

    public function edit(Query $query)
    {
        return view('queries.edit', compact('query'));
    }

    public function update(Request $request, Query $query)
    {
        $validated = $request->validate([
            'omschrijving' => 'required|string|max:256',
        ]);

        $query->update($validated);

        return redirect()->route('queries.index', $query->contract)->with('success', 'Query updated!');
    }

    public function destroy(Query $query)
    {
        $contract = $query->contract;
        $query->delete();

        return redirect()->route('queries.index', $contract)->with('success', 'Query deleted!');
    }
}
