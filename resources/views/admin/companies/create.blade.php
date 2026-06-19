@extends('admin.layout')

@section('title', 'Crear Empresa')

@section('content')
<h2>Crear Empresa</h2>

<form method="POST" action="{{ route('admin.companies.store') }}" style="max-width: 600px;">
    @csrf

    <div style="margin-bottom: 15px;">
        <label for="title" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom Empresa *</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('title')<span style="color: #dc3545;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripció</label>
        <textarea name="description" id="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description') }}</textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="location" style="display: block; margin-bottom: 5px; font-weight: bold;">Ubicació</label>
        <input type="text" name="location" id="location" value="{{ old('location') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="telefon" style="display: block; margin-bottom: 5px; font-weight: bold;">Telèfon</label>
        <input type="text" name="telefon" id="telefon" value="{{ old('telefon') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Crear</button>
        <a href="{{ route('admin.companies.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
