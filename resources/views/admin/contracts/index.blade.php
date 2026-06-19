@extends('admin.layout')

@section('title', 'Contractes')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Gestió de Contractes</h2>
    <div>
        <a href="{{ route('admin.contracts.create') }}" class="btn">+ Crear</a>
        <a href="{{ route('admin.contracts.import-form') }}" class="btn" style="background: #28a745;">📤 Importar CSV</a>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Títol</th>
            <th>Data Inici</th>
            <th>Data Fi</th>
            <th>Data Creació</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($contracts as $contract)
        <tr>
            <td><strong>{{ $contract->title }}</strong></td>
            <td>{{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d/m/Y') : 'N/A' }}</td>
            <td>{{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d/m/Y') : 'N/A' }}</td>
            <td>{{ $contract->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.contracts.show', $contract) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Veure</a>
                <a href="{{ route('admin.contracts.edit', $contract) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Editar</a>
                <form method="POST" action="{{ route('admin.contracts.destroy', $contract) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
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
    {{ $contracts->links() }}
</div>
@endsection
