@extends('layouts.app')
@section('title', __('home.home'))




@section('content')
<div class="container-fluid">
    <h2 class="text-center mb-4">📄 Reportes de Facturación Electrónica</h2>
    <div class="table-responsive">
        <table id="facturasTable" class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Factura</th>
                    <th>Fecha de Registro</th>
                    <th>CUFE</th>
                   <!-- <th>QR</th>-->
                    <th>Cliente ID</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($facturasReportes as $factura)
                    <tr>
                        <td>{{ $factura->id }}</td>
                        <td>{{ $factura->invoice }}</td>
                        <td>{{ $factura->dateregister }}</td>
                        <td>{{ $factura->cude }}</td>
                        <!--<td>{{ $factura->qrCode }}</td>-->
                        <td>{{ $factura->client ? $factura->client->name : 'No disponible' }}</td>
                            <td>
                            <a class="btn btn-info" href="{{ $factura->Urlcude }}" target="_blank">
                                <i class="fa fa-mouse-pointer" aria-hidden="true"></i> Web
                            </a>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection


<!-- DataTables CSS & JS desde CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#facturasTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50],
            "order": [[ 0, "desc" ]]
        });
    });
</script>


