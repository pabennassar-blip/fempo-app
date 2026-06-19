@extends('admin.layout')

@section('title', $ra->name)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>{{ $ra->name }}</h2>
    <div>
        <a href="{{ route('admin.ras.edit', $ra) }}" class="btn">Editar</a>
        <form method="POST" action="{{ route('admin.ras.destroy', $ra) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>

<div style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
    <p><strong>Codi:</strong> <code>{{ $ra->code ?? '-' }}</code></p>
    <p><strong>Descripció:</strong></p>
    <p>{{ $ra->description ?? 'Sense descripció' }}</p>
    <p><strong>Creada:</strong> {{ $ra->created_at->format('d/m/Y H:i') }}</p>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('admin.ras.index') }}" class="btn" style="background: #999;">← Tornar</a>
</div>
@endsection
