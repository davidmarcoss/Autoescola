$(document).ready(function(){
    $('#test-form').submit(function(e){
        e.preventDefault();
        // Comprovar si s'han respos totes les preguntes.


        // Enviar les respostes per AJAX a un controlador per que comprovi les respostes i tornar la resposta.
        //var data = new FormData($(this)[0]);
        var data = $(this).serializeArray();
        $.ajax({
            url: site_url,
            type: 'POST',
            //dataType: 'json',
            data: data,
            success: (function (response) {
                console.info(response);
            }),
            error: (function (error) {
                alert("Fail: " + error);
            })
        });
    });
});