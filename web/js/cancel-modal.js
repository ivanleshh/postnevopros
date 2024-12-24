$(() => {
    $('#admin-posts-pjax').on('click', '.btn-cancel-modal', function(e) {
        e.preventDefault()
        $('#form-cancel').attr('action', $(this).attr('href'))
        $('#post-cancel_reason').val('')
        $('#cancel-modal').modal('show')
    })

    $('#form-cancel-pjax').on('click', '.btn-modal-close', function(e) {
        e.preventDefault()
        $('#cancel-modal').modal('hide')
    })

    $('#form-cancel-pjax').on('pjax:end', function() {
        $('#cancel-modal').modal('hide')
        $.pjax.reload('#admin-posts-pjax')
    })
})