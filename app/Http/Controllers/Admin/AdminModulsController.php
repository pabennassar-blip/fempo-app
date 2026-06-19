<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\Modul;

class AdminModulsController extends Controller
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
        $moduls = Modul::paginate(15);
        return view('admin.moduls.index', compact('moduls'));
    }

    public function show(Modul $modul)
    {
        return view('admin.moduls.show', compact('modul'));
    }

    public function create()
    {
        return view('admin.moduls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'abreviatura' => 'nullable|string|max:50',
        ]);

        Modul::create($validated);
        return redirect()->route('admin.moduls.index')->with('success', 'Mòdul creat');
    }

    public function edit(Modul $modul)
    {
        return view('admin.moduls.edit', compact('modul'));
    }

    public function update(Request $request, Modul $modul)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'abreviatura' => 'nullable|string|max:50',
        ]);

        $modul->update($validated);
        return redirect()->route('admin.moduls.show', $modul)->with('success', 'Mòdul actualitzat');
    }

    public function destroy(Modul $modul)
    {
        $modul->delete();
        return redirect()->route('admin.moduls.index')->with('success', 'Mòdul eliminat');
    }

    public function importForm()
    {
        return view('admin.moduls.import');
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

            Modul::updateOrCreate(
                ['nom' => $row[0]],
                [
                    'nom' => $row[0],
                ]
            );
            $count++;
        }

        return redirect()->route('admin.moduls.index')->with('success', "Importats $count mòduls");
    }
}
