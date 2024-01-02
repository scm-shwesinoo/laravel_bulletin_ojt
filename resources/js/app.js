import './bootstrap';

$("document").ready(function () {
  setTimeout(function () {
    $(".alert-message .alert").remove();
  }, 5000); // 5 secs
});