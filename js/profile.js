// open/close modal-edit
const btnEdit = document.querySelector(".edit-btn");
const modalEdit = document.querySelector(".modal-edit");
const wrapperEdit = document.querySelector(".wrapper-edit");
const iconCloseEdit = document.querySelector(".icon-close-edit");

btnEdit.addEventListener("click", () => {
  modalEdit.classList.add("open");
});
iconCloseEdit.addEventListener("click", () => {
  modalEdit.classList.remove("open");
});

modalEdit.addEventListener("click", () => {
  modalEdit.classList.remove("open");
});
wrapperEdit.addEventListener("click", function (event) {
  event.stopPropagation();
});
