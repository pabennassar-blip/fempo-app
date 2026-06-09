<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmpresaController extends Controller
{
    private const EMPRESA_RELATIONS = ['empresari.user:id,name,email'];

    public function llistar_empreses(Request $request): JsonResponse
    {
        $usuari = $request->user();

        if ($usuari->alumne) {
            return response()->json(collect([]));
        }

        $query = Empresa::with(self::EMPRESA_RELATIONS)->latest('id');

        if ($request->filled('cerca')) {
            $cerca = trim((string) $request->query('cerca'));
            $query->where(function ($subquery) use ($cerca) {
                $subquery
                    ->where('title', 'like', "%{$cerca}%")
                    ->orWhere('description', 'like', "%{$cerca}%")
                    ->orWhere('location', 'like', "%{$cerca}%")
                    ->orWhere('telefon', 'like', "%{$cerca}%")
                    ->orWhere('nom_empresari', 'like', "%{$cerca}%");
            });
        }

        $perPage = min(max((int) $request->query('per_page', 50), 1), 100);
        $empreses = $request->boolean('paginate')
            ? $query->paginate($perPage)
            : $query->get();

        return response()->json($empreses);
    }

    public function obtenir_detalls(int $id): JsonResponse
    {
        $empresa = Empresa::with(self::EMPRESA_RELATIONS)->find($id);

        if (!$empresa) {
            return response()->json(['error' => 'Empresa no trobada'], 404);
        }

        return response()->json($empresa);
    }

    public function crear(Request $request): JsonResponse
    {
        if (!$this->potGestionarEmpreses($request)) {
            return response()->json(['error' => 'No tens permisos per crear empreses'], 403);
        }

        $empresa = Empresa::create($this->validarEmpresa($request));
        $empresa->load(self::EMPRESA_RELATIONS);

        return response()->json([
            'message' => 'Empresa creada correctament',
            'data' => $empresa,
        ], 201);
    }

    public function modificar(Request $request, int $id): JsonResponse
    {
        if (!$this->potGestionarEmpreses($request)) {
            return response()->json(['error' => 'No tens permisos per modificar empreses'], 403);
        }

        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['error' => 'Empresa no trobada'], 404);
        }

        $empresa->fill($this->validarEmpresa($request, $empresa->id, true))->save();
        $empresa->load(self::EMPRESA_RELATIONS);

        return response()->json([
            'message' => 'Empresa modificada correctament',
            'data' => $empresa,
        ]);
    }

    public function eliminar(Request $request, int $id): JsonResponse
    {
        if (!$this->potGestionarEmpreses($request)) {
            return response()->json(['error' => 'No tens permisos per eliminar empreses'], 403);
        }

        $empresa = Empresa::find($id);

        if (!$empresa) {
            return response()->json(['error' => 'Empresa no trobada'], 404);
        }

        if ($empresa->empresaris()->exists()) {
            return response()->json([
                'error' => 'No es pot eliminar una empresa amb empresaris assignats',
            ], 409);
        }

        $empresa->delete();

        return response()->json([
            'message' => 'Empresa eliminada correctament',
        ]);
    }

    private function validarEmpresa(Request $request, ?int $empresaId = null, bool $partial = false): array
    {
        $optional = $partial ? ['sometimes', 'nullable'] : ['nullable'];

        return $request->validate([
            'title' => [
                $partial ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('empresas', 'title')->ignore($empresaId),
            ],
            'logo' => [...$optional, 'string', 'max:255'],
            'description' => [...$optional, 'string'],
            'location' => [...$optional, 'string', 'max:255'],
            'telefon' => [...$optional, 'string', 'max:50'],
            'nom_empresari' => [...$optional, 'string', 'max:255'],
        ]);
    }

    private function potGestionarEmpreses(Request $request): bool
    {
        $usuari = $request->user();

        return $usuari !== null && $usuari->professor()->exists();
    }
}
