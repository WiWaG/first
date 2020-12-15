$(document).ready(function() {
    $('form[name="frmRegister"]').on('submit', function() {
        $('form[name="frmRegister"] input[type="submit"]').prop('disabled', true)
        $.post('../app/controllers/UserController.php', $(this).serialize(), function(data, status) {
            if (status === 'success') {
                $('form[name="frmRegister"] input[type="submit"]').prop('disabled', false)
                const result = JSON.parse(data)
                if (result.error === true) {
                    $('#register-message').html(result.message).show()
                    return false;
                }

                console.log('Ok :-)')
            } else {
                $('#register-message').html(result.message).show()
            }
        })
    })

    $('#register-cancel').on('click', function() {
        console.log('canceling...')
    })
})