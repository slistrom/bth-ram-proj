<?php

namespace Lii\Model\Forum;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Lii\Model\Forum\Question;
use Lii\Model\Forum\Tag;

/**
 * Example of FormModel implementation.
 */
class AskQuestionForm extends FormModel
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
                "legend" => "Ask question",
            ],
            [
                "title" => [
                    "type"        => "text",
                    "validation" => ["not_empty"],
                ],

                "extra-information" => [
                    "type"        => "textarea",
                    "description" => "If needed you can write complementary text to your question above.",
                    "placeholder" => "Write text in markdown",
                ],

                "tags" => [
                    "type"        => "text",
                    "description" => "Above you can add tags relevant to your question. Separate them with a space",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post question",
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
        $title       = $this->form->value("title");
        $text        = $this->form->value("extra-information");
        $tags        = $this->form->value("tags");
        $tagArray = explode(" ", $tags);

        // Save to database
//         $db = $this->di->get("dbqb");
//         $password = password_hash($password, PASSWORD_DEFAULT);
//         $db->connect()
//            ->insert("User", ["acronym", "password"])
//            ->execute([$acronym, $password]);

        $session = $this->di->get("session");
        $userId = $session->get("userId");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title = $title;
        $question->text = $text;
        $question->userId = $userId;
        $question->save();

        $sql = "SELECT MAX(id) AS id FROM Question;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetch($sql);

        foreach ($tagArray as $item) {
            $tag = new Tag();
            $tag->setDb($this->di->get("dbqb"));
            $tag->text = $item;
            $tag->questId = $res->id;
            $tag->save();
        }

        $this->form->addOutput("Question was posted.");
        return true;
    }
}
