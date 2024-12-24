$(() => {
    $('#user-block-pjax').on('click', '.btn-block-modal', function(e) {
        e.preventDefault()
        $('#form-user').attr('action', $(this).attr('href'))
        $('#user-check').prop('checked', false)
        $('#user-expire_block').val('')
        $('#block-modal').modal('show')
    })

    $('#form-block-pjax').on('click', '.btn-modal-close', function(e) {
        e.preventDefault()
        $('#block-modal').modal('hide')
    })

    $('#form-block-pjax').on('pjax:end', function() {
        $('#block-modal').modal('hide')
        $.pjax.reload('#user-block-pjax')
    })
})