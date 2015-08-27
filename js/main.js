/**
 * Created by a6y on 21.08.15.
 */
var preloader = {
    p : $('#preloader'),
    s : $('#status'),
    Hide: function() {
        this.p.fadeOut();
        this.s.delay(350).fadeOut('slow');
    },
    Show: function() {
        this.p.fadeIn();
        this.s.fadeIn();
    }
}

$( document ).ready(function() {
    $(window).on('load', function () {
        preloader.Hide();
        showSetup();
    });
    var total = 0;
    $( ".file-form" ).each(function() {
            $( this ).validate({
                rules: {
                    csvfile: {
                        required: true,
                        extension: "csv"
                    }
                },
                submitHandler: function(form) {
                    preloader.Show();
                    $(form).ajaxSubmit({
                        success: function(data) {
                            var DATA = JSON.parse(data);
                            if (DATA.Type == 'Error') {
                                $('.result').removeClass().addClass("result text-danger");
                                $('.result').html(DATA.Mess);
                            } else if(DATA.Type == 'OK') {
                                window.location.hash = '#setup';
                                total = DATA.DATA;
                                showSetup();
                                $('.result').removeClass().addClass("result");
                                $('.result').html("");
                            }
                            preloader.Hide();
                        },
                        error: function (response,status,xhr) {
                            $('.result').removeClass().addClass("result text-danger");
                            $('.result').html("error");
                        }
                    });
                }
            });
    });
    function showSetup() {
        if (window.location.hash == '#setup') {
            $('.setup1').hide();
            $('.setup2').show();
        }
    }
    // Start compare
    $('.compare-form').submit(function() {
        // submit the form
        var frm = $(this),
        threads = $('#threads').val(),
        i = -1,
        perc = 0,
            sendData = function (data) {
                preloader.Show();
                i++;
                var DATA = JSON.parse(data);
                if (DATA.Type == 'Error') {
                    $('.result').removeClass().addClass("result text-danger");
                    $('.result').html(DATA.Mess);
                } else if(DATA.Type == 'Ok') {
                    perc = i / Math.ceil(total/threads);
                    $('#status-info .info').html(perc.toFixed(4) * 100 + ' %');
                    // Send form until end of data
                    if (DATA.Data == 1) {
                        $('.result').removeClass().addClass("result");
                        $('.result').html("");
                        frm.ajaxSubmit({
                            success: sendData,
                            error: errorData
                        });
                    } else {
                        preloader.Hide();
                        // Parse done, show results
                        window.location.href = "result.php";
                    }
                }
            },
            errorData = function (response,status,xhr) {
                $('.result').removeClass().addClass("result text-danger");
                $('.result').html("error");
            };
        frm.ajaxSubmit({
            success: sendData,
            error: errorData
        });
        return false;
    });
    // Bootstrap button style
    $('.file-input').bootstrapFileInput();
});