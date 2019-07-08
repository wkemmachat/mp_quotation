

<table>
    <tr>
        <th>Export Date : {{ $now->format('d-m-Y H:i:s') }}</th>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Inventory</th>
            <th>Pending Delivery (MP)</th>
            <th>Pending Delivery (FUR)</th>
            <th>Pending Delivery (OFF)</th>
            <th>Balance</th>
            <th>On P/O</th>
            <th>Total Balance</th>
        </tr>
    </thead>

    <tbody>
            @php
            for($i=0 ; $i<count($products) ;$i++) {
                $balance = $products[$i]->stock_real_time->amount - $outWaitingArrayMp[$i] - $outWaitingArrayFur[$i] - $outWaitingArrayOff[$i];
                $totalBalance = $balance + $inWaitingArrayOff[$i];
            @endphp
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $products[$i]->productId }}</td>
                <td>{{ $products[$i]->productName }}</td>
                <td>{{ $products[$i]->stock_real_time->amount}}</td>
                <td>{{ $outWaitingArrayMp[$i] }}</td>
                <td>{{ $outWaitingArrayFur[$i] }}</td>
                <td>{{ $outWaitingArrayOff[$i] }}</td>
                <td>{{ $balance }}</td>
                <td>{{ $inWaitingArrayOff[$i] }}</td>
                <td>{{ $totalBalance }}</td>
            </tr>
        @php
            }
        @endphp

    </tbody>

</table>
