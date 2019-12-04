<?php

class Comment
{
    // comment attributes
    private $idComment;
    private $comment;
    private $commentDate;
    private $idUser;
    private $idActivity;

    public function __construct($idComment, $comment, $commentDate, $idUser, $idActivity)
    {
        $this->idComment = $idComment;
        $this->comment = $comment;
        $this->commentDate = $commentDate;
        $this->idUser = $idUser;
        $this->idActivity = $idActivity;
    }

    /**
     * function to get the comment
     *
     * @return mixed
     */
    public function comment()
    {
        return $this->comment;
    }

    /**
     * function to get the comment date
     *
     * @return mixed
     */
    public function commentDate()
    {
        return $this->commentDate;
    }
}
