@extends('layouts.app')

@section('content')
    @include('admin.workers._form', ['worker' => new \App\Models\Worker()])
@endsection