<div class="grid-index my-2">
    <div class="grid-sizer col-4"></div>
    @foreach($items as $item)
    <div class="grid-item col-4 my-1 px-1 keyword-item">
        <div class="card">
            <a href="{{ route('item', ['item_id' => $item->id]) }}">
                @if($item->image == null)
                    <img src="{{ asset('anima-img.png') }}" class="w-100">
                @else
                    <img src="{{ config('app.image_path') }}/items/{{ $item->image }}" class="w-100">
                @endif
            </a>
            <div class="bg-secondary text-white text-center">
                <span class="text-white name-length h7">{{ $item->title }}</span>
                @if($item->reviews_count > 0)
                    <div class="d-inline-block">
                        <div class="one-star-rating d-inline-block">
                            <div class="one-star-rating-front">★</div>
                        </div>
                        <span class="text-warning h7">{{ $item->item_avg }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
