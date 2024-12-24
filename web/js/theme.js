$(() => {
    $('.post-form').on('change', '#post-check', function(){
        $('#post-theme_id option:first').prop('selected', true)
        if ($('#post-check').prop('checked')) {
            $('#post-other_theme').prop('disabled', false)
            $('#post-theme_id').removeClass('is-invalid')
            $('#post-other_theme').removeClass('is-valid')

            $('#form-post').yiiActiveForm('remove', 'post-theme_id')
            $('#form-post').yiiActiveForm('add', {"id":"post-other_theme","name":"other_theme","container":".field-post-other_theme","input":"#post-other_theme",
            "error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, 
            {"message":"Необходимо заполнить «своя тема поста»."});yii.validation.string(value, messages, {"message":"Значение «своя тема поста» должно быть строкой.",
            "max":255,"tooLong":"Значение «своя тема поста» должно содержать максимум 255 символа.","skipOnEmpty":1});}});
        } else {
            $('#post-theme_id').removeClass('is-valid')
            $('#post-other_theme').removeClass('is-invalid')
            $('#post-other_theme').prop('disabled', true)
            $('#post-other_theme').val('')

            $('#form-post').yiiActiveForm('remove', 'post-other_theme')
            $('#form-post').yiiActiveForm('add', {"id":"post-theme_id","name":"theme_id","container":".field-post-theme_id","input":"#post-theme_id",
            "error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, 
            {"message":"Необходимо заполнить «тема поста»."});yii.validation.number(value, messages, {"pattern":/^[+-]?\d+$/,"message":
            "Значение «тема поста» должно быть целым числом.","skipOnEmpty":1});}});
        }
    })
})