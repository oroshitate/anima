<div class="grid-index my-2">
    <div class="grid-sizer col-4"></div>
    @foreach($watchlists as $watchlist)
    <div class="grid-item col-4 my-1 px-1 watchlist">
        <div class="card">
            <a href="{{ route('item', ['item_id' => $watchlist->item_id]) }}">
                @if($watchlist->item_image == null)
                    <img src="{{ asset('anima_image.png') }}" class="w-100">
                @else
                    <img src="{{ config('app.image_path') }}/items/{{ $watchlist->item_image }}" class="w-100">
                @endif
            </a>
            <div class="bg-secondary text-white text-center">
                <span class="text-white name-length h7">{{ $watchlist->item_title }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
