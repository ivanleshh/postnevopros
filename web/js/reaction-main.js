$(() => {
    $('#posts-pjax-main').on('click', '.btn-reaction', function(event) {
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

    $('#post-pjax-main').on('click', '.btn-reaction', function(event) {
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