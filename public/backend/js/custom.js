/*-----------------------------------------------------------------------------------*/
/*  NOTIFY
/*-----------------------------------------------------------------------------------*/
function notifyAppError(error) {
    notifyAppError(error, "body");
}

function notifyAppError(error, el) {
    $.alert({
        title: "<i class='fa fa-exclamation-circle'></i> Error ",
        content: error,
        type: "red",
        typeAnimated: true,
    });
}

function notifySystemError(error) {
    notifySystemError(error, "body");
}

function notifySystemError(error, el) {
    $.alert({
        title: "<i class='fa fa-exclamation-circle'></i> Error ",
        content: error,
        type: "red",
        typeAnimated: true,
    });
}

function notifyError(error) {
    notifyError(error, "body");
}

function notifyError(error, el) {
    $.alert({
        title: "<i class='fa fa-exclamation-circle'></i> Error ",
        content: error,
        type: "red",
        typeAnimated: true,
    });
}

function notifySuccess(msg) {
    notifySuccess(msg, "body");
}

function notifySuccess(msg, el) {
    $.alert({
        title: "<i class='fa fa-exclamation-circle'></i> Success ",
        content: msg,
        type: "green",
        typeAnimated: true,
    });
}

/*-----------------------------------------------------------------------------------*/
/*  BUTTON SPINNER
/*-----------------------------------------------------------------------------------*/
function startSpin(el) {
    el.data("ori", el.html());
    el.html('<i class="fa fa-spinner"></i>');
    el.addClass("disabled");
}

function stopSpin(el) {
    el.html(el.data("ori"));
    el.removeClass("disabled");
}

(function ($) {
    "use strict";
    $(".dropify").dropify();
    $(".datetimepicker").datetimepicker({
        format: "YYYY-MM-DD HH:mm",
    });
    $(".datepicker").datetimepicker({
        format: "L",
    });
    $(".date").datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
    });
    $(".select2").select2();
})(jQuery);
