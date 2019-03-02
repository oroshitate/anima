@foreach($items as $item)
    <li class="list-inline-item my-md-2">
        <a href="{{ route('item', ['item_id' => $item->id]) }}">
            <img src="/storage/images/items/{{ $item->image }}.jpg">
        </a>
        <div class="bg-secondary text-white">
            <span class="text-white name-length">{{ $item->title }}</span>
            <div class="d-inline-block ml-md-2">
                <div class="one-star-rating d-inline-block">
                    <div class="one-star-rating-front">★</div>
                </div>
                <span class="text-warning">{{ $item->item_avg }}</span>
            </div>
        </div>
    </li>
@endforeach
