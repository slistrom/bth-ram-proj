<?php

namespace Lii\Model\User;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Lii\Model\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "User Login"
            ],
            [
                "user" => [
                    "type"        => "text",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],
                        
                "password" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $acronym       = $this->form->value("user");
        $password      = $this->form->value("password");

//         // Try to login
//         $db = $this->di->get("dbqb");
//         $db->connect();
//         $user = $db->select("password")
//                    ->from("User")
//                    ->where("acronym = ?")
//                    ->execute([$acronym])
//                    ->fetch();
//
//         // $user is null if user is not found
//         if (!$user || !password_verify($password, $user->password)) {
//            $this->form->rememberValues();
//            $this->form->addOutput("User or password did not match.");
//            return false;
//         }

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $res = $user->verifyPassword($acronym, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User or password did not match.");
            return false;
        }

        $session = $this->di->get("session");
        $session->set("userId", $user->id);
        $session->set("authenticated", "yes");

        $this->form->addOutput("User " . $user->acronym . " logged in.");
        return true;
    }
}
