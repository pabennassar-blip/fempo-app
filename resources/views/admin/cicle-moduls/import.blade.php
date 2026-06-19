@extends('admin.layout')

@section('title', 'Importar Relacions Cicle-Mòdul')

@section('content')
<h2>📤 Importar Relacions Cicle-Mòdul des de CSV</h2>

<div style="background: #eef; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #336;">
    <p><strong>Format CSV requerit:</strong></p>
    <p style="font-family: monospace; margin: 10px 0;">Abreviatura Cicle,Nom Mòdul</p>
    <p style="font-size: 0.9em; color: #555;">Exemple:<br>
    <code>"DAM","Bases de Dades"</code><br>
    <code>"DAM","Programació"</code><br>
    <code>"DAW","Programació Web"</code></p>
    <p style="font-size: 0.85em; color: #666; margin-top: 10px;"><strong>⚠️ Important:</strong> Si el cicle o el mòdul no existeix, es demanarà confirmació per crear-lo.</p>
</div>

<form method="POST" action="{{ route('admin.cicle-moduls.import') }}" enctype="multipart/form-data" style="max-width: 600px;">
    @csrf

    <div style="margin-bottom: 20px;">
        <label for="file" style="display: block; margin-bottom: 10px; font-weight: bold;">Selecciona arxiu CSV</label>
        <input type="file" name="file" id="file" accept=".csv,.txt" required style="width: 100%; padding: 10px; border: 2px dashed #667eea; border-radius: 4px; background: #f9f9f9;">
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" class="btn" style="background: #28a745;">Importar</button>
        <a href="{{ route('admin.cicle-moduls.index') }}" class="btn" style="background: #999; margin-left: 10px;">Cancelar</a>
    </div>
</form>

<hr style="margin: 30px 0;">

<h3>Relacions Actuals</h3>
<p>Total de cicles: <strong>{{ \App\Models\Cicle::count() }}</strong></p>
<p>Total de mòduls: <strong>{{ \App\Models\Modul::count() }}</strong></p>
<p>Total de relacions: <strong>{{ \DB::table('cicle_modul')->count() }}</strong></p>
@endsection
