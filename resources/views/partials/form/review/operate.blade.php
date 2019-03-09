@auth
<div class="modal fade" id="operate-review-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="list-unstyled mb-0">
                    <li class="py-4 cursor-pointer text-center bg-grey-opacity" data-toggle="modal" data-target="#edit-review-modal" data-dismiss="modal">
                        <span id="edit-review-buton">{{ __('app.button.review.edit') }}</span>
                    </li>
                    <li class="py-4 cursor-pointer text-center bg-grey-opacity" data-toggle="modal" data-target="#delete-review-modal" data-dismiss="modal">
                        <span>{{ __('app.button.review.delete') }}</span>
                    </li>
                    <li class="py-4 cursor-pointer text-center bg-grey-opacity" data-dismiss="modal">
                        <span>{{ __('app.button.cancel') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endauth
