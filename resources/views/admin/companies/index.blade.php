@extends('admin.layout')

@section('title', 'Empreses')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Gestió d'Empreses</h2>
    <div>
        <a href="{{ route('admin.companies.create') }}" class="btn">+ Crear</a>
        <a href="{{ route('admin.companies.import-form') }}" class="btn" style="background: #28a745;">📤 Importar CSV</a>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Ubicació</th>
            <th>Telèfon</th>
            <th>Data Creació</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($companies as $company)
        <tr>
            <td><strong>{{ $company->title }}</strong></td>
            <td>{{ $company->location ?? 'N/A' }}</td>
            <td>{{ $company->telefon ?? 'N/A' }}</td>
            <td>{{ $company->created_at->format('d/m/Y') }}</td>
            <td>
                <a href="{{ route('admin.companies.show', $company) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Veure</a>
                <a href="{{ route('admin.companies.edit', $company) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Editar</a>
                <form method="POST" action="{{ route('admin.companies.destroy', $company) }}" style="display: inline;" onsubmit="return confirm('Segur?');">
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
    {{ $companies->links() }}
</div>
@endsection
