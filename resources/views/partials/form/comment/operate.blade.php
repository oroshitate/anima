<div class="modal fade" id="operate-comment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="list-unstyled mb-0">
                    <li id="edit-comment-footer-button" class="py-4 cursor-pointer text-center bg-grey-opacity" data-dismiss="modal">
                        <span>{{ __('app.button.comment.edit') }}</span>
                    </li>
                    <li class="py-4 cursor-pointer text-center bg-grey-opacity" data-toggle="modal" data-target="#delete-comment-modal" data-dismiss="modal">
                        <span>{{ __('app.button.comment.delete') }}</span>
                    </li>
                    <li class="py-4 cursor-pointer text-center bg-grey-opacity" data-dismiss="modal">
                        <span>{{ __('app.button.cancel') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
