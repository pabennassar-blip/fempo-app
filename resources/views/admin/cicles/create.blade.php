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

    <div style="margin-bottom: 15px;">
        <label for="familia" style="display: block; margin-bottom: 5px; font-weight: bold;">Familia</label>
        <input type="text" name="familia" id="familia" value="{{ old('familia') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('familia')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="grau" style="display: block; margin-bottom: 5px; font-weight: bold;">Grau</label>
        <input type="text" name="grau" id="grau" value="{{ old('grau') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('grau')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="nivell" style="display: block; margin-bottom: 5px; font-weight: bold;">Nivell</label>
        <input type="text" name="nivell" id="nivell" value="{{ old('nivell') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('nivell')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="estudi" style="display: block; margin-bottom: 5px; font-weight: bold;">Estudi</label>
        <input type="text" name="estudi" id="estudi" value="{{ old('estudi') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('estudi')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Crear</button>
        <a href="{{ route('admin.cicles.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
