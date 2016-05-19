<?php

namespace lalocespedes\CfdiMx\properties;

use SimpleXMLElement;

/**
 *
 */
class conceptos
{
    final public static function extract(SimpleXMLElement $xml, array $namespace, $version)
    {
        $cfdi = $xml->children($namespace['cfdi']);

        $data = array();

        foreach ($cfdi->Conceptos->children($namespace['cfdi']) as $key => $value) {
            $data['Concepto']['@atributos'][] = array(
                'cantidad'          => $value->attributes()->cantidad,
                'noIdentificacion'  => $value->attributes()->noIdentificacion,
                'descripcion'       => $value->attributes()->descripcion,
                'importe'           => $value->attributes()->importe,
                'unidad'            => $value->attributes()->unidad,
                'valorUnitario'     => $value->attributes()->valorUnitario,
                );

            if (isset($value->CuentaPredial)) {
                $data['Concepto']['@atributos'][count($data['Concepto']['@atributos'])-1]['CuentaPredial']['@atributos'] = array(
                    'numero' => $value->CuentaPredial->attributes()->numero
                    );
            }
        }

        return (count($data) > 0) ? $data : null;
    }
}
