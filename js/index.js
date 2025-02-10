//  Bootstrap form validation
function check_validation(){
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })();
};

$(document).ready(function () {
    $('#reg-btn').on('click', function () {
        window.location.href = 'singin.html'
    });

    $('#singup-btn').on('click', function () {
        window.location.replace('singup.html');
    });

    $('#singin-btn').on('click', function () {
        window.location.replace('singin.html');
    });

    $('#close-btn').on('click', function () {
        window.location.replace('index.html');
    });

    $('.see-more-btn').on('click', function () {
        $(this).parent().parent().siblings().addClass('d-none');
        $(this).addClass('d-none');
        $(this).siblings('.btn').removeClass("d-none");
    });

    $('.view-all-btn').on('click', function () {
        $(this).parent().parent().siblings().removeClass('d-none');
        $(this).siblings('.btn').removeClass("d-none");
        $(this).addClass('d-none');
    });

    //  On Read Open pdf in a new tab
    // $('.custom-read-btn').on('click', function () {
    //     var book_name = $(this).attr('bookName');
    //     window.open(`${book_name}`,'_blank');
    // });
});