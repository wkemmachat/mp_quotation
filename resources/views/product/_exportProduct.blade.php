<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Remark</th>
            <th>User</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->productId }}</td>
                <td>{{ $item->productName }}</td>
                <td>{{ $item->remark }}</td>
                <td>{{ $item->user_key_in->name }}</td>
                <td>{{ date('d-M-Y',strtotime($item->created_at)) }}</td>
                <td>{{ date('d-M-Y',strtotime($item->updated_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
