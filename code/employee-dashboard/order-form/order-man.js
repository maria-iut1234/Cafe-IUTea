var cloneIndex = 0;

$("#add-menu-btn").click(function () {
  var clone = $(".add-menu:last").clone();

  clone.find(".clear-menu-btn").attr("id", "clear-menu-btn-" + cloneIndex);
  clone.find(".menu-item-adds").attr("id", "menu-item-adds-" + cloneIndex);
  clone.find(".menu-item-size").attr("id", "menu-item-size-" + cloneIndex);
  clone.find(".menu-item-name").attr("id", "menu-item-name-" + cloneIndex);
  clone
    .find(".menu-item-quantity")
    .attr("id", "menu-item-quantity-" + cloneIndex);

  cloneIndex++;

  // Append the cloned section
  $(".menu-items-container").append(clone);

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

