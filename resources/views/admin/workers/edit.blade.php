@extends('layouts.app')

@section('content')
    @include('admin.workers._form', ['worker' => $worker])
@endsection