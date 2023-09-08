

const hamburer = document.querySelector(".hamburger");
const navList = document.querySelector(".nav-list");

if (hamburer) {
  hamburer.addEventListener("click", () => {
    navList.classList.toggle("open");
  });
}

// Popup
const popup = document.querySelector(".popup");
const closePopup = document.querySelector(".popup-close");

if (popup) {
  closePopup.addEventListener("click", () => {
    popup.classList.add("hide-popup");
  });

  window.addEventListener("load", () => {
    setTimeout(() => {
      popup.classList.remove("hide-popup");
    }, 1000);
  });
}

function toggleShopDropdown() {
  var shopDropdown = document.getElementById("shopDropdown");
  if (shopDropdown.style.display === "block") {
    shopDropdown.style.display = "none";
  } else {
    shopDropdown.style.display = "block";
  }
}





// Hero Carousel
