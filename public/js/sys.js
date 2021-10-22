// -- ----------------------------------------------------------------------------
// -- ALERTAS
// -- ----------------------------------------------------------------------------

// Confirmação de Exclusão - @runConfirmDelete (Apelido)

var runConfirmDelete = function(){ swalAlert('.btn-delete', 1); };

// Confirmação de Cancelamento - @runConfirmCancel (Apelido)

var runConfirmCancel = function(){ swalAlert('.btn-cancel', 0); };

// Renderização das propriedades do plugin (swal)

var swalAlert = function (element, showCancel){

    $(document).on('click', element, function () {

        var href = $(this).attr('href');

        var sa_title = $(this).data('sa-title');
        var sa_message = $(this).data('sa-message');
        var sa_confirmButtonText = $(this).data('sa-confirmbuttontext');
        var sa_cancelButtonText = $(this).data('sa-cancelbuttontext');
        var sa_popupTitleCancel = $(this).data('sa-popuptitlecancel');
        var sa_popupMessageCancel = '';
        var sa_type = $(this).data('sa-type');
        var sa_allowOutsideClick = false;
        var sa_showConfirmButton = true;
        var sa_showCancelButton = true;

        Swal.fire({
            title: sa_title,
            text: sa_message,
            icon: sa_type,
            allowOutsideClick: sa_allowOutsideClick,
            showConfirmButton: sa_showConfirmButton,
            showCancelButton: sa_showCancelButton,
            confirmButtonText: sa_confirmButtonText,
            cancelButtonText: sa_cancelButtonText,
            confirmButtonColor: "#6cc788",
            cancelButtonColor: "#f44455"
        }).then((result) => {
            if(result.value){
                window.location.href = href;
            }
        });
    });

};
