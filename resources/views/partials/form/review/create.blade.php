<div class="modal fade" id="create-review-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-black border-0">
                <p class="text-white h5-5 mx-auto mb-0">{{ __('app.word.title.review.create') }}</p>
                <button type="button" class="close text-white ml-0 pl-0 font-bold" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-0 p-0">
                <form name="create-review" method="post" action="{{ url('/review/store') }}">
                    @csrf
                    <div class="form-group m-3">
                        <p class="mb-1 h7">{{ __('app.sentence.review.score') }}</p>
                        <div class="row justify-content-center align-items-center">
                            <div id="slider" class="col-9 col-md-9 mx-auto"></div>
                            <span id="slider-count" class="h5-5 text-warning col-2 col-md-2 m-0 font-bold"></span>
                        </div>
                        @if ($errors->has('score'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('score') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group p-2 bg-light-grey">
                        <div class="">
                            <textarea name="content" rows="8"class="border-0 form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"placeholder="{{ __('app.label.review.placeholder') }}" style="resize: none;"></textarea>
                            @if ($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group m-3">
                        <button type="button" id="share-twitter-button" class="btn btn-secondary"><span class="fab fa-twitter text-white mr-2"></span> {{ __('app.button.review.share') }}</button>
                        <input type="hidden" name="share" value="">
                    </div>
                    <input type="hidden" name="score" value="">
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
            <div class="modal-footer border-0 pt-0">
                <button type="button" id="create-review-button" class="btn btn-success w-100 font-bold">{{ __('app.button.review.create') }}</button>
            </div>
        </div>
    </div>
</div>
