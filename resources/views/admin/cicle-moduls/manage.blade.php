@extends('admin.layout')

@section('title', 'Gestionar Mòduls - ' . $cicle->nom)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2>Gestionar Mòduls: <span style="color: #667eea;">{{ $cicle->abreviatura ? $cicle->abreviatura . ' - ' : '' }}{{ $cicle->nom }}</span></h2>
        <p style="color: #666; font-size: 0.95em; margin-top: 5px;">
            Familia: <strong>{{ $cicle->familia ?? '-' }}</strong> | 
            Grau: <strong>{{ $cicle->grau ?? '-' }}</strong> | 
            Nivell: <strong>{{ $cicle->nivell ?? '-' }}</strong> | 
            Estudi: <strong>{{ $cicle->estudi ?? '-' }}</strong>
        </p>
    </div>
    <a href="{{ route('admin.cicle-moduls.index') }}" class="btn" style="background: #999;">← Tornar</a>
</div>

<!-- Mòduls Assignats -->
<div style="margin-bottom: 30px;">
    <h3 style="color: #667eea; margin-bottom: 15px;">📖 Mòduls Assignats</h3>
    
    @if ($cicle->moduls->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Mòdul</th>
                    <th>Abreviatura</th>
                    <th>Data Assignació</th>
                    <th>Accions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cicle->moduls as $modul)
                <tr>
                    <td><strong>{{ $modul->nom }}</strong></td>
                    <td><code>{{ $modul->abreviatura ?? '-' }}</code></td>
                    <td>{{ $modul->pivot->created_at->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.cicle-moduls.detach', [$cicle, $modul]) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.9em;">🗑️ Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="background: #f9f9f9; padding: 20px; border-radius: 8px; text-align: center; color: #999;">
            <p>No hi ha mòduls assignats a aquest cicle</p>
        </div>
    @endif
</div>

<!-- Mòduls Disponibles -->
<div style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
    <h3 style="color: #667eea; margin-bottom: 15px;">➕ Afegir Mòduls</h3>
    
    @if ($allModuls->count() > 0)
        <form method="POST" action="{{ route('admin.cicle-moduls.attach', $cicle) }}">
            @csrf

            <div style="margin-bottom: 15px;">
                <label for="modul_id" style="display: block; margin-bottom: 8px; font-weight: bold;">Selecciona un mòdul</label>
                <select name="modul_id" id="modul_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em;">
                    <option value="">-- Escull un mòdul --</option>
                    @foreach ($allModuls as $modul)
                        @if (!in_array($modul->id, $assignedModulIds))
                            <option value="{{ $modul->id }}">{{ $modul->abreviatura ? $modul->abreviatura . ' - ' : '' }}{{ $modul->nom }}</option>
                        @endif
                    @endforeach
                </select>
                @error('modul_id')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="btn" style="background: #28a745;">✅ Afegir Mòdul</button>
        </form>

        @if (count($assignedModulIds) === $allModuls->count())
            <div style="background: #e8f5e9; padding: 12px; border-radius: 4px; margin-top: 15px; color: #2e7d32;">
                ✓ Tots els mòduls estan assignats a aquest cicle
            </div>
        @endif
    @else
        <div style="background: #fff3e0; padding: 15px; border-radius: 8px; color: #e65100;">
            ⚠️ No hi ha mòduls disponibles. Crea mòduls primer.
        </div>
    @endif
</div>

<!-- Gestió Per Checkbox (Alternativa) -->
<div style="margin-top: 30px; background: #f0f4ff; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea;">
    <h3 style="color: #667eea; margin-bottom: 15px;">🔄 Sincronitzar Tots els Mòduls</h3>
    
    <p style="color: #666; margin-bottom: 15px; font-size: 0.95em;">
        Marca els mòduls que vols assignar a aquest cicle. Els no marcats seran eliminats.
    </p>

    <form method="POST" action="{{ route('admin.cicle-moduls.sync', $cicle) }}">
        @csrf

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 15px; margin-bottom: 20px;">
            @foreach ($allModuls as $modul)
            <div style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 4px; border: 1px solid #e0e0e0;">
                <input 
                    type="checkbox" 
                    name="moduls[]" 
                    value="{{ $modul->id }}" 
                    id="modul_{{ $modul->id }}"
                    {{ in_array($modul->id, $assignedModulIds) ? 'checked' : '' }}
                    style="width: 18px; height: 18px; margin-right: 10px; cursor: pointer;"
                >
                <label for="modul_{{ $modul->id }}" style="margin: 0; cursor: pointer; flex: 1;">
                    <strong>{{ $modul->abreviatura ?? '-' }}</strong><br>
                    <span style="font-size: 0.9em; color: #666;">{{ $modul->nom }}</span>
                </label>
            </div>
            @endforeach
        </div>

        <button type="submit" class="btn" style="background: #667eea;">💾 Guardar Canvis</button>
    </form>
</div>
@endsection
