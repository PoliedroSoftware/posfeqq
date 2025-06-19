@extends('layouts.app')
@section('title', __('home.home'))


@section('content')
<div class="container-fluid" style="margin-bottom:20px;">
    
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="mb-4 text-center">Facturación Electrónica (FAC,POS)</h2>
    
<table class="table table-bordered table-striped" id="facturacionTable">
    <thead>
        <tr>
            <th>id</th>
            <th>Dian</th>
            <th>identication</th>
            <th>contact_name</th>
            <th>email</th>
            <th>mobile</th>
            <th>invoice</th>
            <th>payment_status</th>
            <th>transaction_date</th>
            <th>totalToPay</th>
            <th>created_by_name</th>
            <th>Acción</th>
        </tr>
    </thead>
</table>
    

</div>


@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".btn-confirmar").forEach(button => {
            button.addEventListener("click", function() {
                let form = this.closest("form");

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Esta acción enviará la factura a la DIAN y no se podrá revertir.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, emitir",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>


<!-- 🎨 CSS de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<!-- 🚀 jQuery y DataTables -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    let table = $('#facturacionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('facturacion.data') }}",
        columns: [
            { data: 'id' },
            { data: 'send_dian', render: function(data) { return data == 0 ? 'Sin Emitir' : 'Emitida'; }},
            { data: 'identication' },
            { data: 'contact_name' },
            { data: 'email' },
            { data: 'mobile' },
            { data: 'invoice' },
            { data: 'payment_status' },
            { data: 'transaction_date' },
            { data: 'totalToPay' },
            { data: 'created_by_name' },
            { data: 'accion', orderable: false, searchable: false }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Usar delegación de eventos para los botones dinámicos
    $(document).on("click", ".btn-confirmar", function() {
        let id = $(this).data("id");

        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción enviará la factura a la DIAN y no se podrá revertir.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, emitir",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('facturacion/enviar') }}/" + id,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire("¡Éxito!", "Factura enviada correctamente.", "success");
                        table.ajax.reload(); // Recargar la tabla después de emitir la factura
                    },
                    error: function() {
                        Swal.fire("Error", "No se pudo enviar la factura.", "error");
                    }
                });
            }
        });
    });
});

</script>



