@extends('admin.layout')

@section('title', 'Editar Empresa')

@section('content')
<h2>Editar Empresa: {{ $empresa->title }}</h2>

<form method="POST" action="{{ route('admin.companies.update', $empresa) }}" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 15px;">
        <label for="title" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom Empresa *</label>
        <input type="text" name="title" id="title" value="{{ old('title', $empresa->title) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('title')<span style="color: #dc3545;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripció</label>
        <textarea name="description" id="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description', $empresa->description) }}</textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="location" style="display: block; margin-bottom: 5px; font-weight: bold;">Ubicació</label>
        <input type="text" name="location" id="location" value="{{ old('location', $empresa->location) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="telefon" style="display: block; margin-bottom: 5px; font-weight: bold;">Telèfon</label>
        <input type="text" name="telefon" id="telefon" value="{{ old('telefon', $empresa->telefon) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Guardar</button>
        <a href="{{ route('admin.companies.show', $empresa) }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
