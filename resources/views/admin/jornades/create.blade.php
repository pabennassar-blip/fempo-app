@extends('admin.layout')

@section('title', 'Crear Jornada')

@section('content')
<h2>Crear Jornada</h2>

<form method="POST" action="{{ route('admin.jornades.store') }}" style="max-width: 600px;">
    @csrf

    <div style="margin-bottom: 15px;">
        <label for="title" style="display: block; margin-bottom: 5px; font-weight: bold;">Títol *</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="date" style="display: block; margin-bottom: 5px; font-weight: bold;">Data</label>
        <input type="date" name="date" id="date" value="{{ old('date') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="hours" style="display: block; margin-bottom: 5px; font-weight: bold;">Hores</label>
        <input type="number" name="hours" id="hours" value="{{ old('hours') }}" step="0.5" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripció</label>
        <textarea name="description" id="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description') }}</textarea>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Crear</button>
        <a href="{{ route('admin.jornades.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
