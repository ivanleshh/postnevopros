$(() => {
    $('.post-view').on('click', '.btn-info-modal', function(e) {
        e.preventDefault()
        $('#info-modal').modal('show')
    })
})