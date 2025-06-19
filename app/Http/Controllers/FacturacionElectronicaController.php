<?php

namespace App\Http\Controllers;

use App\FacturacionTransactions;
use App\FacturacionElectronica;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;

class FacturacionElectronicaController extends Controller
{
    public function index()
{
    return view('facturacion');
}

    
    
    public function getFacturas(Request $request) {
    if ($request->ajax()) {
        $facturas = FacturacionElectronica::select(['id', 'send_dian', 'identication', 'contact_name', 'email', 'mobile', 'invoice', 'payment_status', 'transaction_date', 'totalToPay', 'created_by_name']);
        
        return DataTables::of($facturas)
            ->addColumn('accion', function ($factura) {
                if ($factura->send_dian == 0) {
                    return '<button class="btn btn-primary btn-confirmar" data-id="'.$factura->id.'">Emitir</button>';
                } else {
                    return 'Emitida';
                }
            })
            ->rawColumns(['accion'])
            ->make(true);
    }
}
    
    
     public function enviarDian($id)
        {
            
            $transaccion = FacturacionTransactions::find($id);
    
            if (!$transaccion) {
                return redirect()->route('facturacion')->with('error', 'Transacción no encontrada.');
            }
    
            // Actualizar el campo send_dian
            $transaccion->send_dian = 1;
            $transaccion->transaction_date = now();
            $transaccion->save();
    
            return redirect()->route('facturacion')->with('success', 'Factura enviada correctamente.');
        }



}
