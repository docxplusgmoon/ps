@if ($page == 1)
    ID;Type;Amount;Date;Comment
@endif
@foreach($transactions as $transaction)
    {{
        sprintf('%s;%s;%s;%s;%s',
            $transaction->id,
            $transaction->type == \App\Models\Transaction::TYPE_DEPOSIT ? 'Deposit' : 'Transfer',
            $transaction->amount,
            $transaction->created_at,
            $transaction->comment)
     }};
@endforeach
