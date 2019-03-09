<div class="modal fade" id="delete-review-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="row justify-content-center list-unstyled mb-0">
                    <li class="py-4 col-10 text-center">
                        <span class="h5">{{ __('app.sentence.review.confirm') }}</span>
                    </li>
                    <li class="py-4 cursor-pointer text-center col-8">
                        <form name="delete-review" method="post" action="{{ url('/review/delete') }}">
                            @csrf
                            <input type="hidden" name="review_id" id="delete-review-id" value="">
                            <button type="submit" class="btn btn-danger text-white" id="delete-review-button" class="">{{ __('app.button.delete') }}</button>
                        </form>
                    </li>
                    <li class="py-4 cursor-pointer edit-modaln text-center col-8">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{ __('app.button.cancel') }}</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
