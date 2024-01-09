import './bootstrap';

import { Post } from "./custom/post-list";
window.Post = Post;

import { User } from "./custom/user-list";
window.User = User;

$("document").ready(function () {
  setTimeout(function () {
    $(".alert-message .alert").remove();
  }, 5000); // 5 secs
});