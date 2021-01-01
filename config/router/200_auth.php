<?php
/**
 * Mount the controller onto a mountpoint.
 */
return [
    "routes" => [
        [
            "info" => "Authorization controller.",
            "mount" => "auth",
            "handler" => "\Lii\Controller\AuthController",
        ],
    ]
];
