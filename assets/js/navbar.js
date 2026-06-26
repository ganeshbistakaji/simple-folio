document.addEventListener("DOMContentLoaded", () => {
  const navbar = document.querySelector(".navbar")
  const hamburger = document.querySelector(".hamburger")

  hamburger.addEventListener("click", () => {
    navbar.classList.toggle("nav-active")
  })
})
