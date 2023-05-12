function ConfirmDelete(id) {
  if (confirm("Delete Account?")) {
    location.href = "delete.php?pid=" + id;
  }
}
function editSuccess() {
  alert("Edit Successful!");
  location.href = "index.php";
  window.location.href = "index.php";
  location.assign("index.php");
  location.replace("index.php");
}
