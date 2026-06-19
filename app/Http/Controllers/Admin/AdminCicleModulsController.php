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

    /**
     * Mostrar formulari d'importació
     */
    public function importForm()
    {
        return view('admin.cicle-moduls.import');
    }

    /**
     * Importar relacions desde CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        $count = 0;
        $errors = [];
        $missing = ['cicles' => [], 'moduls' => []];

        foreach ($data as $index => $row) {
            $lineNum = $index + 1;
            
            // Saltar encabezado
            if ($index === 0) continue;
            
            // Saltar filas vacías
            if (count($row) < 2 || empty($row[0]) || empty($row[1])) continue;

            $cicleAbreviatura = trim($row[0]);
            $modulNom = trim($row[1]);

            // Buscar el cicle per abreviatura
            $cicle = Cicle::where('abreviatura', $cicleAbreviatura)->first();
            if (!$cicle) {
                $missing['cicles'][] = $cicleAbreviatura;
                $errors[] = "Línia $lineNum: Cicle amb abreviatura '$cicleAbreviatura' no existeix";
                continue;
            }

            // Buscar el modul per nom
            $modul = Modul::where('nom', $modulNom)->first();
            if (!$modul) {
                $missing['moduls'][] = $modulNom;
                $errors[] = "Línia $lineNum: Mòdul '$modulNom' no existeix";
                continue;
            }

            // Comprovar si la relació ja existeix
            if (!$cicle->moduls()->where('modul_id', $modul->id)->exists()) {
                $cicle->moduls()->attach($modul->id);
                $count++;
            }
        }

        // Preparar mensaje de respuesta
        $message = "S'han importat $count relacions";
        
        if (!empty($errors)) {
            $errorCount = count($errors);
            return redirect()->route('admin.cicle-moduls.index')
                ->with('warning', $message)
                ->with('errors', $errors)
                ->with('missing', $missing);
        }

        return redirect()->route('admin.cicle-moduls.index')
            ->with('success', $message);
    }
}
