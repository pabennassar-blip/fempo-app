@extends('admin.layout')

@section('title', 'Editar Usuari')

@section('content')
<h2>Editar Usuari: {{ $user->name }}</h2>

<form method="POST" action="{{ route('admin.users.update', $user) }}" style="max-width: 500px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom: 15px;">
        <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('name')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px;">
        <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        @error('email')<span style="color: #dc3545; font-size: 0.9em;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-bottom: 15px; padding: 15px; background: #f9f9f9; border-radius: 4px;">
        <p style="margin: 0; color: #666; font-size: 0.9em;">
            <strong>Rol actual:</strong>
            @if ($user->professor)
                <span style="background: #e7f3ff; padding: 2px 6px; border-radius: 3px; color: #0066cc;">Professor</span>
            @elseif ($user->alumne)
                <span style="background: #fff3e0; padding: 2px 6px; border-radius: 3px; color: #cc6600;">Alumne</span>
            @elseif ($user->empresari)
                <span style="background: #f0e7ff; padding: 2px 6px; border-radius: 3px; color: #6600cc;">Empresari</span>
            @else
                <span style="background: #e0e0e0; padding: 2px 6px; border-radius: 3px;">Admin</span>
            @endif
        </p>
        <p style="margin: 8px 0 0 0; color: #999; font-size: 0.85em;">
            Per canviar el rol, elimina l'usuari i crea'l de nou amb el nou rol.
        </p>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn">Guardar Canvis</button>
        <a href="{{ route('admin.users.show', $user) }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>
@endsection
