@auth
<div id="edit-comment-footer" class="fixed-bottom bg-black" style="display:none;">
    <div class="py-md-2">
        <form name="edit-comment" method="post" action="{{ url('comment/edit') }}">
            @csrf
            <div id="footer-comment-group" class="row justify-content-center">
                <div class="form-group col-md-6 mb-0">
                    <textarea name="content" rows="1" id="edit-comment-content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"placeholder="コメントを入力" style="resize: none;"></textarea>
                    @if ($errors->has('content'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('content') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group col-md-2 mb-0">
                    <button type="button" id="edit-comment-button" class="btn btn-success mr-md-2">修正</button>
                    <button type="button" id="edit-comment-cancel-button" class="btn btn-secondary">キャンセル</button>
                </div>
            </div>
            <input type="hidden" name="comment_id" id="edit-comment-id" value="">
        </form>
    </div>
</div>
@endauth
