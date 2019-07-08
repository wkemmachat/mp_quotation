<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Amount</th>
            <th>Document Id</th>
            <th>Created Date / วันที่</th>
            <th>Name / ผู้ทำงาน</th>
            <th>Remark / หมายเหตุ</th>
            <th>Confirmed</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>In Or Out</th>
        </tr>
    </thead>

    <tbody>
            @php
            for($i=0 ; $i<count($transferInOutArray) ;$i++) {
                $showIsConfirmed = "no";
                if($transferInOutArray[$i]->isConfirmed==1){
                    $showIsConfirmed = "yes";
                }
            @endphp
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $transferInOutArray[$i]->product_running->productId }}</td>
                <td>{{ $transferInOutArray[$i]->product_running->productName }}</td>
                <td>{{ $transferInOutArray[$i]->amount}}</td>
                <td>{{ $transferInOutArray[$i]->document_reference_id }}</td>
                <td>{{ date('d-M-Y',strtotime($transferInOutArray[$i]->input_date)) }}</td>
                <td>{{ $transferInOutArray[$i]->user_key_in->name }}</td>
                <td>{{ $transferInOutArray[$i]->remark }}</td>
                <td>{{ $showIsConfirmed}}</td>
                <td>{{ date('d-M-Y H:s',strtotime($transferInOutArray[$i]->created_at)) }}</td>
                <td>{{ date('d-M-Y H:s',strtotime($transferInOutArray[$i]->updated_at)) }}</td>
                <td>{{ $transferInOutArray[$i]->in_or_out }}</td>
            </tr>
        @php
            }
        @endphp

    </tbody>

</table>
