@foreach($categories as $key=>$category)
    <tr>
        <td>{{$key+1}}</td>
        <td>
            <span class="d-block font-size-sm text-body">
                {{$category->parent?$category->parent['name']:''}}
            </span>
        </td>

        <td>
            <span class="d-block font-size-sm text-body">
                {{$category['name']}}
            </span>
        </td>

        <td>
            @if($category['status']==1)
                <div style="padding: 10px;border: 1px solid;cursor: pointer"
                     onclick="location.href='{{route('admin.category.status',[$category['id'],0])}}'">
                    <span class="legend-indicator bg-success"></span>{{\App\CentralLogics\translate('active')}}
                </div>
            @else
                <div style="padding: 10px;border: 1px solid;cursor: pointer"
                     onclick="location.href='{{route('admin.category.status',[$category['id'],1])}}'">
                    <span class="legend-indicator bg-danger"></span>{{\App\CentralLogics\translate('disabled')}}
                </div>
            @endif
        </td>
        <td>
            <!-- Dropdown -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i class="tio-settings"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item"
                       href="{{route('admin.category.edit',[$category['id']])}}">{{\App\CentralLogics\translate('edit')}}</a>
                    <a class="dropdown-item" href="javascript:"
                       onclick="form_alert('category-{{$category['id']}}','Want to delete this category ?')">{{\App\CentralLogics\translate('delete')}}</a>
                    <form action="{{route('admin.category.delete',[$category['id']])}}"
                          method="post" id="category-{{$category['id']}}">
                        @csrf @method('delete')
                    </form>
                </div>
            </div>
            <!-- End Dropdown -->
        </td>
    </tr>
@endforeach
