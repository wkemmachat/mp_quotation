<table class="table">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th class="text-center">Product Id</th>
            <th class="text-center">Product Name</th>
            <th class="text-center">Amount</th>
            <th class="text-center">Document Id</th>
            <th class="text-center">Created Date / วันที่</th>
            <th class="text-center">Name / ผู้ทำงาน</th>
            <th class="text-center">Remark / หมายเหตุ</th>
            <th class="text-center">Confirmed</th>
            <th class="text-center">Created At</th>
            <th class="text-center">Updated At</th>
        </tr>
    </thead>

    <tbody>
        <?php
            for($i=0 ; $i<count($transferInOutArray) ;$i++) {
                $showIsConfirmed = "no";

        ?>
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $transferInOutArray[$i]->product_running->productId }}</td>
                <td>{{ $transferInOutArray[$i]->product_running->productName }}</td>
                <td class="text-center">{{ $transferInOutArray[$i]->amount}}</td>
                <td class="text-center"><font color="blue">{{ $transferInOutArray[$i]->document_reference_id }}</font></td>
                <td class="text-center">{{ date('d-M-Y',strtotime($transferInOutArray[$i]->input_date)) }}</td>
                <td class="text-center">{{ $transferInOutArray[$i]->user_key_in->name }}</td>
                <td class="text-center">{{ $transferInOutArray[$i]->remark }}</td>
                <td class="text-center">{{ $showIsConfirmed}}</td>
                <td class="text-center">{{ date('d-M-Y H:s',strtotime($transferInOutArray[$i]->created_at)) }}</td>
                <td class="text-center">{{ date('d-M-Y H:s',strtotime($transferInOutArray[$i]->updated_at)) }}</td>

            </tr>
        <?php
            }
        ?>

    </tbody>

</table>
