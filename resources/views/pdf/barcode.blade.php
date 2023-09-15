@php
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
@endphp
{!! $generator->getBarcode($kd_brg, $generator::TYPE_CODE_128) !!}<br/>
{!! $kd_brg !!}
