@extends('admin.layout')

@section('title', 'Crear Usuari')

@section('content')
<h2>Crear Nounou Usuari</h2>

<form method="POST" action="{{ route('admin.users.store') }}" style="max-width: 500px;">
    @csrf

    <div style="margin-bottom: 15px;">
        <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('name')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('email')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Contrasenya</label>
        <input type="password" name="password" id="password" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('password')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="password_confirmation" style="display: block; margin-bottom: 5px; font-weight: bold;">Confirmar Contrasenya</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="role" style="display: block; margin-bottom: 5px; font-weight: bold;">Rol</label>
        <select name="role" id="role" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            <option value="">Selecciona un rol</option>
            <option value="professor">Professor</option>
            <option value="alumne">Alumne</option>
            <option value="empresari">Empresari</option>
        </select>
        @error('role')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Crear Usuari</button>
        <a href="{{ route('admin.users.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
