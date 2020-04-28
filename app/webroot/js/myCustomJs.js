var BASE_URL = "http://3.8.95.229/admin/Dashboard/";
function deleteMes(id, modelName) {
  //var whichtr = $(this).closest("tr");
  var whichtr = $(this).parent().parent().parent().remove();
  alert("worked"); // Alert does not work
  whichtr.remove();
  return false;
  $.ajax({
    url: BASE_URL + "delete_data",
    //dataType:'JSON',
    type: "post",
    data: { id: id, modelName: modelName },
    success: function (result) {
      var json = $.parseJSON(result); // create an object with the key of the array
      alert($(this).parent().parent().parent().html());
      return false;
      /* if(json.status=="1")  
			{
				$(this).parent().parent().parent().remove();
			}
			 else{
				 alert("no deleted");
			 }  */
    },
  });
}

$(document).on("click", ".deleteMe", function () {
  if (!confirm("Are you sure to delete this user?")) {
    return;
  }
  var whichtr = $(this).parent().parent().parent().remove();
  whichtr.remove();
  var id = $(this).attr("id");
  var modelName = $(this).attr("modelName");
  $.ajax({
    url: BASE_URL + "delete_data",
    //dataType:'JSON',
    type: "post",
    data: { id: id, modelName: modelName },
    success: function (result) {
      var json = $.parseJSON(result); // create an object with the key of the array
      if (json.status == "1") {
        $(".forSuccess").removeClass("hide");
        $(".message").text(json.message);
      } else {
        $(".forError").removeClass("hide");
        $(".message").text(json.message);
      }
    },
  });
});

$(document).on("click", ".deleteVideo", function () {
  if (!confirm("Are you sure to remove this video?")) {
    return;
  }
  var id = $(this).attr("id");
  var modelName = $(this).attr("modelName");
  $.ajax({
    url: BASE_URL + "delete_video",
    //dataType:'JSON',
    type: "post",
    data: { id: id, modelName: modelName },
    success: function (result) {
      var json = $.parseJSON(result); // create an object with the key of the array
      if (json.status == "1") {
        $(".forSuccess").removeClass("hide");
        $(".message").text(json.message);
        location.reload();
      } else {
        $(".forError").removeClass("hide");
        $(".message").text(json.message);
      }
    },
  });
});

$(document).on("ready", function () {
  $(".emailTo").on("click", function () {
    if (this.checked == true && this.value == 1) {
      $("input[name='mailUsers']").prop("disabled", true);
    } else {
      $("input[name='mailUsers']").prop("disabled", false);
    }
  });
});
