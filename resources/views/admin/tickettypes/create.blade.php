@extends('layouts.app', [
    'activenav' => 'admin',
])

@section('breadcrumbs')
    @include('admin.events._breadcrumbs')
    <li class="breadcrumb-item active"><a href="{{ route('admin.events.tickettypes.create', $event->code) }}">Add Ticket
            Type</a></li>
@endsection

@section('content')
    <div class="page-header mt-0">
        <h1>Add Ticket Type</h1>
    </div>

    <div class="col-md-6 offset-md-3">
        <form action="{{ route('admin.events.tickettypes.store', $event->code) }}" method="post" class="card">
            {{ csrf_field() }}
            @include('admin.tickettypes._form')
            <div class="card-footer text-end">
                <div class="d-flex">
                    <a href="{{ route('admin.events.show', $event->code) }}" class="btn btn-link">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-auto">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
