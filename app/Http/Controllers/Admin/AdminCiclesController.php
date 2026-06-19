<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\Cicle;

class AdminCiclesController extends Controller
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
        $cicles = Cicle::paginate(15);
        return view('admin.cicles.index', compact('cicles'));
    }

    public function show(Cicle $cicle)
    {
        return view('admin.cicles.show', compact('cicle'));
    }

    public function create()
    {
        return view('admin.cicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'abreviatura' => 'nullable|string|max:50',
            'familia' => 'nullable|string|max:100',
            'grau' => 'nullable|string|max:100',
            'nivell' => 'nullable|string|max:100',
            'estudi' => 'nullable|string|max:100',
        ]);

        Cicle::create($validated);
        return redirect()->route('admin.cicles.index')->with('success', 'Cicle creat');
    }

    public function edit(Cicle $cicle)
    {
        return view('admin.cicles.edit', compact('cicle'));
    }

    public function update(Request $request, Cicle $cicle)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'abreviatura' => 'nullable|string|max:50',
            'familia' => 'nullable|string|max:100',
            'grau' => 'nullable|string|max:100',
            'nivell' => 'nullable|string|max:100',
            'estudi' => 'nullable|string|max:100',
        ]);

        $cicle->update($validated);
        return redirect()->route('admin.cicles.show', $cicle)->with('success', 'Cicle actualitzat');
    }

    public function destroy(Cicle $cicle)
    {
        $cicle->delete();
        return redirect()->route('admin.cicles.index')->with('success', 'Cicle eliminat');
    }

    public function importForm()
    {
        return view('admin.cicles.import');
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

            Cicle::updateOrCreate(
                ['nom' => $row[0]],
                [
                    'nom' => $row[0],
                ]
            );
            $count++;
        }

        return redirect()->route('admin.cicles.index')->with('success', "Importats $count cicles");
    }
}
