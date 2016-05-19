<?php

namespace lalocespedes\CfdiMx\properties;

use SimpleXMLElement;
use Exception;


/**
 *
 */
class emisor
{
    final public static function extract(SimpleXMLElement $xml, array $namespace, $version)
    {
        $cfdi = $xml->children($namespace['cfdi']);

        $data = array(
            '@atributos' => array(
                'nombre' => $cfdi->Emisor->attributes()->nombre,
                'rfc'    => $cfdi->Emisor->attributes()->rfc
                )
            );

        if (isset($cfdi->Emisor->DomicilioFiscal)) {
            $data['DomicilioFiscal']['@atributos'] = array(
                'calle'        => $cfdi->Emisor->DomicilioFiscal->attributes()->calle,
                'codigoPostal' => $cfdi->Emisor->DomicilioFiscal->attributes()->codigoPostal,
                'colonia'      => $cfdi->Emisor->DomicilioFiscal->attributes()->colonia,
                'estado'       => $cfdi->Emisor->DomicilioFiscal->attributes()->estado,
                'municipio'    => $cfdi->Emisor->DomicilioFiscal->attributes()->municipio,
                'localidad'    => $cfdi->Emisor->DomicilioFiscal->attributes()->localidad,
                'noExterior'   => $cfdi->Emisor->DomicilioFiscal->attributes()->noExterior,
                'noInterior'   => $cfdi->Emisor->DomicilioFiscal->attributes()->noInterior,
                'pais'         => $cfdi->Emisor->DomicilioFiscal->attributes()->pais
                );
        }

        if (isset($cfdi->Emisor->ExpedidoEn)) {
            $data['ExpedidoEn']['@atributos'] = array(
                'calle'        => $cfdi->Emisor->ExpedidoEn->attributes()->calle,
                'codigoPostal' => $cfdi->Emisor->ExpedidoEn->attributes()->codigoPostal,
                'colonia'      => $cfdi->Emisor->ExpedidoEn->attributes()->colonia,
                'estado'       => $cfdi->Emisor->ExpedidoEn->attributes()->estado,
                'municipio'    => $cfdi->Emisor->ExpedidoEn->attributes()->municipio,
                'noExterior'   => $cfdi->Emisor->ExpedidoEn->attributes()->noExterior,
                'pais'         => $cfdi->Emisor->ExpedidoEn->attributes()->pais
                );
        }

        if (isset($cfdi->Emisor->RegimenFiscal)) {
            $data['RegimenFiscal']['@atributos'] = array(
                'Regimen' => $cfdi->Emisor->RegimenFiscal->attributes()->Regimen
                );
        }

        return (count($data) > 0) ? $data : null;
    }
}
