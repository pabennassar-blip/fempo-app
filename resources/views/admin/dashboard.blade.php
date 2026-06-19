@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<h2>Dashboard</h2>

<div class="stats">
    <div class="stat-card">
        <p>Total Usuaris</p>
        <h3>{{ $stats['total_users'] }}</h3>
    </div>
    <div class="stat-card">
        <p>Professors</p>
        <h3>{{ $stats['total_professors'] }}</h3>
    </div>
    <div class="stat-card">
        <p>Alumnes</p>
        <h3>{{ $stats['total_students'] }}</h3>
    </div>
    <div class="stat-card">
        <p>Empresaris</p>
        <h3>{{ $stats['total_business_owners'] }}</h3>
    </div>
    <div class="stat-card">
        <p>Empreses</p>
        <h3>{{ $stats['total_companies'] }}</h3>
    </div>
    <div class="stat-card">
        <p>Jornades</p>
        <h3>{{ $stats['total_attendance_records'] }}</h3>
    </div>
</div>

<hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">

<h3 style="margin-top: 30px; margin-bottom: 15px;">Últims Usuaris</h3>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Data</th>
            <th>Accions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recent_users as $user)
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
                    <span style="background: #e0e0e0; padding: 4px 8px; border-radius: 4px;">Sin rol</span>
                @endif
            </td>
            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.users.show', $user) }}" class="btn" style="padding: 6px 12px; font-size: 0.9em;">Veure</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<h3 style="margin-top: 30px; margin-bottom: 15px;">Últimes Empreses</h3>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Ubicació</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($recent_companies as $company)
        <tr>
            <td>{{ $company->title }}</td>
            <td>{{ $company->location ?? 'N/A' }}</td>
            <td>{{ $company->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
    <h4>🔐 Accés Admin</h4>
    <p>Estàs connectat com a <strong>administrador</strong> del sistema FEMPO.</p>
    <p>Pots gestionar usuaris, empreses, RAs, asistència i més des del menú superior.</p>
</div>
@endsection
