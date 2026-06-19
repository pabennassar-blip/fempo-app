<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\Contract;

class AdminContractsController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('admin'),
        ];
    }

    public function index()
    {
        $contracts = Contract::paginate(15);
        return view('admin.contracts.index', compact('contracts'));
    }

    public function show(Contract $contract)
    {
        return view('admin.contracts.show', compact('contract'));
    }

    public function create()
    {
        return view('admin.contracts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        Contract::create($validated);
        return redirect()->route('admin.contracts.index')->with('success', 'Contracte creat');
    }

    public function edit(Contract $contract)
    {
        return view('admin.contracts.edit', compact('contract'));
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $contract->update($validated);
        return redirect()->route('admin.contracts.show', $contract)->with('success', 'Contracte actualitzat');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('admin.contracts.index')->with('success', 'Contracte eliminat');
    }

    public function importForm()
    {
        return view('admin.contracts.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        $count = 0;
        foreach ($data as $index => $row) {
            if ($index === 0) continue;
            if (count($row) < 1 || empty($row[0])) continue;

            Contract::create([
                'title' => $row[0],
                'description' => $row[1] ?? null,
                'start_date' => $row[2] ?? null,
                'end_date' => $row[3] ?? null,
            ]);
            $count++;
        }

        return redirect()->route('admin.contracts.index')->with('success', "Importats $count contractes");
    }
}
