<?php

namespace Lii\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Lii\Model\User\UpdateUserForm;
use Lii\Model\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A controller to handle authorization
 */
class UserController implements ContainerInjectableInterface
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
     * This function test to see that a user is logged in.
     * If not, user is redirected to loginpage.
     */
    private function testAuth()
    {
        $session = $this->di->get("session");
        $auth = $session->get("authenticated");

        if ($auth != "yes") {
            return $this->di->response->redirect("auth/login");
        }
    }

    /**
     * Function to show a user profile.
     *
     * @return object as a response object
     */
    public function profileAction() : object
    {
        $this->testAuth();

        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $userId = $session->get("userId");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $userId);
        $gravatar = getGravatar($user->acronym);

        $page->add("user/profile", [
            "user" => $user,
            "gravatar" => $gravatar,
        ]);

        return $page->render([
            "title" => "User profile",
        ]);
    }

    /**
     * Handler with form to update an item.
     *
     * @return object as a response object
     */
    public function updateAction() : object
    {
        $this->testAuth();

        $page = $this->di->get("page");
        $session = $this->di->get("session");

        $userId = $session->get("userId");

        $form = new UpdateUserForm($this->di, $userId);
        $form->check();

        $page->add("user/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }
}
