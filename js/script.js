$(document).ready(function () {
    // плавное перемещение страницы к нужному блоку
    $("ul.menu li").click(function () {
        elementClick = $(this).attr("href");
        destination = $(elementClick).offset().top;
        $("body,html").animate({scrollTop: destination}, 800);
    });


    function showModalForm(classname) {
        let modal = $('.modal-background.' + classname);
        modal.css('z-index', '1');
        modal.css('opacity', '1');
    }

    function hideModalForm(classname) {
        let modal = $('.modal-background.' + classname);
        modal.css('opacity', '0');
        setTimeout(function () {
            modal.css('z-index', '-1');
        }, 500);
    }


    $('.description>.first-button, .contact-desc>.first-button').click(function () {
        showModalForm('modal-vote');
    });
    $('.modal-close.modal-vote').click(function () {
        hideModalForm('modal-vote');
    });

    $('.reforms-footer>.second-button').click(function () {
        showModalForm('modal-reform');
    });

    $('.modal-close.modal-reform').click(function () {
        hideModalForm('modal-reform');
    });

    $('.modal-close.modal-success').click(function () {
        hideModalForm('modal-success');
    });

    $('#send_vote').click(function () {
        if ($('#vote_form')[0].reportValidity()) {
            $.post('save/vote.php', $('#vote_form').serialize())
                .always(function (data) {
                    if (data.error === 0) {
                        hideModalForm('modal-vote');
                        setTimeout(function () {
                            $('#success').html(data.message);
                            showModalForm('modal-success');
                            $('#vote_form')[0].reset();
                        }, 500);
                        return;
                    } else if (data.error === 1) {
                        $('#vote_error').html(data.message);

                    } else {
                        $('#vote_error').html('Неизвестная ошибка');
                    }
                    setTimeout(function () {
                        $('#vote_error').html('');
                    }, 5000);
                });
        }
    });

    $('#send_reform').click(function () {
        if ($('#reform_form')[0].reportValidity()) {
            $.post('save/reform.php', $('#reform_form').serialize())
                .always(function (data) {
                    if (data.error === 0) {
                        hideModalForm('modal-reform');
                        setTimeout(function () {
                            $('#success').html(data.message);
                            showModalForm('modal-success');
                            $('#reform_form')[0].reset();
                        }, 500);
                        return;
                    } else if (data.error === 1) {
                        $('#reform_error').html(data.message);

                    } else {
                        $('#reform_error').html('Неизвестная ошибка');
                    }
                    setTimeout(function () {
                        $('#reform_error').html('');
                    }, 5000);
                });
        }
    });

    $('#send_feedback').click(function () {
        if ($('#feedback_form')[0].reportValidity()) {
            $.post('save/feedback.php', $('#feedback_form').serialize())
                .always(function (data) {
                    if (data.error === 0) {
                        setTimeout(function () {
                            $('#success').html(data.message);
                            showModalForm('modal-success');
                            $('#feedback_form')[0].reset();
                        }, 500);
                        return;
                    } else if (data.error === 1) {
                        $('#feedback_error').html(data.message);

                    } else {
                        $('#feedback_error').html('Неизвестная ошибка');
                    }
                    setTimeout(function () {
                        $('#feedback_error').html('');
                    }, 5000);
                });
        }
    });

});