@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <button onclick="printLabels()" class="btn btn-primary">Print Labels</button>
        <div class="container mt-5" id="labelsContent">
            <!-- Include the HTML content here -->
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
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        </div>
    </div>

    <script>
         function printLabels() {
            var labelsContent = document.getElementById('labelsContent').innerHTML;
            var newWindow = window.open();
            newWindow.document.write(labelsContent);
            newWindow.onafterprint = function() {
                console.log("Printing completed");
                markLabelsAsPrinted();
                newWindow.close();
            };
            newWindow.print();
        }

        function markLabelsAsPrinted() {
            // Perform an AJAX request to mark labels as printed in the database
            $.ajax({
                url: '/mark-labels-as-printed',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { label_ids: <?php echo json_encode($labels); ?>  },
                success: function(response) {
                    // Handle success response
                    console.log('Labels marked as printed in the database');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error('Error marking labels as printed:', error);
                }
            });
        }
    </script>
@endsection
