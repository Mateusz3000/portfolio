$(document).ready(function () {
	var infoDisplayer = $(".formMessage");
	var form = $("#form");


	form.on('submit', function (e) {
        $.ajax({
                url: "mail.php",
                dataType: "JSON",
                type: "post",
                data:$(this).serialize(),
                beforeSend: function(){
                    infoDisplayer.hide();
                    infoDisplayer.removeClass("ok error");
                    infoDisplayer.text('trwa wysyłanie danych...').fadeIn(300);
                    console.log("test");
                },
                success: function (obj) {
                    if (obj.type == "ok")
                    {
                        infoDisplayer.addClass("ok").removeClass("error").html(obj.text).delay(4000).fadeOut(500);
                        form.get(0).reset();
                    } else
                    {
                       infoDisplayer.addClass("error").removeClass("ok").html(obj.text);
                    }
                },

                error : function () {
                    infoDisplayer.addClass("error").removeClass("ok").html("Wystąpił błąd podczas wysyłania informacji.");
                },
                complete: function () {
                   infoDisplayer.fadeIn();
                }
           });
		e.preventDefault();
	});
});
