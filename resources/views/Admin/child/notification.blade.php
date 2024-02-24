 <div class="message-body">
     {{-- vào --}}
     @if ($notification->count() > 0)
         @foreach ($notification as $value)
            @if ($value->type == 0)
            <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                <p class="mb-0 fs-3"><span style="color: #5D87FF">{{ $value->user1->name }}</span> thích bài viết của bạn
                </p>

            </a>
            @elseif ($value->type == 1)
            <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                <p class="mb-0 fs-3"><span style="color: #5D87FF">{{ $value->user1->name }}</span> Đang theo dõi bạn
                </p>

            </a>
            @elseif ($value->type == 2)
            <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                <p class="mb-0 fs-3"><span style="color: #5D87FF">{{ $value->user1->name }}</span> đã bình luận về nhật ký của bạn
                </p>

            </a>
            @endif

         @endforeach
     @else
     <span class="d-flex align-items-center gap-2 dropdown-item">
        <p class="mb-0 fs-3"><span style="color: #5D87FF">Không có gì để hiển thị!</span></p>
    </span>
     @endif

 </div>
