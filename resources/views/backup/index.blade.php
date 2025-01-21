@extends('layouts.app')

@section('titulo', 'Backup de Datos')

@section('css')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
@endsection

@section('content')
<div class="page-heading card" style="box-shadow: none !important">
    <div class="page-title card-body">
        <div class="row justify-content-between">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3><i class="bi bi-archive"></i> Backup de Datos</h3>
                <p class="text-subtitle text-muted">Programa y descarga backups de la base de datos.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Backup de Datos</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section pt-4">
        <div class="card">
            <div class="card-body">
                <form action="" method="">
                    @csrf
                    <div class="mb-3">
                        <label for="backupFrequency" class="form-label">Frecuencia del Backup</label>
                        <select class="form-select" id="backupFrequency" name="frequency">
                            <option value="daily">Diario</option>
                            <option value="weekly">Semanal</option>
                            <option value="monthly">Mensual</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Programar Backup</button>
                </form>

                <div class="mt-4">
                    <h4>Descargar Backup</h4>
                    <a href="#" class="btn btn-secondary">Descargar Backup</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
@endsection
