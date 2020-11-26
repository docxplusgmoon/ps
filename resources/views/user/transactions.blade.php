@extends('layouts.app')

@section('title', 'Client transactions report')

@section('content')
    <div class="form">
        {!! Form::open(['url' => '/', 'method' => 'get']) !!}
            {{ Form::text('name', $request->get('name'), ['placeholder' => 'Name', 'required']) }}
            {{ Form::date('start_date', $request->get('start_date'), ['placeholder' => 'Start date']) }}
            {{ Form::date('end_date', $request->get('end_date'), ['placeholder' => 'End date']) }}
            {{ Form::submit('Show') }}
        {!! Form::close() !!}
    </div>

    <div class="values">

        @if (!isset($report['transactions']))
            @if (empty($user))
                <p>User not found</p>
            @else
                <p>Couldn't find transactions</p>
            @endif
        @else
            <div class="totals">
                <div>Total in {{$user->currency->code}}: {{ $report['totalAmount'] }}</div>
                <div>Total in USD:
                    @if (isset($report['totalInUSD']))
                        {{ $report['totalInUSD'] }}
                    @else
                        You need to create the currency exchange rate for today's date
                    @endif
                </div>
                <div>
                    <a href="/download_user_transactions?{{ http_build_query($request->all()) }}">Download as CSV</a>
                </div>
            </div>
            <table class="user_report">
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Comment</th>
                </tr>
                @foreach ($report['transactions'] as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>
                            {{ $transaction->type == \App\Models\Transaction::TYPE_DEPOSIT ? 'Deposit' : 'Transfer'}}
                        </td>
                        <td>{{ $transaction->amount }} {{ $user->currency->code }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        <td>{{ $transaction->comment }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="pages">
                @if($page > 1)
                    <a href="/?{{ http_build_query(array_merge($request->all(), ['page' => $page - 1])) }}">
                        Previous page
                    </a>
                @endif
                <span>{{ $page }}</span>
                @if($page < $report['totalPages'])
                    <a href="/?{{ http_build_query(array_merge($request->all(), ['page' => $page + 1])) }}">
                        Next page
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection
