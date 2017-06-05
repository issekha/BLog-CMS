<?php

namespace WrtCMS\DAO;

use WrtCMS\Domain\Comment;

class CommentDAO extends DAO 
{
    /**
     * @var \WrtCMS\DAO\ChapterDAO
     */
    private $chapterDAO;

    /**
     * @var \WrtCMS\DAO\UserDAO
     */
    private $userDAO;

    public function setChapterDAO(ChapterDAO $chapterDAO) {
        $this->chapterDAO = $chapterDAO;
    }

    public function setUserDAO(UserDAO $userDAO) {
        $this->userDAO = $userDAO;
    }

    /**
     * Return a list of all comments for a chapter, sorted by date (most recent last).
     *
     * @param integer $chapterId The chapter id.
     *
     * @return array A list of all comments for the chapter.
     */
    public function findAllBychapter($chapterId) {
        // The associated chapter is retrieved only once
        $chapter = $this->chapterDAO->find($chapterId);

        // chpt_id is not selected by the SQL query
        // The chapter won't be retrieved during domain objet construction
        $sql = "select com_id, com_content, usr_id from t_comment where chpt_id=? order by com_id";
        $result = $this->getDb()->fetchAll($sql, array($chapterId));

        // Convert query result to an array of domain objects
        $comments = array();
        foreach ($result as $row) {
            $comId = $row['com_id'];
            $comment = $this->buildDomainObject($row);
            // The associated chapter is defined for the constructed comment
            $comment->setChapter($chapter);
            $comments[$comId] = $comment;
        }
        return $comments;
    }

    /**
     * Creates an Comment object based on a DB row.
     *
     * @param array $row The DB row containing Comment data.
     * @return \WrtCMS\Domain\Comment
     */
    protected function buildDomainObject(array $row) {
        $comment = new Comment();
        $comment->setId($row['com_id']);
        $comment->setContent($row['com_content']);

        if (array_key_exists('chpt_id', $row)) {
            // Find and set the associated chapter
            $chapterId = $row['chpt_id'];
            $chapter = $this->chapterDAO->find($chapterId);
            $comment->setChapter($chapter);
        }
        if (array_key_exists('usr_id', $row)) {
            // Find and set the associated author
            $userId = $row['usr_id'];
            $user = $this->userDAO->find($userId);
            $comment->setAuthor($user);
        }
        
        return $comment;
    }
}