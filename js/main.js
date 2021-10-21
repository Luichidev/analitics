var fileInput = document.querySelectorAll(".input-file"),
  button = document.querySelector(".input-file-trigger");

button.addEventListener("keydown", function (event) {
  if (event.keyCode == 13 || event.keyCode == 32) {
    fileInput.focus();
  }
});
button.addEventListener("click", function (event) {
  fileInput.focus();
  return false;
});

fileInput.forEach((input) => {
  input.addEventListener("change", function (event) {
    switch (this.name) {
      case "user_upload":
        return_user.innerHTML = this.value;
        break;
      case "npages_upload":
        return_npages.innerHTML = this.value;
        break;
      case "lastUrl_upload":
        return_lastUrl.innerHTML = this.value;
        break;
      case "mostUrl_upload":
        return_mostUrl.innerHTML = this.value;
        break;
    }
  });
});
