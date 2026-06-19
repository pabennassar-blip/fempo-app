@extends('admin.layout')

@section('title', 'RAs')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Gestió de Resultats d'Aprenentatge (RAs)</h2>
    <div>
        <a href="{{ route('admin.ras.create') }}" class="btn">+ Crear</a>
        <a href="{{ route('admin.ras.import-form') }}" class="btn" style="background: #28a745;">📤 Importar CSV</a>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Codi</th>
            <th>Data Creació</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ras as $ra)
        <tr>
            <td><strong>{{ $ra->name }}</strong></td>
            <td><code>{{ $ra->code ?? '-' }}</code></td>
            <td>{{ $ra->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.ras.show', $ra) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Veure</a>
                <a href="{{ route('admin.ras.edit', $ra) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Editar</a>
                <form method="POST" action="{{ route('admin.ras.destroy', $ra) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
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
    {{ $ras->links() }}
</div>
@endsection
