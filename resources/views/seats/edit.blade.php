@extends('layouts.app', [
    'activenav' => 'seating',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('seatingplans.index') }}">Seating Plans</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('seatingplans.show', $seat->plan->event->code) }}">{{ $seat->plan->event->name }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('seats.edit', $seat->id) }}">{{ $seat->label }}</a></li>
@endsection

@section('content')
    <div class="row g-2 align-items-center mb-4">
        <div class="col">
            <h2 class="page-title">{{ $seat->label }}</h2>
        </div>
    </div>

    <div class="col-md-6 offset-md-3">
        <form action="{{ route('seats.update', $seat->id) }}" method="post" class="card">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="card-body">
                <h3 class="card-title">Ticket</h3>
                <p class="card-subtitle">Select the ticket to assign to {{ $seat->label }}</p>
            </div>
            <div class="card-body">
                @error('ticket_id')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
                <p>
                    @foreach($tickets as $i => $ticket)

                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="ticket_id" value="{{ $ticket->id }}" @if($i === 0) checked @endif>
                            <span class="form-check-label">
                                {{ $ticket->user->nickname }}

                                @if ($ticket->seat)
                                    <span class="badge">{{ $ticket->seat->label }}</span>
                                @endif
                            </span>
                        </label>
                    @endforeach
                </p>
            </div>
            <div class="card-footer text-end">
                <div class="d-flex">
                    <a href="{{ route('seatingplans.show', $seat->plan->event->code) }}" class="btn btn-link">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-auto">Choose Seat</button>
                </div>
            </div>
        </form>
    </div>
@endsection
