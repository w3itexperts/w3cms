@extends('samplemodule::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('samplemodule.name') !!}</p>
@endsection
