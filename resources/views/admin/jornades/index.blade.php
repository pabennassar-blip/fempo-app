@extends('admin.layout')

@section('title', 'Jornades')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Gestió de Jornades</h2>
    <div>
        <a href="{{ route('admin.jornades.create') }}" class="btn">+ Crear</a>
        <a href="{{ route('admin.jornades.import-form') }}" class="btn" style="background: #28a745;">📤 Importar CSV</a>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Títol</th>
            <th>Data</th>
            <th>Hores</th>
            <th>Data Creació</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jornades as $jornada)
        <tr>
            <td><strong>{{ $jornada->title }}</strong></td>
            <td>{{ $jornada->date ? \Carbon\Carbon::parse($jornada->date)->format('d/m/Y') : 'N/A' }}</td>
            <td>{{ $jornada->hours ?? '-' }}</td>
            <td>{{ $jornada->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.jornades.show', $jornada) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Veure</a>
                <a href="{{ route('admin.jornades.edit', $jornada) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Editar</a>
                <form method="POST" action="{{ route('admin.jornades.destroy', $jornada) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
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
    {{ $jornades->links() }}
</div>
@endsection
