$(document).ready(function () {
  // Alert on gallery thumbnail click
  $(".img-thumbnail").on("click", function () {
    alert("Viewing details for this stage.");
  });

  // Confirm before deleting records (admin functionality)
  $(".delete-btn").on("click", function () {
    return confirm("Are you sure you want to delete this record?");
  });
});
