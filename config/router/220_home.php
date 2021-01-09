<?php
/**
 * Mount the controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "Home controller.",
            "mount" => "home",
            "handler" => "\Lii\Controller\HomeController",
        ],
    ]
];
