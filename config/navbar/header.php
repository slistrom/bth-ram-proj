<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "wrapper" => null,
    "class" => "my-navbar rm-default rm-desktop",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "One Place home page.",
        ],
        [
            "text" => "Posts",
            "url" => "forum/posts",
            "title" => "Forum posts.",
        ],
        [
            "text" => "Tags",
            "url" => "forum/tags",
            "title" => "Forum tags.",
        ],
        [
            "text" => "Users",
            "url" => "forum/users",
            "title" => "Forum users.",
        ],
        [
            "text" => "About",
            "url" => "about",
            "title" => "About this website.",
        ],
        [
            "text" => "Login",
            "url" => "auth/login",
            "title" => "User login.",
        ],
    ],
];
