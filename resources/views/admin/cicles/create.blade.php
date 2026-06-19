@extends('admin.layout')

@section('title', 'Crear Cicle')

@section('content')
<h2>Crear Cicle</h2>

<form method="POST" action="{{ route('admin.cicles.store') }}" style="max-width: 600px;">
    @csrf

    <div style="margin-bottom: 15px;">
        <label for="nom" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom del Cicle *</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('nom')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="abreviatura" style="display: block; margin-bottom: 5px; font-weight: bold;">Abreviatura</label>
        <input type="text" name="abreviatura" id="abreviatura" value="{{ old('abreviatura') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('abreviatura')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Crear</button>
        <a href="{{ route('admin.cicles.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
