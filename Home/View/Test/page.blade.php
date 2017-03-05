<ul class="pagination pagination-lg">
    @if($current != 1)
        <li><a href="{{ $page_url }}?current={{$current -1}}">上一页</a></li>
    @endif
    @if($file_total_page > 10)
        @if($current < 10)
            @for($i=1; $i <= 10; $i++)
                @if($i == $current)
                    <li class="active"><a href="#">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $page_url }}?current={{$i}}">{{$i}}</a></li>
                @endif

            @endfor
        @else
            @for($i=$current - 9; $i <= $current; $i++)
                @if($i == $current)
                    <li class="active"><a href="#">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $page_url }}?current={{$i}}">{{$i}}</a></li>
                @endif

            @endfor
        @endif
    @else
        @for($i=1; $i <= $file_total_page; $i++)
            @if($i == $current)
                <li class="active"><a href="#">{{ $i }}</a></li>
            @else
                <li><a href="{{ $page_url }}?current={{$i}}">{{$i}}</a></li>
            @endif

        @endfor
    @endif
    @if($current != $file_total_page)
        <li><a href="{{ $page_url }}?current={{$current + 1}}">下一页</a></li>
    @endif
    <li><a href="javascript:void(0)">共 {{ $file_total_page }} 页</a></li>
</ul><!--/.pagination-->