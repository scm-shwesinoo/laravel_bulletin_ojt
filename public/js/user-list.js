$(document).ready(function () {
    setTimeout(function () {
        $(".alert-message .alert").remove();
    }, 3000); // 3 secs

    $('#page_size').on('change', function () {
        var selectedPageSize = $(this).val();
        window.location.href = "/user/list?page_size=" + selectedPageSize;
    });
});

function showUserDetail(userInfo) {
    $("#user-detail #user-name").text(userInfo.name);
    if (userInfo.type == "0") {
        $("#user-detail #user-type").text("Admin");
    } else if (userInfo.type == "1") {
        $("#user-detail #user-type").text("User");
    } else {
        $("#user-detail #user-type").text("Visitor");
    }
    $("#user-detail #user-email").text(userInfo.email);
    $("#user-detail #user-phone").text(userInfo.phone);
    $("#user-detail #user-dob").text(moment(userInfo.dob).format("YYYY/MM/DD"));
    $("#user-detail #user-address").text(userInfo.address);
    $("#user-detail #user-profile").attr(
        "src",
        `../storage/images/${userInfo.profile}`
    );
    $("#user-detail #user-created-at").text(
        moment(userInfo.created_at).format("YYYY/MM/DD")
    );
    $("#user-detail #user-created-user").text(userInfo.created_user);
    $("#user-detail #user-updated-at").text(
        moment(userInfo.updated_at).format("YYYY/MM/DD")
    );
    $("#user-detail #user-updated-user").text(userInfo.updated_user);
}

function showDeleteConfirm(userInfo) {
    console.log('hello');
    console.log(userInfo)
    $("#user-delete #userId").val(userInfo.id);
    $("#user-delete #user-id").text(userInfo.id);
    $("#user-delete #user-name").text(userInfo.name);
    if (userInfo.type == "0") {
        $("#user-delete #user-type").text("Admin");
    } else if (userInfo.type == "1") {
        $("#user-delete #user-type").text("User");
    } else {
        $("#user-delete #user-type").text("Visitor");
    }
    $("#user-delete #user-email").text(userInfo.email);
    $("#user-delete #user-phone").text(userInfo.phone);
    $("#user-delete #user-dob").text(userInfo.dob);
    $("#user-delete #user-address").text(userInfo.address);
}