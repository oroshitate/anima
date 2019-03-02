<div class="modal fade" id="delete-review-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="row justify-content-center list-unstyled mb-0">
                    <li class="py-md-4 col-md-10 text-center">
                        <span class="h5">レビューを削除してもよろしいですか？</span>
                    </li>
                    <li class="py-md-4 cursor-pointer text-center col-md-8">
                        <form name="delete-review" method="post" action="{{ url('/review/delete') }}">
                            @csrf
                            <input type="hidden" name="review_id" id="delete-review-id" value="">
                            <button type="submit" class="btn btn-danger text-white" id="delete-review-button" class="">レビューを削除する</button>
                        </form>
                    </li>
                    <li class="py-md-4 cursor-pointer edit-modaln text-center col-md-8">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">キャンセル</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
