@extends('admin.layout')

@section('title', 'Editar RA')

@section('content')
<h2>Editar RA: {{ $ra->name }}</h2>

<form method="POST" action="{{ route('admin.ras.update', $ra) }}" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 15px;">
        <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom RA *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $ra->name) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="code" style="display: block; margin-bottom: 5px; font-weight: bold;">Codi</label>
        <input type="text" name="code" id="code" value="{{ old('code', $ra->code) }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripció</label>
        <textarea name="description" id="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description', $ra->description) }}</textarea>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Guardar</button>
        <a href="{{ route('admin.ras.show', $ra) }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
