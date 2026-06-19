@extends('admin.layout')

@section('title', $jornada->title)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>{{ $jornada->title }}</h2>
    <div>
        <a href="{{ route('admin.jornades.edit', $jornada) }}" class="btn">Editar</a>
        <form method="POST" action="{{ route('admin.jornades.destroy', $jornada) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>

<div style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
    <p><strong>Data:</strong> {{ $jornada->date ? \Carbon\Carbon::parse($jornada->date)->format('d/m/Y') : 'N/A' }}</p>
    <p><strong>Hores:</strong> {{ $jornada->hours ?? '-' }}</p>
    <p><strong>Descripció:</strong></p>
    <p>{{ $jornada->description ?? 'Sense descripció' }}</p>
    <p><strong>Creada:</strong> {{ $jornada->created_at->format('d/m/Y H:i') }}</p>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('admin.jornades.index') }}" class="btn" style="background: #999;">← Tornar</a>
</div>
@endsection
