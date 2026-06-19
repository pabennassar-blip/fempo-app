@extends('admin.layout')

@section('title', 'Editar Mòdul')

@section('content')
<h2>Editar Mòdul</h2>

<form method="POST" action="{{ route('admin.moduls.update', $modul) }}" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 15px;">
        <label for="nom" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom del Mòdul *</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $modul->nom) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('nom')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="abreviatura" style="display: block; margin-bottom: 5px; font-weight: bold;">Abreviatura</label>
        <input type="text" name="abreviatura" id="abreviatura" value="{{ old('abreviatura', $modul->abreviatura) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('abreviatura')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Actualitzar</button>
        <a href="{{ route('admin.moduls.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
