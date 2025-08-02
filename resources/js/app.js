import './bootstrap';

// Auto-hide alerts after 5 seconds
document.addEventListener("DOMContentLoaded", () => {
    const alerts = document.querySelectorAll('[role="alert"]')

    alerts.forEach((alert) => {
      setTimeout(() => {
        alert.style.transition = "opacity 0.5s ease-out"
        alert.style.opacity = "0"

        setTimeout(() => {
          alert.remove()
        }, 500)
      }, 5000)
    })
  })

  // Confirm delete actions
  window.confirmDelete = (message = "Are you sure you want to delete this item?") => confirm(message)

  // Auto-resize textareas
  document.addEventListener("DOMContentLoaded", () => {
    const textareas = document.querySelectorAll("textarea")

    textareas.forEach((textarea) => {
      textarea.addEventListener("input", function () {
        this.style.height = "auto"
        this.style.height = this.scrollHeight + "px"
      })
    })
  })
