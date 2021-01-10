<?php

namespace Lii\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Lii\Model\Forum\Question;
use Lii\Model\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A controller to handle authorization
 */
class HomeController implements ContainerInjectableInterface
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
        $db = $this->di->get("dbqb");
        $db->connect();
        $questions = array();
        $users = array();

        $sql = "SELECT * FROM question ORDER BY created DESC LIMIT 5;";
        $questionRes = $db->executeFetchAll($sql);
        foreach ($questionRes as $item) {
            $question = new Question();
            $question->setDb($this->di->get("dbqb"));
            $question->find("id", $item->id);
            array_push($questions, $question);
        }

        $sql2 = "SELECT count(id) as count, userId FROM question GROUP BY userId ORDER BY count DESC LIMIT 3;";
        $userRes = $db->executeFetchAll($sql2);
        foreach ($userRes as $item) {
            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $user->find("id", $item->userId);
            array_push($users, $user);
        }

        $sql3 = "SELECT count(id) as count, text FROM tag GROUP BY text ORDER BY count DESC LIMIT 3;";
        $tagRes = $db->executeFetchAll($sql3);

        $page->add("forum/home", [
            "content" => "An index page",
            "questions" => $questions,
            "tags" => $tagRes,
            "users" => $users,
        ]);

        return $page->render([
            "title" => "A index page",
        ]);
    }
}
