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
    <button onclick="window.print()" class="btn btn-primary">Print Labels</button>

    <embed id="pdfEmbed" src="data:application/pdf;base64,{{ base64_encode($pdf_content) }}" type="application/pdf" width="100%" height="600px" />

    <

    <script>
        function printPDF() {

            window.print();


        }

        function markLabelsAsPrinted() {

            $.ajax({
                url: '/mark-labels-as-printed',
                method: 'POST',
                data: { },
                success: function(response) {

                    console.log('Labels marked as printed in the database');
                },
                error: function(xhr, status, error) {

                    console.error('Error marking labels as printed:', error);
                }
            });
        }

        let isPrinting = false;
        window.addEventListener("afterprint", (event) => {
            console.log("Printing completed");
        });

        window.onafterprint = (event) => {
            console.log("Printing completed");
        };
    </script>
</body>
</html>
