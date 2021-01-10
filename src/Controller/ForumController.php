<?php

namespace Lii\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Lii\Model\Forum\Question;
use Lii\Model\Forum\Answer;
use Lii\Model\Forum\AskQuestionForm;
use Lii\Model\Forum\AnswerQuestionForm;
use Lii\Model\Forum\CommentQuestionForm;
use Lii\Model\Forum\CommentAnswerForm;
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
     * @param int $id the id to show.
     *
     * @return object as a response object
     */
    public function showQuestionAction(int $id) : object
    {
        $page = $this->di->get("page");
        $db = $this->di->get("dbqb");
        $db->connect();

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);
        $text = $question->getDataFiltered("markdown");

        $sql = "SELECT text FROM tag WHERE questid = $id;";
        $tags = $db->executeFetchAll($sql);

        $sql2 = "SELECT * FROM answer WHERE questid = $id;";
        $answers = $db->executeFetchAll($sql2);

        $answerArray = array();
        foreach ($answers as $answer) {
            $newAnswer = new Answer();
            $newAnswer->setDb($this->di->get("dbqb"));
            $newAnswer->find("id", $answer->id);
            array_push($answerArray, $newAnswer);
        }

        $sql3 = "SELECT * FROM qcomment WHERE questid = $id;";
        $qcomments = $db->executeFetchAll($sql3);

        $sql4 = "SELECT * FROM acomment";
        $acomments = $db->executeFetchAll($sql4);

        $page->add("forum/showquestion", [
            "question" => $question,
            "answers" => $answers,
            "answerArray" => $answerArray,
            "qcomments" => $qcomments,
            "acomments" => $acomments,
            "text" => $text,
            "tags" => $tags,
        ]);

        return $page->render([
            "title" => "Question",
        ]);
    }

    /**
     * Function to answer a question.
     *
     * @param int $id the question id.
     *
     * @return object as a response object
     */
    public function answerAction(int $questId) : object
    {
        $this->testAuth();

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $questId);
        $text = $question->getDataFiltered("markdown");

        $page = $this->di->get("page");
        $form = new AnswerQuestionForm($this->di, $questId);
        $form->check();



        $page->add("forum/answer", [
            "content" => $form->getHTML(),
            "question" => $question,
            "text" => $text,
        ]);

        return $page->render([
            "title" => "Answer question",
        ]);
    }

    /**
     * Function to comment a question.
     *
     * @param int $id the question id.
     *
     * @return object as a response object
     */
    public function commentQAction(int $questId) : object
    {
        $this->testAuth();

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $questId);
        $text = $question->getDataFiltered("markdown");

        $page = $this->di->get("page");
        $form = new CommentQuestionForm($this->di, $questId);
        $form->check();

        $page->add("forum/qcomment", [
            "content" => $form->getHTML(),
            "question" => $question,
            "text" => $text,
        ]);

        return $page->render([
            "title" => "Comment question",
        ]);
    }

    /**
     * Function to comment an answer.
     *
     * @param int $id the question id.
     *
     * @return object as a response object
     */
    public function commentAAction(int $answId) : object
    {
        $this->testAuth();

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $answId);
        $text = $answer->getDataFiltered("markdown");

        $page = $this->di->get("page");
        $form = new CommentAnswerForm($this->di, $answId, $answer->questId);
        $form->check();

        $page->add("forum/acomment", [
            "content" => $form->getHTML(),
            "answer" => $answer,
            "text" => $text,
        ]);

        return $page->render([
            "title" => "Comment answer",
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

        $sql = "SELECT DISTINCT text FROM tag;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $tags = $db->executeFetchAll($sql);

        $page->add("forum/all-tags", [
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
}
