var cloneIndex = 0;

$("#add-menu-btn").click(function () {
  var clone = $(".add-menu:last").clone();

  clone.find(".clear-menu-btn").attr("name", "clear-menu-btn-" + cloneIndex);
  clone.find(".menu-item-adds").attr("name", "menu-item-adds-" + cloneIndex);
  clone.find(".menu-item-size").attr("name", "menu-item-size-" + cloneIndex);
  clone.find(".menu-item-name").attr("name", "menu-item-name-" + cloneIndex);
  clone
    .find(".menu-item-quantity")
    .attr("name", "menu-item-quantity-" + cloneIndex);

  cloneIndex++;

  // Append the cloned section
  $(".menu-items-container").append(clone);

  //set value of hidden div
  var divElement = document.getElementById("menu-item-counter");
  divElement.value = cloneIndex;

  console.log(divElement.value);

  // $(document).ready(function () {
  //   $("#menu-item-name-" + cloneIndex).chosen({
  //     width: "35%",
  //   });
  
  // });
  

  // Show the cloned section
  clone.show();
});

$(document).on("click", ".clear-menu-btn", function () {
  $(this).closest(".add-menu").remove();
});

// $(document).ready(function () {
//   $(".menu-item-name").chosen({
//     width: "35%",
//   });
// });

