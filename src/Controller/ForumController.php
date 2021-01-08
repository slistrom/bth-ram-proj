<?php

namespace Lii\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Lii\Model\Forum\Question;
use Lii\Model\Forum\AskQuestionForm;
use Lii\Model\Forum\Tag;
use Lii\Model\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A controller to handle authorization
 */
class ForumController implements ContainerInjectableInterface
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


//     /**
//      * Description.
//      *
//      * @throws Exception
//      *
//      * @return object as a response object
//      */
//     public function indexAction() : object
//     {
//         $page = $this->di->get("page");
//
//         $page->add("anax/v2/article/default", [
//             "content" => "An index page",
//         ]);
//
//         return $page->render([
//             "title" => "A index page",
//         ]);
//     }

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
     * Function to show all forum questions.
     *
     * @return object as a response object
     */
    public function questionsAction() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));


        $page->add("forum/all-questions", [
//             "content" => $form->getHTML(),
            "items" => $question->findAll(),
        ]);

        return $page->render([
            "title" => "Forum questions",
        ]);
    }

    /**
     * Function to ask a question.
     *
     * @return object as a response object
     */
    public function askQuestionAction() : object
    {
        $this->testAuth();

        $page = $this->di->get("page");
        $form = new AskQuestionForm($this->di);
        $form->check();

        $page->add("forum/askquestion", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Ask question",
        ]);
    }

    /**
     * Function to show a specific question.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function showQuestionAction(int $id) : object
    {
        $page = $this->di->get("page");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);

        $sql = "SELECT text FROM tag WHERE questid = $id;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $tags = $db->executeFetchAll($sql);

        $page->add("forum/showquestion", [
            "question" => $question,
            "tags" => $tags,
        ]);

        return $page->render([
            "title" => "Question",
        ]);
    }


    /**
     * Function to show all forum users.
     *
     * @return object as a response object
     */
    public function usersAction() : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("forum/all-users", [
            "items" => $user->findAll(),
        ]);

        return $page->render([
            "title" => "Forum users",
        ]);
    }

    /**
     * Function to show a specific user.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function showUserAction(int $id) : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $id);

        $sql = "SELECT * FROM question WHERE userId = $id;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $questions = $db->executeFetchAll($sql);

        $gravatar = getGravatar($user->acronym);

        $page->add("forum/showuser", [
            "user" => $user,
            "gravatar" => $gravatar,
            "questions" => $questions,
        ]);

        return $page->render([
            "title" => "User",
        ]);
    }

    /**
     * Function to show all forum tags.
     *
     * @return object as a response object
     */
    public function tagsAction() : object
    {
        $page = $this->di->get("page");
//         $tag = new Tag();
//         $tag->setDb($this->di->get("dbqb"));

        $sql = "SELECT DISTINCT text FROM tag;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $tags = $db->executeFetchAll($sql);

        $page->add("forum/all-tags", [
//             "items" => $tag->findAll(),
            "items" => $tags,
        ]);

        return $page->render([
            "title" => "Forum tags",
        ]);
    }

    /**
     * Function to show a specific tag.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function showTagAction($id) : object
    {
        $page = $this->di->get("page");
//         $tag = new Tag();
//         $tag->setDb($this->di->get("dbqb"));
//         $tag->find("id", $id);

        $sql = "select distinct questid from tag where text = '$id';";
        $db = $this->di->get("dbqb");
        $db->connect();
        $qids = $db->executeFetchAll($sql);

        $questions = array();
        $db = $this->di->get("dbqb");
        $db->connect();
        foreach ($qids as $qid) {
            $idx = $qid->questId;
            $sql = "select * from question where id = $idx;";
            array_push($questions, $db->executeFetch($sql));
        }

        $page->add("forum/showtag", [
            "tag" => $id,
            "questions" => $questions,
        ]);

        return $page->render([
            "title" => "Tag",
        ]);
    }

//     /**
//      * Handler with form to update an item.
//      *
//      * @return object as a response object
//      */
//     public function updateAction() : object
//     {
//         $this->testAuth();
//
//         $page = $this->di->get("page");
//         $session = $this->di->get("session");
//
//         $userId = $session->get("userId");
//
//         $form = new UpdateUserForm($this->di, $userId);
//         $form->check();
//
//         $page->add("user/update", [
//             "form" => $form->getHTML(),
//         ]);
//
//         return $page->render([
//             "title" => "Update an item",
//         ]);
//     }
}