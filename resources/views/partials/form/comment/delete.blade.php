<div class="modal fade" id="delete-comment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="row justify-content-center list-unstyled mb-0">
                    <li class="py-4 col-10 text-center">
                        <span class="h5">{{ __('app.sentence.comment.confirm') }}</span>
                    </li>
                    <li class="py-4 cursor-pointer text-center col-8">
                        <form name="delete-comment" method="post" action="{{ url('/comment/delete') }}">
                            @csrf
                            <input type="hidden" name="comment_id" id="delete-comment-id" value="">
                            <button type="submit" id="delete-comment-button" class="btn btn-danger text-white">{{ __('app.button.delete') }}</button>
                        </form>
                    </li>
                    <li class="py-4 cursor-pointer edit-modaln text-center col-8" data-dismiss="modal">
                        <button type="button" class="btn btn-outline-secondary">{{ __('app.button.cancel') }}</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
