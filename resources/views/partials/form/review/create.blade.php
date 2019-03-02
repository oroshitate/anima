<div class="modal fade" id="create-review-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-black border-0">
                <p class="text-white h4 mx-auto">レビューを投稿</p>
                <button type="button" class="close text-white ml-0" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-0 pb-md-0">
                <form name="create-review" method="post" action="{{ url('/review/store') }}">
                    @csrf
                    <div class="form-group mb-md-3">
                        <div class="row justify-content-center">
                            <input type="range" name="score" class="custom-range col-md-9 mx-auto" min="0" max="5" step="0.5" id="slider" value="0">
                            <span id="slider-count" class="h5 text-warning col-md-2">0</span>
                        </div>
                        @if ($errors->has('score'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('score') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-md-3">
                        <div class="">
                            <textarea name="content" rows="10"class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"placeholder="コメントが入力できます。" style="resize: none;"></textarea>
                            @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group mb-md-3">
                        <button type="button" id="share-twitter-button" class="btn btn-secondary"><span class="fab fa-twitter text-white mr-md-2"></span> シェア</button>
                        <input type="hidden" name="share" value="">
                    </div>
                    <input type="hidden" name="item_id" value="">
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="modal-footer border-0">
                <button type="button" id="create-review-button" class="btn btn-success w-100">レビューを投稿</button>
            </div>
        </div>
    </div>
</div>
