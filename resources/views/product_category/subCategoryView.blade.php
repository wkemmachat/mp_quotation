@foreach($subcategories as $subcategory)
    <tr data-id="{{$subcategory->id}}" data-parent="{{$dataParent}}" data-level = "{{$dataLevel + 1}}">
        <td data-column="name">{{$subcategory->productCategoryName}}</td>
    </tr>
    @if(count($subcategory->subcategory))
        @include('product_category.subCategoryView',['subcategories' => $subcategory->subcategory, 'dataParent' => $subcategory->id, 'dataLevel' => $dataLevel ])
    @endif
@endforeach
