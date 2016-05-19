<?php

namespace lalocespedes\CfdiMx;

use SimpleXMLElement;
use Exception;
use JsonSerializable;

/**
 *
 */
class Parser implements JsonSerializable
{
    private $_mapping;
    public $_file;
    /**
     * Construct
     * @param string $file Path to the xml file
     */
    final public function __construct($file = null)
    {
        if (!is_file($file)) throw new Exception('Error: no file found');

        $xml = new SimpleXMLElement(file_get_contents($file));

        $this->_file = $file;
        // Gets mapping object
        $this->_mapping = new Mapping($xml);

    }

    /**
     * JSON Serialize method
     * @return array XML Parse data
     */
    final public function jsonSerialize()
    {
        $sat = new Sat;
        $qr = $sat->qr_sat($this->_mapping->total, $this->_mapping->emisor['@atributos']['rfc'], $this->_mapping->receptor['@atributos']['rfc'], $this->_mapping->complemento['TimbreFiscalDigital']['@atributos']['UUID']);

        $cadenaOriginalTFD = "||1.0|".$this->_mapping->complemento['TimbreFiscalDigital']['@atributos']['UUID']."|".$this->_mapping->fecha."|".$this->_mapping->complemento['TimbreFiscalDigital']['@atributos']['selloCFD']."|".$this->_mapping->complemento['TimbreFiscalDigital']['@atributos']['noCertificadoSAT'].'||';
            
        $numletras = new NumberToLetterConverter;
        $numletras = $numletras->to_word($this->_mapping->total, $this->_mapping->moneda);

        $importe_letra = $numletras;

            return array(
            'Comprobante' => array(
                '@atributos' => array(
                    'fecha'             => $this->_mapping->fecha,
                    'folio'             => $this->_mapping->folio,
                    'serie'             => $this->_mapping->serie,
                    'TipoDeComprobante' => $this->_mapping->TipoDeComprobante,
                    'subtotal'          => $this->_mapping->subTotal,
                    'descuento'         => $this->_mapping->descuento,
                    'total'             => $this->_mapping->total,
                    'moneda'            => $this->_mapping->moneda,
                    'TipoCambio'        => $this->_mapping->TipoCambio,
                    'condicionesDePago' => $this->_mapping->condicionesDePago,
                    'noCertificado'     => $this->_mapping->noCertificado,
                    'certificado'       => $this->_mapping->certificado,
                    'formaDePago'       => $this->_mapping->formaDePago,
                    'metodoDePago'      => $this->_mapping->metodoDePago,
                    'NumCtaPago'        => $this->_mapping->NumCtaPago,
                    'LugarExpedicion'   => $this->_mapping->LugarExpedicion,
                    'sello'             => $this->_mapping->sello,
                    'version'           => $this->_mapping->version()
                    ),
                '@namespaces' => $this->_mapping->namespaces(),
                'Emisor'      => $this->_mapping->emisor,
                'Receptor'    => $this->_mapping->receptor,
                'Conceptos'   => $this->_mapping->conceptos,
                'Impuestos'   => $this->_mapping->impuestos,
                'Complemento' => $this->_mapping->complemento,
                'cadenaOriginalTFD' => $cadenaOriginalTFD,
                'codigobarra' => $qr,
                'importe_letra' => strtoupper($importe_letra)
                )
            );

    }


}
