@foreach($reviews as $key=>$review)
    @if($review->product)
        <tr>
            <td>{{$key+1}}</td>
            <td>
                                        <span class="d-block font-size-sm text-body">
                                            <a href="{{route('admin.product.view',[$review['product_id']])}}">
                                                {{$review->product['name']}}
                                            </a>
                                        </span>
            </td>
            <td>
                <a href="{{route('admin.customer.view',[$review->user_id])}}">
                    {{$review->customer->f_name." ".$review->customer->l_name}}
                </a>
            </td>
            <td>
                {{$review->comment}}
            </td>
            <td>
                <label class="badge badge-soft-info">
                    {{$review->rating}} <i class="tio-star"></i>
                </label>
            </td>
        </tr>
    @endif
@endforeach
