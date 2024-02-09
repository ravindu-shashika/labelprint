<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            /* size: {{ $pageSize }}; */
            size:{{ $pageSize }} {{$orientation}};
            /* margin: 10px; */
        }

        .page {
             /* margin: 10px;
            padding: 10px; */
            display: flex;
            flex-wrap: wrap;
        }

        .label {
            width: {{ $labelsWidth }}mm;
            height: {{ $labelsHeight }}mm;
            border: 1px solid black;
            display: inline-block;
            margin: 2px;
            box-sizing: border-box;
            padding: 2px;
        }

        .product-code {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 5px;
            text-align: center;
        }

        .attributes {
            font-size: 14px;
            margin-bottom: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="page">
    @foreach ($products as $product)
    <div class="label">
        <div class="product-code">{{$product->product_code}}</div>
        <div class="attributes">Color: {{$product['attributes']->colour }}<br> Size: {{$product['attributes']->size }}</div>
    </div>
    @endforeach

</div>

</body>
</html>
