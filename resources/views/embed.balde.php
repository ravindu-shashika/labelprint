@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <iframe srcdoc="{{ $pdf_content }}" width="100%" height="800px"></iframe>
    </div>
@endsection
