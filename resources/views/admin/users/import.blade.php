@extends('admin.layout')

@section('title', 'Importar Usuaris')

@section('content')
<h2>📤 Importar Usuaris des de CSV</h2>

<div style="background: #eef; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #336;">
    <p><strong>Format CSV requerit:</strong></p>
    <p style="font-family: monospace; margin: 10px 0;">Nom,Email,Contrasenya,Rol (professor/tutor/alumne/empresari)</p>
    <p style="font-size: 0.9em; color: #555;">Exemple:<br>
    <code>"Maria García","maria@example.com","password123","professor"</code><br>
    <code>"Joan Martí","joan@example.com","password123","tutor"</code><br>
    <code>"Juan López","juan@example.com","password123","alumne"</code></p>
    <p style="margin-top: 10px; font-size: 0.9em; color: #666;">
        <strong>Notes:</strong>
        <ul style="margin: 5px 0 0 20px;">
            <li>La contrasenya és opcional (per defecte: password123)</li>
            <li>El rol és opcional (per defecte: professor)</li>
            <li>Rols permesos: professor, tutor, alumne, empresari</li>
            <li>Si l'email ja existeix, s'actualitza l'usuari</li>
        </ul>
    </p>
</div>

<form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" style="max-width: 600px;">
    @csrf

    <div style="margin-bottom: 20px;">
        <label for="file" style="display: block; margin-bottom: 10px; font-weight: bold;">Selecciona arxiu CSV</label>
        <input type="file" name="file" id="file" accept=".csv,.txt" required style="width: 100%; padding: 10px; border: 2px dashed #667eea; border-radius: 4px; background: #f9f9f9;">
        @error('file')<span style="color: #dc3545;">{{ $message }}</span>@enderror
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn" style="background: #28a745;">Importar</button>
        <a href="{{ route('admin.users.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>

<hr style="margin: 30px 0;">

<h3>Usuaris actuals</h3>
<p>Total: <strong>{{ \App\Models\User::count() }}</strong> usuaris</p>
@endsection
