$(document).ready(function () {

});

setTimeout(function() {
  $(".custom-social-proof")
    .stop()
    .slideToggle("slow");
}, 8000);
$(".custom-close").click(function() {
  $(".custom-social-proof")
    .stop()
    .slideToggle("slow");
});


function ajaxForm(sform_id) {
    var sform = $('#' + sform_id);
    var parent_class = "." + sform.parent().attr("class");
    var action_url = sform.attr('action');
    var method = sform.attr('method');
    var variables = sform.find('select, textarea, input').serialize();
    Notiflix.Block.Standard(parent_class, 'Loading...');
    $.post(action_url, variables).done(function (data) {
        Notiflix.Block.Remove(parent_class, 600);
        console.log(data);
        var obj = JSON.parse(data);
        if (obj.icon == 'success') {
            Notiflix.Report.Success(
                '',
                obj.title,
                'OK'
            );
        } else if (obj.icon == 'warning') {
            Notiflix.Report.Warning(
                '',
                obj.title,
                'OK'
            );
        } else if (obj.icon == 'info') {
            Notiflix.Report.Info(
                '',
                obj.title,
                'OK'
            );
        } else {
            Notiflix.Report.Failure(
                '',
                obj.title,
                'OK'
            );
        }
        if (obj.confirm_area) {
            $('#' + sform_id + ' #add_area').html(obj.confirm_area);
        }

        if (obj.redirect) {
            window.location.replace(obj.redirect);
        }

    });
}

window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website","dismiss":"Accept","learnMore":"Learn more","link":"https://en.wikipedia.org/wiki/HTTP_cookie","theme":"dark-top"};