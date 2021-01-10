<?php

namespace Lii\Model\Forum;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Lii\Model\Forum\Question;
use Lii\Model\Forum\Answer;

// use Lii\Model\Forum\Tag;

/**
 * Example of FormModel implementation.
 */
class AnswerQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param \Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $questId)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Answer question",
            ],
            [
                "answer" => [
                    "type"        => "textarea",
                    "placeholder" => "Write answer in markdown",
                    "validation" => ["not_empty"],
                ],

                "questId" => [
                    "type"        => "hidden",
                    "value"       => $questId,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post answer",
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
        $text        = $this->form->value("answer");
        $questId     = $this->form->value("questId");


        $session = $this->di->get("session");
        $userId = $session->get("userId");

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->text = $text;
        $answer->userId = $userId;
        $answer->questId = $questId;
        $answer->created = date("Y-m-d");
        $answer->save();

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $questId);
        $question->answered = "Answered";
        $question->save();

        $this->form->addOutput("Answer was posted.");
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
