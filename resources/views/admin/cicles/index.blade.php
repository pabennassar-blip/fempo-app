@extends('admin.layout')

@section('title', 'Cicles')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Gestió de Cicles</h2>
    <div>
        <a href="{{ route('admin.cicles.create') }}" class="btn">+ Crear</a>
        <a href="{{ route('admin.cicles.import-form') }}" class="btn" style="background: #28a745;">📤 Importar CSV</a>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Data Creació</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cicles as $cicle)
        <tr>
            <td><strong>{{ $cicle->nom }}</strong></td>
            <td>{{ $cicle->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.cicles.show', $cicle) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Veure</a>
                <a href="{{ route('admin.cicles.edit', $cicle) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Editar</a>
                <form method="POST" action="{{ route('admin.cicles.destroy', $cicle) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.9em;">X</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $cicles->links() }}
</div>
@endsection
