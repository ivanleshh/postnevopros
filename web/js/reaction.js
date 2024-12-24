$(() => {
    $('#posts-pjax').on('click', '.btn-reaction', function(event) {
        event.preventDefault()
        const a = $(this)
        const cover = a.closest('.cover')
        console.log(cover.find('.count-likes'))
        $.ajax({
            url: a.attr('href'),
            success(data) {
                cover.find('.count-likes').text(data.likes)
                cover.find('.count-dislikes').text(data.dislikes)
            },
        })
    })

    $('#post-pjax').on('click', '.btn-reaction', function(event) {
        event.preventDefault()
        const a = $(this)
        const cover = a.closest('.cover')
        $.ajax({
            url: a.attr('href'),
            success(data) {
                cover.find('.count-likes').text(data.likes)
                cover.find('.count-dislikes').text(data.dislikes)
            },
        })
    })
})