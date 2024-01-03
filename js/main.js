// login-register
const btnLogin = document.querySelector(".btnLogin");
const btnRegister = document.querySelector(".btnRegister");
const modalLogIn = document.querySelector(".modal-login");
const modalRegister = document.querySelector(".modal-register");

btnLogin.addEventListener("click", () => {
  modalLogIn.classList.add("open");
});
btnRegister.addEventListener("click", () => {
  modalRegister.classList.add("open");
});

const iconCloseLogin = document.querySelector(".icon-close-login");
const iconCloseRegister = document.querySelector(".icon-close-register");

iconCloseLogin.addEventListener("click", () => {
  modalLogIn.classList.remove("open");
});
iconCloseRegister.addEventListener("click", () => {
  modalRegister.classList.remove("open");
});

const wrapperLogin = document.querySelector(".wrapper-login");
const wrapperRegister = document.querySelector(".wrapper-register");

modalLogIn.addEventListener("click", () => {
  modalLogIn.classList.remove("open");
});
modalRegister.addEventListener("click", () => {
  modalRegister.classList.remove("open");
});
wrapperLogin.addEventListener("click", function (event) {
  event.stopPropagation();
});
wrapperRegister.addEventListener("click", function (event) {
  event.stopPropagation();
});

const registerLink = document.querySelector(".register-link");
const loginLink = document.querySelector(".login-link");

registerLink.addEventListener("click", () => {
  modalLogIn.classList.remove("open");
  modalRegister.classList.add("open");
});
loginLink.addEventListener("click", () => {
  modalRegister.classList.remove("open");
  modalLogIn.classList.add("open");
});

// scroll and gotop
window.onscroll = function () {
  console.info(document.documentElement.scrollTop);
  var header = document.querySelector(".header");
  var gotopbtn = document.querySelector(".gotopbtn");

  if (document.documentElement.scrollTop > 50 || document.body.scrollTop > 50) {
    header.style.position = "fixed";
    header.style.top = 0;
    header.style.margin = "0 0";
    header.style.width = "100%";
    header.style.background = "linear-gradient(45deg, #4366c5, #5d85d4)";
    header.style.boxShadow = "0px 0px 15px rgba(0, 0, 0, 0.4)";
    header.style.borderRadius = "0 0 12px 12px";
    header.style.zIndex = 3;

    gotopbtn.style.display = "flex";
  } else {
    header.style.position = "absolute";
    header.style.margin = "0 0";
    header.style.width = "100%";
    header.style.background = "rgba(0, 0, 0, 0.1)";
    header.style.boxShadow = "0px 0px 0px 0px";
    header.style.borderRadius = "0";

    gotopbtn.style.display = "none";
  }
};

// slideshow
var myIndex = 0;
carousel();
function carousel() {
  var i;
  var x = document.getElementsByClassName("slide-image");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  myIndex++;
  if (myIndex > x.length) myIndex = 1;
  x[myIndex - 1].style.display = "block";
  setTimeout(carousel, 5000);
}

// slick slider
$(document).ready(function () {
  $(".list-fd").slick({
    infinite: true,
    slidesToShow: 3,
    dots: false,
    autoplay: false,
    cssEase: "linear",
    swipeToSlide: true,
    arrows: true,
    prevArrow:
      "<button type='button' class='slick-prev pull-left'><i class='fa-light fa-chevron-left'></i></button>",
    nextArrow:
      "<button type='button' class='slick-next pull-right'><i class='fa-light fa-chevron-right'></i></button>",
  });
});
