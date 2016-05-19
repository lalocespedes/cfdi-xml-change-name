<?php

namespace lalocespedes\CfdiMx\properties;

use SimpleXMLElement;

/**
 *
 */
class receptor
{
    final public static function extract(SimpleXMLElement $xml, array $namespace, $version)
    {
        $cfdi = $xml->children($namespace['cfdi']);

        $data = array(
            '@atributos' => array(
                'nombre' => $cfdi->Receptor->attributes()->nombre,
                'rfc'    => $cfdi->Receptor->attributes()->rfc
                )
            );

        if (isset($cfdi->Receptor->Domicilio)) {
            $data['DomicilioFiscal']['@atributos'] = array(
                'calle'        => $cfdi->Receptor->Domicilio->attributes()->calle,
                'codigoPostal' => $cfdi->Receptor->Domicilio->attributes()->codigoPostal,
                'colonia'      => $cfdi->Receptor->Domicilio->attributes()->colonia,
                'localidad'      => $cfdi->Receptor->Domicilio->attributes()->localidad,
                'estado'       => $cfdi->Receptor->Domicilio->attributes()->estado,
                'municipio'    => $cfdi->Receptor->Domicilio->attributes()->municipio,
                'noExterior'   => $cfdi->Receptor->Domicilio->attributes()->noExterior,
                'noInterior'   => $cfdi->Receptor->Domicilio->attributes()->noInterior,
                'pais'         => $cfdi->Receptor->Domicilio->attributes()->pais
                );
        }

        return (count($data) > 0) ? $data : null;
    }
}
