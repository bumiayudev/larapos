@extends('layouts.default')

@section('content')

<div class="container-fluid">
   <div class="card mt-4 mt-2">
    <div class="card-header">
        Hasil Generate Barcode
    </div>
    <div class="card-body">
        @php
            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        @endphp
        <div class="float-start">
            {!! $generator->getBarcode($kd_brg, $generator::TYPE_CODE_128) !!} <br>
            {!! $kd_brg !!}
        </div>
        <div class="float-end"><button class="btn btn-sm btn-primary"><i class="fas fa-print fa-fw"></i>Print</button></div>
    </div>
   </div>

</div>
@endsection