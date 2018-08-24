@if($pagination['lastPage']>1)
    <div class="pagination">
        @if($pagination['currentPage']>1)
            <a class="pagination-btn" href="{{ $pagination['first_page_url'] }}">首页</a>
            <a class="pagination-btn" href="{{ $pagination['prev_page_url'] }}">上一页</a>
        @endif
        @for($i=$pagination['from_page'];$i<=$pagination['to_page'];$i++)
            @if($i==$pagination['currentPage'])
                <span class="pagination-item-current">{{ $i }}</span>
            @else
                <a class="pagination-item" href="{{ $pagination['items']['#page'.$i] }}">{{ $i }}</a>
            @endif
        @endfor
        @if($pagination['currentPage']<$pagination['lastPage'])
            <a class="pagination-btn" href="{{ $pagination['next_page_url'] }}">下一页</a>
            <a class="pagination-btn" href="{{ $pagination['last_page_url'] }}">末页</a>
        @endif
    </div>
@endif
