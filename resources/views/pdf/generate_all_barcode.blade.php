@php
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
$datas = array('b001', 'b002', 'b003');
@endphp
@foreach ($datas as $value )
{!! $generator->getBarcode($value, $generator::TYPE_CODE_128) !!}<br/>
{!! $value !!}
    
@endforeach