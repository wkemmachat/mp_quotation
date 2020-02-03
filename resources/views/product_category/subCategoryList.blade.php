@foreach($subcategories as $subcategory)
    <ul>
        <li>{{$subcategory->productCategoryName}}</li>
        @if(count($subcategory->subcategory))
            @include('product_category.subCategoryList',['subcategories' => $subcategory->subcategory])
        @endif
    </ul>
@endforeach
