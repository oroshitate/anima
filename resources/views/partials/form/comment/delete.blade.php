<div class="modal fade" id="delete-comment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="row justify-content-center list-unstyled mb-0">
                    <li class="py-md-4 col-md-10 text-center">
                        <span class="h5">コメントを削除してもよろしいですか？</span>
                    </li>
                    <li class="py-md-4 cursor-pointer text-center col-md-8">
                        <form name="delete-comment" method="post" action="{{ url('/comment/delete') }}">
                            @csrf
                            <input type="hidden" name="comment_id" id="delete-comment-id" value="">
                            <button type="submit" id="delete-comment-button" class="btn btn-danger text-white">削除する</button>
                        </form>
                    </li>
                    <li class="py-md-4 cursor-pointer edit-modaln text-center col-md-8" data-dismiss="modal">
                        <button type="button" class="btn btn-outline-secondary">キャンセル</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
