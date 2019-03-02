$(function(){
    $('#upload-image').change(
        function () {
            if (!this.files.length) {
                return;
            }
            var preview = $('img#user-image');
            var file = $(this).prop('files')[0];
            var file_reader = new FileReader();
            file_reader.addEventListener("load", function () {
                preview.attr("src", file_reader.result);
            }, false);

            if (file) {
                file_reader.readAsDataURL(file);
            }
        }
    );
});
