@extends('admin.layout')

@section('title', 'Detalls Cicle')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Detalls Cicle: {{ $cicle->nom }}</h2>
    <div>
        <a href="{{ route('admin.cicles.edit', $cicle) }}" class="btn">✏️ Editar</a>
        <a href="{{ route('admin.cicles.index') }}" class="btn" style="background: #999;">Tornar</a>
    </div>
</div>

<div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <div style="margin-bottom: 15px;">
        <strong style="display: block; margin-bottom: 5px; color: #667eea;">Nom:</strong>
        <span>{{ $cicle->nom }}</span>
    </div>
    
    <div style="margin-bottom: 15px;">
        <strong style="display: block; margin-bottom: 5px; color: #667eea;">Data Creació:</strong>
        <span>{{ $cicle->created_at->format('d/m/Y H:i') }}</span>
    </div>

    <div style="margin-bottom: 15px;">
        <strong style="display: block; margin-bottom: 5px; color: #667eea;">Última Actualització:</strong>
        <span>{{ $cicle->updated_at->format('d/m/Y H:i') }}</span>
    </div>
</div>

<div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
    <h3>Accions</h3>
    <form method="POST" action="{{ route('admin.cicles.destroy', $cicle) }}" style="margin-top: 10px;" onsubmit="return confirm('Estàs segur que vols eliminar aquest cicle?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">🗑️ Eliminar Cicle</button>
    </form>
</div>
@endsection
