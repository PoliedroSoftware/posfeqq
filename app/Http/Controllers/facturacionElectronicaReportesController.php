<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\facturacionElectronicaReportes;


class facturacionElectronicaReportesController extends Controller
{
    public function index()
    {

        $baseUrl = env('URL_SEARCH_DIAN'); // Obtiene la URL desde .env
        $UrlBilling = env('URL_BILLING_API');
        // Eager Loading para optimizar la consulta

        // Consulta optimizada con orderBy
        $facturasReportes = facturacionElectronicaReportes::orderBy('invoice', 'desc')->get();


        // Concatenar la URL con el cufe
        foreach ($facturasReportes as $factura) {
            $factura->Urlcude = $baseUrl . $factura->cude;
            $factura->UrlPlemsi = $UrlBilling . $factura->cude;
        }


        return view('facturacionReportes', compact('facturasReportes'));
    }

    public function descargarPdf($cude)
    {
        $client = new Client();

        $url = env('URL_BILLING_API') . $cude;

        try {
            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('BILLING_API_TOKEN'),
                    'X-Environment' => env('X_Environment'),
                    'Accept' => 'application/pdf',
                ],
            ]);

            $pdfContent = $response->getBody();

            // Mostrar el PDF en el navegador
            return Response::make($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="factura_' . $cude . '.pdf"',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error descargando el PDF: ' . $e->getMessage());
        }
    }
}
