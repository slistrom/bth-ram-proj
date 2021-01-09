<?php
/**
 * Supply the basis for the navbar as an array.
 */

$auth = $_SESSION["authenticated"] ?? "no";

if ($auth == "no") {
    return [
        // Use for styling the menu
        "wrapper" => null,
        "class" => "my-navbar rm-default rm-desktop",

        // Here comes the menu items
        "items" => [
            [
                "text" => "Home",
                "url" => "home",
                "title" => "One Place home page.",
            ],
            [
                "text" => "Questions",
                "url" => "forum/questions",
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
} else {
    return [
        // Use for styling the menu
        "wrapper" => null,
        "class" => "my-navbar rm-default rm-desktop",

        // Here comes the menu items
        "items" => [
            [
                "text" => "Home",
                "url" => "home",
                "title" => "One Place home page.",
            ],
            [
                "text" => "Questions",
                "url" => "forum/questions",
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
                "text" => "My profile",
                "url" => "user/profile",
                "title" => "User profile.",
            ],
            [
                "text" => "Logout",
                "url" => "auth/logout",
                "title" => "User logout.",
            ],
        ],
    ];
}
