@extends('admin.layout')

@section('title', 'Usuaris')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Gestió d'Usuaris</h2>
    <div>
        <a href="{{ route('admin.users.create') }}" class="btn">+ Afegir Usuari</a>
        <a href="{{ route('admin.users.import-form') }}" class="btn" style="background: #28a745;">📤 Importar CSV</a>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Data Creació</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if ($user->professor)
                    <span style="background: #e7f3ff; padding: 4px 8px; border-radius: 4px; color: #0066cc;">Professor</span>
                @elseif ($user->alumne)
                    <span style="background: #fff3e0; padding: 4px 8px; border-radius: 4px; color: #cc6600;">Alumne</span>
                @elseif ($user->empresari)
                    <span style="background: #f0e7ff; padding: 4px 8px; border-radius: 4px; color: #6600cc;">Empresari</span>
                @else
                    <span style="background: #e0e0e0; padding: 4px 8px; border-radius: 4px;">Admin</span>
                @endif
            </td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.users.show', $user) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Veure</a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Editar</a>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;" onsubmit="return confirm('Segur que vols eliminar aquest usuari?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.9em;">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px; display: flex; justify-content: center; gap: 10px;">
    {{ $users->links() }}
</div>

@if ($users->isEmpty())
<p style="text-align: center; margin-top: 20px; color: #999;">No hi ha usuaris.</p>
@endif
@endsection
