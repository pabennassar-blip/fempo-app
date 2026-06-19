<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\Empresa;

class AdminCompaniesController extends Controller
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
        $companies = Empresa::paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    public function show(Empresa $empresa)
    {
        return view('admin.companies.show', compact('empresa'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:20',
        ]);

        Empresa::create($validated);
        return redirect()->route('admin.companies.index')->with('success', 'Empresa creada');
    }

    public function edit(Empresa $empresa)
    {
        return view('admin.companies.edit', compact('empresa'));
    }

    public function update(Request $request, Empresa $empresa)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:20',
        ]);

        $empresa->update($validated);
        return redirect()->route('admin.companies.show', $empresa)->with('success', 'Empresa actualitzada');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('admin.companies.index')->with('success', 'Empresa eliminada');
    }

    public function importForm()
    {
        return view('admin.companies.import');
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
            if ($index === 0) continue; // Skip header
            if (count($row) < 1 || empty($row[0])) continue;

            Empresa::updateOrCreate(
                ['title' => $row[0]],
                [
                    'title' => $row[0],
                    'description' => $row[1] ?? null,
                    'location' => $row[2] ?? null,
                    'telefon' => $row[3] ?? null,
                ]
            );
            $count++;
        }

        return redirect()->route('admin.companies.index')->with('success', "Importats $count empreses");
    }
}
