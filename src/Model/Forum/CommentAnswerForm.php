<?php

namespace Lii\Model\Forum;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Lii\Model\Forum\Acomment;

// use Lii\Model\Forum\Question;
// use Lii\Model\Forum\Tag;

/**
 * Example of FormModel implementation.
 */
class CommentAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $answId, $questId)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Comment answer",
            ],
            [
                "comment" => [
                    "type"        => "textarea",
                    "placeholder" => "Write comment in markdown",
                    "validation" => ["not_empty"],
                ],

                "questId" => [
                    "type"        => "hidden",
                    "value"       => $questId,
                ],

                "answId" => [
                    "type"        => "hidden",
                    "value"       => $answId,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post comment",
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
//         $title       = $this->form->value("title");
        $text        = $this->form->value("comment");
        $answId     = $this->form->value("answId");

//         $tags        = $this->form->value("tags");
//         $tagArray = explode(" ", $tags);

        // Save to database
//         $db = $this->di->get("dbqb");
//         $password = password_hash($password, PASSWORD_DEFAULT);
//         $db->connect()
//            ->insert("User", ["acronym", "password"])
//            ->execute([$acronym, $password]);

        $session = $this->di->get("session");
        $userId = $session->get("userId");

        $comment = new Acomment();
        $comment->setDb($this->di->get("dbqb"));
//         $answer->title = $title;
        $comment->text = $text;
        $comment->userId = $userId;
        $comment->answId = $answId;
        $comment->created = date("Y-m-d");
        $comment->save();

//         $question = new Question();
//         $question->setDb($this->di->get("dbqb"));
//         $question->find("id", $questId);
//         $question->answered = "Answered";
//         $question->save();

        $this->form->addOutput("Comment was posted.");
        return true;
    }

    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $questId = $this->form->value("questId");
        $this->di->get("response")->redirect("forum/showquestion/" . $questId)->send();
    }
}
