console.log("hello world");


$("#save_btn").on("click", function(event) {
//    this.disabled = true;
    $("#edit_msg #submit").prop('disabled', true);
    event.preventDefault();
    var title = $('#title_string').val();
    var content = $('#content_string').val();
    $.ajax({
        method: "POST",
        data: { title_string: title, content_string: content}
    }).done(function(e) {
        //alert( e);
        $("#edit_btn").prop("checked", false);
        $("#edit_msg > *").prop("disabled", true);
    });
});


$("#delete_check .no").on("click", function(event) {
    $("#delete_btn").prop("checked", false);
});

$("#delete_check .yes").on("click", function(event) {
    if($("#delete_btn").prop("checked")){
        $.ajax({
            method: "DELETE",
            success: function (response) {
                //console.log(response);
                if (response.status == 302) {
                    location.href = response.location;
                }
            }
        });
    }
});

$("#edit_btn").on("click", function(event) {
    $("#edit_msg > *").prop("disabled", false);
});


//$('#edit_msg').on('keyup keypress', function(e) {
//  var keyCode = e.keyCode || e.which;
//  if (keyCode === 13) { 
//    e.preventDefault();
//    return false;
//  }
//});