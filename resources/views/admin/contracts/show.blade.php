@extends('admin.layout')

@section('title', $contract->title)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>{{ $contract->title }}</h2>
    <div>
        <a href="{{ route('admin.contracts.edit', $contract) }}" class="btn">Editar</a>
        <form method="POST" action="{{ route('admin.contracts.destroy', $contract) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>

<div style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
    <p><strong>Data Inici:</strong> {{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') : 'N/A' }}</p>
    <p><strong>Data Fi:</strong> {{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') : 'N/A' }}</p>
    <p><strong>Descripció:</strong></p>
    <p>{{ $contract->description ?? 'Sense descripció' }}</p>
    <p><strong>Creada:</strong> {{ $contract->created_at->format('d/m/Y H:i') }}</p>
</div>

<div style="margin-top: 20px;">
    <a href="{{ route('admin.contracts.index') }}" class="btn" style="background: #999;">← Tornar</a>
</div>
@endsection
