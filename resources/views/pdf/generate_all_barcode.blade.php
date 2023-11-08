<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        .container{
            display: grid;
            grid-template-columns: auto auto;
            grid-gap: 15px;
        }
        .container > div.position{
            padding: 5px;
        }
    </style>
</head>
<body>
    @php
    $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    @endphp
    <div class="container">
        @foreach ($codes as $key => $value )
        <div class="position">
            <p id="<?php echo $key; ?>">{!! $generator->getBarcode($value, $generator::TYPE_CODE_128) !!}</p><br/>
            <small style="text-align: center;">{!! $value !!}</small>
        </div>

        @endforeach
    </div>
    
    <script>
        window.print();
    </script>
</body>
</html>