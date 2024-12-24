$(() => {
    $('.user-form').on('change', '#user-check' , function() {
        $('#user-expire_block').val('')
        if ($('#user-check').prop('checked')) {
            $('#user-expire_block').prop('disabled', false)
            $('#user-expire_block').removeClass('is-valid')

            $('#form-user').yiiActiveForm('add', {"id":"user-expire_block","name":"expire_block","container":".field-user-expire_block","input":"#user-expire_block",
            "error":".invalid-feedback","validate":function (attribute, value, messages, deferred, $form) {yii.validation.required(value, messages, 
            {"message":"Необходимо заполнить «Время блокировки»."});yii.validation.string(value, messages, {"message":"Значение «Время блокировки» должно быть строкой.",
            "max":255,"tooLong":"Значение «Время блокировки» должно содержать максимум 255 символа.","skipOnEmpty":1});}});
        } else {
            $('#user-expire_block').prop('disabled', true)
            $('#user-expire_block').removeClass('is-invalid')
            $('#form-user').yiiActiveForm('remove', "user-expire_block")
        }
    })
})