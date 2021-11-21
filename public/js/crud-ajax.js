'use strict';

function activeUser(id) {
    var active = $("#active_" + id).val();
    if (active == 1) {
        $("#active_" + id).prop('checked', true);
        document.getElementById("active_" + id).value = 0;

    } else {
        $("#active_" + id).prop('checked', false);
        document.getElementById("active_" + id).value = 1;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: app_url + "/users/" + id,
        type: 'POST',
        data: { _token: $('meta[name="csrf-token"]').attr('content'), '_method': 'PUT', active: active, id: id },
        async: false,
        success: function(data) {
            var obj = JSON.parse(data);
            showNotification('top', 'center', "primary", 'Success',
                obj.msg);
        },
        error: function(error) {
            showNotification('top', 'center', "danger", 'Error', obj.msg);
        }
    });
}

function modelActive(id, url) {
    var active = $("#active_" + id).val();
    if (active == 1) {
        $("#active_" + id).prop('checked', true);
        document.getElementById("active_" + id).value = 0;

    } else {
        $("#active_" + id).prop('checked', false);
        document.getElementById("active_" + id).value = 1;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: app_url + "/" + url + "-active",
        type: 'POST',
        data: { _token: $('meta[name="csrf-token"]').attr('content'), active: active, id: id },
        async: false,
        success: function(data) {
            var obj = JSON.parse(data);
            showNotification('top', 'center', "primary", 'Success',
                obj.msg);
        },
        error: function(error) {
            showNotification('top', 'center', "danger", 'Error', obj.msg);
        }
    });
}

function modelStatus(id, url) {
    var status = $("#status_" + id).val();
    if (status == 1) {
        $("#status_" + id).prop('checked', true);
        document.getElementById("status_" + id).value = 0;

    } else {
        $("#status_" + id).prop('checked', false);
        document.getElementById("status_" + id).value = 1;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: app_url + "/" + url + "-status",
        type: 'POST',
        data: { _token: $('meta[name="csrf-token"]').attr('content'), status: status, id: id },
        async: false,
        success: function(data) {
            var obj = JSON.parse(data);
            showNotification('top', 'center', "primary", 'Success',
                obj.msg);
        },
        error: function(error) {
            showNotification('top', 'center', "danger", 'Error', obj.msg);
        }
    });
}

function showNotification(placementFrom, placementAlign, type, title = "", text = "") {
    $.notify({
        title: title,
        message: text,
        target: "_blank"
    }, {
        element: "body",
        position: null,
        type: type,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: placementFrom,
            align: placementAlign
        },
        offset: 20,
        spacing: 10,
        z_index: 1031,
        delay: 4000,
        timer: 2000,
        url_target: "_blank",
        mouse_over: null,
        animate: {
            enter: "animated fadeInDown",
            exit: "animated fadeOutUp"
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: "class",
        template: '<div data-notify="container" class="col-11 col-sm-3 alert  alert-{0} " role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            "</div>" +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            "</div>"
    });
}

function deleteModel(id, url) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: app_url + "/" + url + "/" + id,
        type: 'Delete',
        async: false,
        success: function(data) {
            if (data == 1) {
                $("#row_" + id).fadeOut(1500)
                showNotification('top', 'center', "primary", 'Success', 'Field has Been Delete');
            } else {
                showNotification('top', 'center', "danger", 'Success', 'Cant Find Record');

            }
            $(".delete_Modal_" + id).modal('hide')
        },
        error: function(request, status, error) {
            showNotification('top', 'center', "danger", 'Something Went wrong');
            $(".delete_Modal_" + id).modal('hide')


        }
    });

}

function acceptProject(id) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: app_url + "/accept-project/" + id,
        type: 'POST',
        async: false,
        success: function(data) {
            var obj = JSON.parse(data);
            showNotification('top', 'center', "primary", 'Success', obj.msg);
            $("#row_" + id).fadeOut(1500)
        },
        error: function(request, status, error) {
            showNotification('top', 'center', "danger", 'Something Went wrong');
        }
    });

}

function changeProjectStatus(id, status) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: app_url + "/project-status/" + id,
        type: 'POST',
        data: { status: status, _token: $('meta[name="csrf-token"]').attr('content') },
        async: false,
        success: function(data) {
            var obj = JSON.parse(data);
            showNotification('top', 'center', "primary", 'Success', obj.msg);
            $("#row_" + id).fadeOut(1500)
        },
        error: function(request, status, error) {
            showNotification('top', 'center', "danger", 'Something Went wrong');
        }
    });

}

function rejectProject(id) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: app_url + "/reject-project/" + id,
        type: 'POST',
        async: false,
        success: function(data) {
            var obj = JSON.parse(data);
            showNotification('top', 'center', "primary", 'Success', obj.msg);
            $("#row_" + id).fadeOut(1500)
        },
        error: function(request, status, error) {
            showNotification('top', 'center', "danger", 'Something Went wrong');
        }
    });

}