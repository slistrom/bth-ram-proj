<?php

namespace Lii\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Lii\Model\User\UserLoginForm;
use Lii\Model\User\CreateUserForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A controller to handle authorization
 */
class AuthController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    public function initialize() : void
    {
        ;
    }


    /**
     * Description.
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/article/default", [
            "content" => "An index page",
        ]);

        return $page->render([
            "title" => "A index page",
        ]);
    }

//     /**
//      * This function test to see that a user is logged in.
//      * If not, user is redirected to loginpage.
//      */
//     private function testAuth()
//     {
//         $session = $this->di->get("session");
//         $auth = $session->get("authenticated");
//         var_dump($auth);
//
//         if ($auth != "yes") {
//             return $this->di->response->redirect("auth/login");
//         }
//     }


    /**
     * Function to login a user.
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");

        $form = new UserLoginForm($this->di);
        $form->check();

        $session = $this->di->get("session");
        $user = $session->get("user");

        $page->add("user/login", [
            "content" => $form->getHTML(),
            "user" => $user,
        ]);

        return $page->render([
            "title" => "Login user",
        ]);
    }

    /**
     * Function to logout a user.
     *
     * @return object as a response object
     */
    public function logoutAction() : object
    {
//         $page = $this->di->get("page");
//
//         $form = new UserLoginForm($this->di);
//         $form->check();

        $session = $this->di->get("session");
//         $user = $session->get("user");
        $session->destroy();

//         $page->add("user/default", [
//             "content" => $form->getHTML(),
//             "user" => $user,
//         ]);
//
//         return $page->render([
//             "title" => "Login user",
//         ]);
        return $this->di->response->redirect("auth/login");
    }

    /**
     * Function to register a user.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("user/create", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create user",
        ]);
    }
}
