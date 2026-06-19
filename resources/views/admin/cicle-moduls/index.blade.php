@extends('admin.layout')

@section('title', 'Gestió de Relacions Cicles-Mòduls')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>🔗 Gestió de Relacions Cicles-Mòduls</h2>
    <div>
        <a href="{{ route('admin.cicle-moduls.import-form') }}" class="btn" style="background: #28a745;">📤 Importar CSV</a>
    </div>
</div>

<p style="color: #666; margin-bottom: 20px;">
    Selecciona un cicle per gestionar els mòduls associats
</p>

<table>
    <thead>
        <tr>
            <th>Cicle</th>
            <th>Abreviatura</th>
            <th>Familia</th>
            <th>Nivell</th>
            <th>Mòduls Associats</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cicles as $cicle)
        <tr>
            <td>
                <strong>{{ $cicle->nom }}</strong>
            </td>
            <td>
                <code>{{ $cicle->abreviatura ?? '-' }}</code>
            </td>
            <td>
                {{ $cicle->familia ?? '-' }}
            </td>
            <td>
                {{ $cicle->nivell ?? '-' }}
            </td>
            <td>
                @if ($cicle->moduls->count() > 0)
                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach ($cicle->moduls as $modul)
                            <span style="background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">
                                {{ $modul->abreviatura ? $modul->abreviatura . ' - ' : '' }}{{ $modul->nom }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <span style="color: #999;">Cap mòdul assignat</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.cicle-moduls.manage', $cicle) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">
                    ⚙️ Gestionar
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $cicles->links() }}
</div>
@endsection
