@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @if($lastprintdetails)
        <button type="button" class="btn btn-success float-end" id="set_last_print_details">Set Last Print Details</button>
        <br>
        @endif
        <form action="{{ route('generate_pdf') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="labels-width">Labels Width:(mm)</label>
                <input type="text" class="form-control" id="labels_width" name="labels_width" required>
            </div>
            <div class="form-group">
                <label for="labels-height">Labels Height:(mm)</label>
                <input type="text" class="form-control" id="labels_height" name="labels_height" required>
            </div>
            <div class="form-group">
                <label for="orientation">Orientation:</label>
                <select class="form-control" id="orientation" name="orientation" required>
                    <option value="">Select Orientation</option>
                    <option value="portrait">Portrait</option>
                    <option value="landscape">Landscape</option>
                </select>
            </div>
            <div class="form-group">
                <label for="page_size">Page Size:</label>
                <select class="form-control" id="page_size" name="page_size" required>
                    <option value="">Select Size</option>
                    <option value="a4">A4</option>
                    <option value="letter">Letter</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="allowrange" name="allowrange">
                <label class="form-check-label" for="allowrange">Apply Range</label>
            </div>
            <div class="form-group">
                <label for="start">Start:</label>
                <select name="start_position" id="start_position"  class="form-control" disabled>
                    <option value=" ">Select Start Position </option>
                    @foreach($products as $product)

                        <option value="{{$product->id}}">{{$product->product_code}}</option>
                    @endforeach
                </select>

            </div>
            <div class="form-group">
                <label for="end">End:</label>
                <select name="end_position" id="end_position"  class="form-control" disabled>
                    <option value=" ">Select End Position </option>
                    @foreach($products as $product)

                        <option value="{{$product->id}}">{{$product->product_code}}</option>
                    @endforeach
                </select>

            </div>
            <br>
                <button type="submit" class="btn btn-primary">Generate PDF</button>


        </form>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allowRangeCheckbox = document.getElementById('allowrange');
        const startPositionSelect = document.getElementById('start_position');
        const endPositionSelect = document.getElementById('end_position');
        const setLastPrintDetailsButton = document.getElementById('set_last_print_details');


        setLastPrintDetailsButton.addEventListener('click', function() {

            if ({!! json_encode($lastprintdetails) !!} !== null) {
                const lastPrintDetails = {!! json_encode($lastprintdetails) !!};


                document.getElementById('labels_width').value = lastPrintDetails.label_width;
                document.getElementById('labels_height').value = lastPrintDetails.label_height;
                document.getElementById('orientation').value = lastPrintDetails.paper_orientation;
                document.getElementById('page_size').value = lastPrintDetails.paper_size;
                document.getElementById('date').value = lastPrintDetails.date;


                allowRangeCheckbox.checked = lastPrintDetails.allowrange;
                startPositionSelect.disabled = !lastPrintDetails.allowrange;
                endPositionSelect.disabled = !lastPrintDetails.allowrange;


                if (lastPrintDetails.allowrange) {
                    document.getElementById('start_position').value = lastPrintDetails.start_position;
                    document.getElementById('end_position').value = lastPrintDetails.end_position;
                }
            } else {
                alert('No last print details available.');
            }
        });


        allowRangeCheckbox.addEventListener('change', function() {
            startPositionSelect.disabled = !this.checked;
            endPositionSelect.disabled = !this.checked;
        });
    });
</script>
