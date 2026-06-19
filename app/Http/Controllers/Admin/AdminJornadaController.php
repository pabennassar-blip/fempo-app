<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\Jornada;

class AdminJornadaController extends Controller
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
        $jornades = Jornada::paginate(15);
        return view('admin.jornades.index', compact('jornades'));
    }

    public function show(Jornada $jornada)
    {
        return view('admin.jornades.show', compact('jornada'));
    }

    public function create()
    {
        return view('admin.jornades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'hours' => 'nullable|numeric',
        ]);

        Jornada::create($validated);
        return redirect()->route('admin.jornades.index')->with('success', 'Jornada creada');
    }

    public function edit(Jornada $jornada)
    {
        return view('admin.jornades.edit', compact('jornada'));
    }

    public function update(Request $request, Jornada $jornada)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'hours' => 'nullable|numeric',
        ]);

        $jornada->update($validated);
        return redirect()->route('admin.jornades.show', $jornada)->with('success', 'Jornada actualitzada');
    }

    public function destroy(Jornada $jornada)
    {
        $jornada->delete();
        return redirect()->route('admin.jornades.index')->with('success', 'Jornada eliminada');
    }

    public function importForm()
    {
        return view('admin.jornades.import');
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

            Jornada::create([
                'title' => $row[0],
                'description' => $row[1] ?? null,
                'date' => $row[2] ?? null,
                'hours' => $row[3] ?? null,
            ]);
            $count++;
        }

        return redirect()->route('admin.jornades.index')->with('success', "Importades $count jornades");
    }
}
