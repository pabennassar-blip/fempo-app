@extends('admin.layout')

@section('title', 'Crear RA')

@section('content')
<h2>Crear RA</h2>

<form method="POST" action="{{ route('admin.ras.store') }}" style="max-width: 600px;">
    @csrf

    <div style="margin-bottom: 15px;">
        <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom RA *</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="code" style="display: block; margin-bottom: 5px; font-weight: bold;">Codi</label>
        <input type="text" name="code" id="code" value="{{ old('code') }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripció</label>
        <textarea name="description" id="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description') }}</textarea>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Crear</button>
        <a href="{{ route('admin.ras.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
