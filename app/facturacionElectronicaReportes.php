<?php

namespace App;

use App\ClientesFacturacionElectronica;

use Illuminate\Database\Eloquent\Model;


class facturacionElectronicaReportes extends Model
{
   

    // Nombre de la tabla
    protected $table = 'invoice_success';

    protected $guarded = [];
    
    // Relación con el modelo Client
    public function client()
    {
        return $this->belongsTo(ClientesFacturacionElectronica::class, 'client_id');
    }
}
