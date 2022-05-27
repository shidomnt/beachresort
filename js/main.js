const deleteBtns = document.querySelectorAll('.delete-btn')
deleteBtns.forEach((btn) => {
  btn.addEventListener('click', function (event) {
    const targetUserName =
      this.closest('tr').querySelector('td:nth-child(2)').innerText
    const check = window.confirm(
      `Ban co chac chan muon xoa ${targetUserName ?? 'user nay'} khong?`
    )
    if (!check) {
      event.preventDefault()
    }
  })
})
