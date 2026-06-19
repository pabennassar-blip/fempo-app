@extends('admin.layout')

@section('title', $empresa->title)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>{{ $empresa->title }}</h2>
    <div>
        <a href="{{ route('admin.companies.edit', $empresa) }}" class="btn">Editar</a>
        <form method="POST" action="{{ route('admin.companies.destroy', $empresa) }}" style="display: inline;" onsubmit="return confirm('Segur que vols eliminar?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>

<div style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
    <p><strong>Nom:</strong> {{ $empresa->title }}</p>
    <p><strong>Ubicació:</strong> {{ $empresa->location ?? 'N/A' }}</p>
    <p><strong>Telèfon:</strong> {{ $empresa->telefon ?? 'N/A' }}</p>
    <p><strong>Descripció:</strong></p>
    <p>{{ $empresa->description ?? 'Sense descripció' }}</p>
    <p><strong>Creada:</strong> {{ $empresa->created_at->format('d/m/Y H:i') }}</p>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('admin.companies.index') }}" class="btn" style="background: #999;">← Tornar</a>
</div>
@endsection
