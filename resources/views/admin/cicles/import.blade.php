@extends('admin.layout')

@section('title', 'Importar Cicles')

@section('content')
<h2>📤 Importar Cicles des de CSV</h2>

<div style="background: #eef; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #336;">
    <p><strong>Format CSV requerit:</strong></p>
    <p style="font-family: monospace; margin: 10px 0;">Nom</p>
    <p style="font-size: 0.9em; color: #555;">Exemple:<br>
    <code>"DAM"</code><br>
    <code>"DAW"</code><br>
    <code>"ASIX"</code></p>
</div>

<form method="POST" action="{{ route('admin.cicles.import') }}" enctype="multipart/form-data" style="max-width: 600px;">
    @csrf

    <div style="margin-bottom: 20px;">
        <label for="file" style="display: block; margin-bottom: 10px; font-weight: bold;">Selecciona arxiu CSV</label>
        <input type="file" name="file" id="file" accept=".csv,.txt" required style="width: 100%; padding: 10px; border: 2px dashed #667eea; border-radius: 4px; background: #f9f9f9;">
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn" style="background: #28a745;">Importar</button>
        <a href="{{ route('admin.cicles.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>

<hr style="margin: 30px 0;">

<h3>Cicles actuals</h3>
<p>Total: <strong>{{ \App\Models\Cicle::count() }}</strong> cicles</p>
@endsection
