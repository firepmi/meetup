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
