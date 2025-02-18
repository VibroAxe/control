@extends('layouts.app', [
    'activenav' => 'tickets',
])

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">Tickets</a></li>
    <li class="breadcrumb-item active">
        <a href="{{ route('tickets.show', $ticket->id) }}">
            {{ $ticket->reference }}
        </a>
    </li>
@endsection

@section('content')
    <div class="page-header mt-0">
        <h1>Ticket Details</h1>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="datagrid col-md-5 mb-4">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Reference</div>
                                <div class="datagrid-content">{{ $ticket->reference }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">QR Code</div>
                                <div class="datagrid-content">
                                    <img src="{{ $ticket->qrcode }}"/>
                                </div>
                            </div>
                            <div class="datagrid-item d-none d-print-block">
                                <div class="datagrid-title">Nickname</div>
                                <div class="datagrid-content">{{ $ticket->user->nickname }}</div>
                            </div>
                            <div class="datagrid-item d-none d-print-block">
                                <div class="datagrid-title">Name</div>
                                <div class="datagrid-content">{{ $ticket->user->name }}</div>
                            </div>
                        </div>
                        <div class="datagrid col-md-7">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Type</div>
                                <div class="datagrid-content">{{ $ticket->type->name }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Event</div>
                                <div class="datagrid-content">
                                    {{ $ticket->event->name }}
                                    @if($ticket->event->draft)
                                        <span class="badge bg-muted text-muted-fg d-print-none">Draft</span>
                                    @endif
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Date</div>
                                <div class="datagrid-content">{{ $ticket->event->starts_at->format('gA jS F Y') }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Seat</div>
                                <div class="datagrid-content">
                                    @if($ticket->seat)
                                        <a href="{{ route('seatingplans.show', $ticket->event->code) }}#{{ $ticket->seat->label }}">{{ $ticket->seat->label }}</a>
                                    @elseif($ticket->canPickSeat())
                                        None - <a href="{{ route('seatingplans.show', $ticket->event->code) }}">Choose
                                            Seat</a>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-print-none">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        Transfer Ticket
                    </h3>
                </div>
                <div class="card-body">
                    @if($ticket->canTransfer())
                        <p>
                            If you want to transfer this ticket to another person, you can generate a Ticket Transfer
                            Code.
                        </p>
                        <p>
                            The other person will be able to enter this code and the ticket will be removed from your
                            account
                            and added to theirs.
                        </p>
                        @if($ticket->transfer_code)
                            <h2 class="text-center">
                                <strong class="user-select-all">{{ $ticket->transfer_code }}</strong>
                            </h2>
                        @endif
                    @else
                        <p>
                            It is not possible to transfer this ticket.
                        </p>
                    @endif
                </div>
                @if($ticket->canTransfer())
                    <div class="card-footer">
                        <form class="d-flex" action="{{ route('tickets.update', $ticket->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="btn-list w-100 justify-content-end">
                                @if($ticket->transfer_code)
                                    <button type="submit" class="btn btn-outline-danger d-inline-block me-auto"
                                            name="remove">
                                        <i class="icon ti ti-x"></i>
                                        Remove
                                    </button>
                                @endif
                                <button type="submit" class="btn btn-primary d-inline-block" name="generate">
                                    <i class="icon ti ti-refresh"></i>
                                    Generate New Code
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
