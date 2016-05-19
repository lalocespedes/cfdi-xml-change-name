<?php

namespace lalocespedes\CfdiMx\properties;

use SimpleXMLElement;

/**
 *
 */
class impuestos
{
    final public static function extract(SimpleXMLElement $xml, array $namespace, $version)
    {
        $data = array();

        $cfdi = $xml->children($namespace['cfdi']);

        if (isset($cfdi->Impuestos)) {
            if (isset($cfdi->Impuestos->attributes()->totalImpuestosTrasladados)) {
                $data['@atributos']['totalImpuestosTrasladados'] = $cfdi->Impuestos->attributes()->totalImpuestosTrasladados;
            }

            if (isset($cfdi->Impuestos->attributes()->totalImpuestosRetenidos)) {
                $data['@atributos']['totalImpuestosRetenidos'] = $cfdi->Impuestos->attributes()->totalImpuestosRetenidos;
            }
        }

        if (isset($cfdi->Impuestos->Traslados)) {
            foreach ($cfdi->Impuestos->Traslados->children($namespace['cfdi']) as $key => $value) {
                $data['Traslados']['Traslado']['@atributos'][] = array(
                    'impuesto' => $value->attributes()->impuesto,
                    'importe'  => $value->attributes()->importe,
                    'tasa'     => $value->attributes()->tasa
                    );
            }
        }

        if (isset($cfdi->Impuestos->Retenciones)) {
            foreach ($cfdi->Impuestos->Retenciones->children($namespace['cfdi']) as $key => $value) {
                $data['Retenciones']['Retencion']['@atributos'][] = array(
                    'impuesto' => $value->attributes()->impuesto,
                    'importe'  => $value->attributes()->importe
                    );
            }
        }

        return (count($data) > 0) ? $data : null;
    }
}
