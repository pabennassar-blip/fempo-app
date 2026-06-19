<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use App\Models\Cicle;
use App\Models\Modul;

class AdminCicleModulsController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('admin'),
        ];
    }

    /**
     * Mostrar cicles per gestionar mòduls
     */
    public function index()
    {
        $cicles = Cicle::with('moduls')->paginate(15);
        return view('admin.cicle-moduls.index', compact('cicles'));
    }

    /**
     * Mostrar vista de gestió de mòduls per un cicle específic
     */
    public function manage(Cicle $cicle)
    {
        $cicle->load('moduls');
        $allModuls = Modul::all();
        $assignedModulIds = $cicle->moduls->pluck('id')->toArray();
        
        return view('admin.cicle-moduls.manage', [
            'cicle' => $cicle,
            'allModuls' => $allModuls,
            'assignedModulIds' => $assignedModulIds,
        ]);
    }

    /**
     * Sincronitzar mòduls d'un cicle (crear/eliminar relacions)
     */
    public function sync(Request $request, Cicle $cicle)
    {
        $validated = $request->validate([
            'moduls' => 'nullable|array',
            'moduls.*' => 'exists:moduls,id',
        ]);

        // Syncronitzar: afegir nous, mantenir actualitzats i eliminar els que no estan
        $cicle->moduls()->sync($validated['moduls'] ?? []);

        return redirect()->route('admin.cicle-moduls.manage', $cicle)
            ->with('success', 'Relacions actualitzades correctament');
    }

    /**
     * Afegir un mòdul a un cicle
     */
    public function attach(Request $request, Cicle $cicle)
    {
        $validated = $request->validate([
            'modul_id' => 'required|exists:moduls,id',
        ]);

        // Evitar duplicats amb "attach" que ho fa automàticament
        if (!$cicle->moduls()->where('modul_id', $validated['modul_id'])->exists()) {
            $cicle->moduls()->attach($validated['modul_id']);
        }

        return redirect()->route('admin.cicle-moduls.manage', $cicle)
            ->with('success', 'Mòdul afegit al cicle');
    }

    /**
     * Eliminar un mòdul d'un cicle
     */
    public function detach(Cicle $cicle, Modul $modul)
    {
        $cicle->moduls()->detach($modul->id);

        return redirect()->route('admin.cicle-moduls.manage', $cicle)
            ->with('success', 'Mòdul eliminat del cicle');
    }
}
