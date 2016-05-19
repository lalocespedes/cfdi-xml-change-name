<?php

namespace lalocespedes\CfdiMx\properties;

use SimpleXMLElement;

/**
 *
 */
class complemento
{
    final public static function extract(SimpleXMLElement $xml, array $namespace, $version)
    {
        $data = array();
        $cfdi = $xml->children($namespace['cfdi']);

        // Donativos
        if (isset($namespace['donat'])) {
            $dna = $cfdi->Complemento->children($namespace['donat']);

            if (isset($dna->Donatarias)) {
                $data['Donatarias']['@atributos'] = array(
                    'noAutorizacion'    => $dna->Donatarias->attributes()->noAutorizacion,
                    'fechaAutorizacion' => $dna->Donatarias->attributes()->fechaAutorizacion,
                    'leyenda'           => $dna->Donatarias->attributes()->leyenda,
                    'version'           => $dna->Donatarias->attributes()->version
                    );
            }
        }

        // Impuesto local
        if (isset($namespace['implocal'])) {
            $imp = $cfdi->Complemento->children($namespace['implocal']);

            if (isset($imp->ImpuestosLocales)) {
                $data['ImpuestosLocales']['@atributos'] = array(
                    'TotaldeRetenciones' => $imp->ImpuestosLocales->attributes()->TotaldeRetenciones,
                    'TotaldeTraslados'   => $imp->ImpuestosLocales->attributes()->TotaldeTraslados,
                    'Version'            => $imp->ImpuestosLocales->attributes()->Version,
                    );
            }

            if (isset($imp->ImpuestosLocales->RetencionesLocales)) {
                $data['ImpuestosLocales']['RetencionesLocales']['@atributos'] = array(
                    'ImpLocRetenido'  => $imp->ImpuestosLocales->RetencionesLocales->attributes()->ImpLocRetenido,
                    'TasadeRetencion' => $imp->ImpuestosLocales->RetencionesLocales->attributes()->TasadeRetencion,
                    'Importe'         => $imp->ImpuestosLocales->RetencionesLocales->attributes()->Importe,
                    );
            }

            if (isset($imp->ImpuestosLocales->TrasladosLocales)) {
                $data['ImpuestosLocales']['TrasladosLocales']['@atributos'] = array(
                    'ImpLocTrasladado' => $imp->ImpuestosLocales->TrasladosLocales->attributes()->ImpLocTrasladado,
                    'TasadeTraslado'   => $imp->ImpuestosLocales->TrasladosLocales->attributes()->TasadeTraslado,
                    'Importe'          => $imp->ImpuestosLocales->TrasladosLocales->attributes()->Importe,
                    );
            }
        }

        // Nomina
        if (isset($namespace['nomina'])) {
            $nomina = array();

            $nmd = $cfdi->Complemento->children($namespace['nomina']);

            // Atributos
            if (isset($nmd->Nomina)) {
                $data['Nomina']['@atributos'] = array(
                    'Antiguedad'             => $nmd->Nomina->attributes()->Antiguedad,
                    'Banco'                  => $nmd->Nomina->attributes()->Banco,
                    'CURP'                   => $nmd->Nomina->attributes()->CURP,
                    'CLABE'                  => $nmd->Nomina->attributes()->CLABE,
                    'Departamento'           => $nmd->Nomina->attributes()->Departamento,
                    'FechaPago'              => $nmd->Nomina->attributes()->FechaPago,
                    'FechaInicialPago'       => $nmd->Nomina->attributes()->FechaInicialPago,
                    'FechaFinalPago'         => $nmd->Nomina->attributes()->FechaFinalPago,
                    'FechaInicioRelLaboral'  => $nmd->Nomina->attributes()->FechaInicioRelLaboral,
                    'NumDiasPagados'         => $nmd->Nomina->attributes()->NumDiasPagados,
                    'NumEmpleado'            => $nmd->Nomina->attributes()->NumEmpleado,
                    'NumSeguridadSocial'     => $nmd->Nomina->attributes()->NumSeguridadSocial,
                    'PeriodicidadPago'       => $nmd->Nomina->attributes()->PeriodicidadPago,
                    'Puesto'                 => $nmd->Nomina->attributes()->Puesto,
                    'RegistroPatronal'       => $nmd->Nomina->attributes()->RegistroPatronal,
                    'RiesgoPuesto'           => $nmd->Nomina->attributes()->RiesgoPuesto,
                    'SalarioBaseCotApor'     => $nmd->Nomina->attributes()->SalarioBaseCotApor,
                    'SalarioDiarioIntegrado' => $nmd->Nomina->attributes()->SalarioDiarioIntegrado,
                    'TipoContrato'           => $nmd->Nomina->attributes()->TipoContrato,
                    'TipoJornada'            => $nmd->Nomina->attributes()->TipoJornada,
                    'TipoRegimen'            => $nmd->Nomina->attributes()->TipoRegimen,
                    'Version'                => $nmd->Nomina->attributes()->Version
                    );
            }

            // Percepciones
            if (isset($nmd->Nomina->Percepciones)) {
                $data['Nomina']['Percepciones']['@atributos'] = array(
                    'TotalGravado' => $nmd->Nomina->Percepciones->attributes()->TotalGravado,
                    'TotalExento'  => $nmd->Nomina->Percepciones->attributes()->TotalExento
                    );

                foreach ($nmd->Nomina->Percepciones->children($namespace['nomina']) as $key => $value) {
                    $data['Nomina']['Percepciones']['Percepcion']['@atributos'][] = array(
                        'TipoPercepcion' => $value->attributes()->TipoPercepcion,
                        'Clave'          => $value->attributes()->Clave,
                        'Concepto'       => $value->attributes()->Concepto,
                        'ImporteGravado' => $value->attributes()->ImporteGravado,
                        'ImporteExento'  => $value->attributes()->ImporteExento
                        );
                }
            }

            // Deducciones
            if (isset($nmd->Nomina->Deducciones)) {
                $data['Nomina']['Deducciones']['@atributos'] = array(
                    'TotalGravado' => $nmd->Nomina->Deducciones->attributes()->TotalGravado,
                    'TotalExento'  => $nmd->Nomina->Deducciones->attributes()->TotalExento,
                    );

                foreach ($nmd->Nomina->Deducciones->children($namespace['nomina']) as $key => $value) {
                    $data['Nomina']['Deducciones']['Deduccion']['@atributos'][] = array(
                        'TipoDeduccion'  => $value->attributes()->TipoDeduccion,
                        'Clave'          => $value->attributes()->Clave,
                        'Concepto'       => $value->attributes()->Concepto,
                        'ImporteGravado' => $value->attributes()->ImporteGravado,
                        'ImporteExento'  => $value->attributes()->ImporteExento
                        );
                }
            }

            // Incapacidades
            if (isset($nmd->Nomina->Incapacidades)) {
                foreach ($nmd->Nomina->Incapacidades->children($namespace['nomina']) as $key => $value) {
                    $data['Nomina']['Incapacidades']['Incapacidad']['@atributos'][] = array(
                        'DiasIncapacidad' => $value->attributes()->DiasIncapacidad,
                        'TipoIncapacidad' => $value->attributes()->TipoIncapacidad,
                        'Descuento'       => $value->attributes()->Descuento
                        );
                }
            }

            // Horas Extra
            if (isset($nmd->Nomina->HorasExtras)) {
                foreach ($nmd->Nomina->HorasExtras->children($namespace['nomina']) as $key => $value) {
                    $data['Nomina']['HorasExtras']['@atributos'][] = array(
                        'Dias'          => $value->attributes()->Dias,
                        'HorasExtra'    => $value->attributes()->HorasExtra,
                        'ImportePagado' => $value->attributes()->ImportePagado,
                        'TipoHoras'     => $value->attributes()->TipoHoras
                        );
                }
            }
        }

        // Timbre Fiscal
        if (isset($namespace['tfd'])) {
            $tfd  = $cfdi->Complemento->children($namespace['tfd']);

            if (isset($tfd->TimbreFiscalDigital)) {
                $data['TimbreFiscalDigital']['@atributos'] = array(
                    'FechaTimbrado'    => $tfd->TimbreFiscalDigital->attributes()->FechaTimbrado,
                    'noCertificadoSAT' => $tfd->TimbreFiscalDigital->attributes()->noCertificadoSAT,
                    'selloCFD'         => $tfd->TimbreFiscalDigital->attributes()->selloCFD,
                    'selloSAT'         => $tfd->TimbreFiscalDigital->attributes()->selloSAT,
                    'UUID'             => $tfd->TimbreFiscalDigital->attributes()->UUID,
                    'version'          => $tfd->TimbreFiscalDigital->attributes()->version
                    );
            }
        }

        return (count($data) > 0) ? $data : null;
    }
}
