document.addEventListener("DOMContentLoaded", () => {
  document
    .getElementById("query-form-nav")
    .addEventListener("submit", function (e) {
      e.preventDefault()

      const message = document.getElementById("query-nav-msg").value.trim()

      const subject = "Regarding General Query"
      const mailtoUrl = `mailto:ganeshbistakaji@gmail.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(message)}`

      const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=ganeshbistakaji@gmail.com&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(message)}`

      window.location.href = mailtoUrl

      setTimeout(() => {
        const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent)

        if (isMobile) {
          window.location.href = gmailUrl
        } else {
          window.open(gmailUrl, "_blank")
        }
      }, 1500)
    })
})
