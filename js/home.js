// open/close icon-user
const jsBtnUser = document.querySelector(".js-icon-person");
const modalUser = document.querySelector(".subnav-user");

document.addEventListener("click", function (event) {
  if (event.target !== jsBtnUser && event.target !== modalUser) {
    modalUser.classList.remove("open");
  }
});

jsBtnUser.addEventListener("click", () => {
  modalUser.classList.toggle("open");
});

// open/close modal-create
const btnCreate = document.querySelector(".btnCreate");
const modalCreate = document.querySelector(".modal-create");
const iconCloseCreate = document.querySelector(".icon-close-create");
const wrapperCreate = document.querySelector(".wrapper-create");

btnCreate.addEventListener("click", () => {
  modalCreate.classList.add("open");
});
iconCloseCreate.addEventListener("click", () => {
  modalCreate.classList.remove("open");
});

modalCreate.addEventListener("click", () => {
  modalCreate.classList.remove("open");
});
wrapperCreate.addEventListener("click", function (event) {
  event.stopPropagation();
});

// open/close modal-display-img
const cardBtns = document.querySelectorAll(".card-box");
const modalDisplay = document.querySelector(".modal-display");
const wrapperDisplay = document.querySelector(".wrapper-display");
const iconCloseDisplay = document.querySelector(".icon-close-display");

function showModalDisplay() {
  modalDisplay.classList.add("open");
}
function hideModalDisplay() {
  modalDisplay.classList.remove("open");
}

for (const cardBtn of cardBtns) {
  cardBtn.addEventListener("click", showModalDisplay);
}

iconCloseDisplay.addEventListener("click", hideModalDisplay);

modalDisplay.addEventListener("click", hideModalDisplay);
wrapperDisplay.addEventListener("click", function (event) {
  event.stopPropagation();
});

// Upload img
window.addEventListener("DOMContentLoaded", (event) => {
  const imageInput = document.getElementById("imageInput");
  const imageContainer = document.getElementById("imageContainer");

  let currentImage; // Lưu trữ thông tin ảnh hiện tại

  imageInput.addEventListener("change", (event) => {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = (e) => {
      // Kiểm tra xem đã có ảnh hiện tại trong imageContainer chưa
      if (currentImage) {
        imageContainer.removeChild(currentImage); // Xóa ảnh hiện tại
      }

      const image = document.createElement("img");
      image.src = e.target.result;
      imageContainer.appendChild(image);

      currentImage = image; // Cập nhật ảnh hiện tại

      const divElement = document.getElementById("none-div");
      divElement.style.display = "none";
    };

    reader.readAsDataURL(file);
  });
});
