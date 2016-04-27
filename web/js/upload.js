var error = 0;
    $('input[type=file]').ace_file_input({
        btn_choose: "Examinar...",
        btn_change: "Cambiar",
        maxSize: 2097152 //~2 MB
    })
    .one('change', function (e) {
       if (error == 0) {
        $(this).parent().parent().parent().find('.ace-file-container').each(function () {
            if ($(this).data('title') == 'Examinar...') {
                $(this).addClass('hidden');
            }
        });
        }
    })

    .one('file.error.ace', function (event, info) {
        if (info.error_list['size'] != '') {
            makeGritter('Alerta', 'El archivo no debe superar los 2 MB', 'warning');
            error=1;
        }
        event.preventDefault();
    });


    $('#formulario_id').on('click', 'input[type=file]', function () {
         var error = 0;
        $(this).ace_file_input({
            btn_choose: "Examinar...",
            btn_change: "Cambiar",
            maxSize: 2097152
        })
            .one('change', function (e) {
               if (error == 0) {
                $(this).parent().parent().parent().find('.ace-file-container').each(function () {
                    if ($(this).data('title') == 'Examinar...') {
                        $(this).addClass('hidden');
                    }
                });
            }

            })

            .one('file.error.ace', function (event, info) {
                if (info.error_list['size'] != '') {
                    error=1;
                    info.error_list['size']='';
                    makeGritter('Alerta', 'El archivo no debe superar los 2 MB', 'warning');
                }

            });

    });
