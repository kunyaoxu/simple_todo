console.log("hello world");

document.getElementById('body').addEventListener("click", bodyClick);
function bodyClick(){
    if(document.getElementById('add_btn').checked){
        document.getElementById('add_btn').checked = false;
    }
}

document.getElementById('add_btn').addEventListener("click", addClick);
function addClick(e){
    e.stopPropagation();
    console.log("hello world");
}

document.getElementById('add_msg').addEventListener("click", addClick);
function addClick(e){
    e.stopPropagation();
}

//document.getElementById('edit_msg').addEventListener("click", addClick);
//function addClick(e){
//    e.stopPropagation();
//}

$("#new_publish").on("submit", function(event) {
//    this.disabled = true;
    event.preventDefault();
//    $("#add_btn").prop("disabled", true);
    $("#publish_btn").prop("disabled", true);
    var title = $('#title_string').val();
    var content = $('#content_string').val();
    $.ajax({
        method: "POST",
        data: { title_string: title, content_string: content},
        success: function (response) {
            //console.log(response);
            if (response.status == 302) {
                location.href = response.location;
            }
        }
    }).done(function(e) {
        //alert( e);
//        $("#add_btn").prop("checked", false);
//        $("#add_btn").prop("disabled", false);
    });
});
