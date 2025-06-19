<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\facturacionElectronicaReportes;


class facturacionElectronicaReportesController extends Controller
{
    public function index() {
        
        $baseUrl = env('URL_SEARCH_DIAN'); // Obtiene la URL desde .env
    
     // Eager Loading para optimizar la consulta
        $facturasReportes = facturacionElectronicaReportes::with('client')->get();
        
        
        // Concatenar la URL con el cufe
    foreach ($facturasReportes as $factura) {
        $factura->Urlcude = $baseUrl . $factura->cude;
    }
        

    return view('facturacionReportes', compact('facturasReportes'));
}







}
