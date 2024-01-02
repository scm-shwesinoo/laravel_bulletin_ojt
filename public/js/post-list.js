$(document).ready(function () {
  setTimeout(function () {
    $(".alert-message .alert").remove();
  }, 3000); // 3 secs

  $('#page_size').on('change', function () {
    var selectedPageSize = $(this).val();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const search = urlParams.get('search')
    if (search) {
      window.location = "/post/list?search=" + search + "&page_size=" + selectedPageSize;
    } else {
      window.location = "/post/list?page_size=" + selectedPageSize;
    }
  });

  // $('#search-keyword').on('keyup', function () {
  //   let empty = false;

  //   $('#search-keyword').each(function () {
  //     empty = $(this).val().trim().length == 0;
  //   });

  //   if (empty)
  //     $('#search-click').attr('disabled', 'disabled');
  //   else
  //     $('#search-click').attr('disabled', false);
  // });
});

function showPostDetail(postInfo) {
  $("#post-detail #post-title").text(postInfo.title);
  $("#post-detail #post-description").text(postInfo.description);
  if (postInfo.status == "0") {
    $("#post-detail #post-status").text("Inactive");
  } else {
    $("#post-detail #post-status").text("Active");
  }
  $("#post-detail #post-created-at").text(
    moment(postInfo.created_at).format("YYYY/MM/DD")
  );
  $("#post-detail #post-created-user").text(postInfo.created_user);
  $("#post-detail #post-updated-at").text(
    moment(postInfo.updated_at).format("YYYY/MM/DD")
  );
  $("#post-detail #post-updated-user").text(postInfo.updated_user);
}

function showDeleteConfirm(postInfo) {
  $("#post-delete #postId").val(postInfo.id);
  $("#post-delete #post-id").text(postInfo.id);
  $("#post-delete #post-title").text(postInfo.title);
  $("#post-delete #post-description").text(postInfo.description);
  if (postInfo.status == "0") {
    $("#post-delete #post-status").text("Inactive");
  } else {
    $("#post-delete #post-status").text("Active");
  }
}