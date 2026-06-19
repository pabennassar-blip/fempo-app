@extends('admin.layout')

@section('title', $user->name)

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>{{ $user->name }}</h2>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn">Editar</a>
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;" onsubmit="return confirm('Segur que vols eliminar aquest usuari?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <div style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
        <h4 style="color: #667eea; margin-bottom: 15px;">📋 Informació</h4>
        <p><strong>Nom:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Data Creació:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Última Actualització:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
        <h4 style="color: #667eea; margin-bottom: 15px;">🎓 Rol</h4>
        @if ($user->professor)
            <p style="background: #e7f3ff; padding: 10px; border-radius: 4px; color: #0066cc;">
                <strong>Professor</strong>
            </p>
        @elseif ($user->tutor)
            <p style="background: #e0f7ff; padding: 10px; border-radius: 4px; color: #0088cc;">
                <strong>Tutor</strong>
            </p>
        @elseif ($user->alumne)
            <p style="background: #fff3e0; padding: 10px; border-radius: 4px; color: #cc6600;">
                <strong>Alumne</strong>
            </p>
        @elseif ($user->empresari)
            <p style="background: #f0e7ff; padding: 10px; border-radius: 4px; color: #6600cc;">
                <strong>Empresari</strong>
            </p>
        @else
            <p style="background: #e0e0e0; padding: 10px; border-radius: 4px;">
                <strong>Administrador</strong>
            </p>
        @endif
    </div>
</div>

@if ($user->contracts && count($user->contracts) > 0)
<div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <h4 style="color: #667eea; margin-bottom: 15px;">📑 Contractes</h4>
    <table style="width: 100%;">
        <thead>
            <tr>
                <th style="text-align: left; padding-bottom: 10px;">Contracte</th>
                <th style="text-align: left; padding-bottom: 10px;">Data Inici</th>
                <th style="text-align: left; padding-bottom: 10px;">Data Fi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->contracts as $contract)
            <tr style="border-bottom: 1px solid #e0e0e0;">
                <td style="padding: 10px 0;">{{ $contract->title ?? 'Sin títol' }}</td>
                <td style="padding: 10px 0;">{{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') : 'N/A' }}</td>
                <td style="padding: 10px 0;">{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<div style="margin-top: 20px;">
    <a href="{{ route('admin.users.index') }}" class="btn" style="background: #999;">← Tornar a Usuaris</a>
</div>
@endsection
