@extends('admin.layout')

@section('title', 'Editar Contracte')

@section('content')
<h2>Editar Contracte: {{ $contract->title }}</h2>

<form method="POST" action="{{ route('admin.contracts.update', $contract) }}" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 15px;">
        <label for="title" style="display: block; margin-bottom: 5px; font-weight: bold;">Títol *</label>
        <input type="text" name="title" id="title" value="{{ old('title', $contract->title) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="start_date" style="display: block; margin-bottom: 5px; font-weight: bold;">Data Inici</label>
        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('Y-m-d') : '') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="end_date" style="display: block; margin-bottom: 5px; font-weight: bold;">Data Fi</label>
        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('Y-m-d') : '') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripció</label>
        <textarea name="description" id="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description', $contract->description) }}</textarea>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Guardar</button>
        <a href="{{ route('admin.contracts.show', $contract) }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
