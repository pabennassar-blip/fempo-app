<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\Ra;

class AdminRasController extends Controller
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
        $ras = Ra::paginate(15);
        return view('admin.ras.index', compact('ras'));
    }

    public function show(Ra $ra)
    {
        return view('admin.ras.show', compact('ra'));
    }

    public function create()
    {
        return view('admin.ras.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:50',
        ]);

        Ra::create($validated);
        return redirect()->route('admin.ras.index')->with('success', 'RA creat');
    }

    public function edit(Ra $ra)
    {
        return view('admin.ras.edit', compact('ra'));
    }

    public function update(Request $request, Ra $ra)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:50',
        ]);

        $ra->update($validated);
        return redirect()->route('admin.ras.show', $ra)->with('success', 'RA actualitzat');
    }

    public function destroy(Ra $ra)
    {
        $ra->delete();
        return redirect()->route('admin.ras.index')->with('success', 'RA eliminat');
    }

    public function importForm()
    {
        return view('admin.ras.import');
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

            Ra::updateOrCreate(
                ['code' => $row[1] ?? ''],
                [
                    'name' => $row[0],
                    'description' => $row[2] ?? null,
                    'code' => $row[1] ?? null,
                ]
            );
            $count++;
        }

        return redirect()->route('admin.ras.index')->with('success', "Importats $count RAs");
    }
}
