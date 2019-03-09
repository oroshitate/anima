@auth
<div id="create-comment-footer" class="fixed-bottom bg-black">
    <div class="py-2">
        <form name="create-comment" method="post" action="{{ url('comment/store') }}">
            @csrf
            <div id="footer-comment-group" class="row justify-content-center">
                <div class="form-group col-7 col-md-6 mb-0">
                    <textarea name="content" rows="1" id="comment-content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"placeholder="{{ __('app.label.comment.placeholder') }}" style="resize: none;"></textarea>
                    @if ($errors->has('content'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('content') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-3 col-md-2 mb-0 text-center pl-0">
                    <button type="button" id="create-comment-button" class="btn btn-success w-75" data-review_id="{{ $review[0]->review_id }}">{{ __('app.button.create') }}</button>
                </div>
            </div>
            <input type="hidden" name="review_id" id="create-comment-review-id" value="">
            <input type="hidden" name="reply_id" value="">
        </form>
    </div>
</div>
@else
<div class="fixed-bottom bg-black">
    <div class="py-2 text-center">
        <a href="{{ url('/login') }}">
            <button type="button" class="btn btn-success">{{ __('app.button.comment.create') }}</button>
        </a>
    </div>
</div>
@endauth
