<?php

namespace WrtCMS\DAO;

use WrtCMS\Domain\Chapter;

class ChapterDAO extends DAO
{  
    /**
     * Return a list of all chapters, sorted by date (most recent last).
     *
     * @return array A list of all chapters.
     */
    public function findAll() {
        $sql = "select * from t_chapter ";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $chapters = array();
        foreach ($result as $row) {
            $chapterId = $row['chpt_id'];
            $chapters[$chapterId] = $this->buildDomainObject($row);
        }
        return $chapters;
    }

    /**
     * Creates an chapter object based on a DB row.
     *
     * @param array $row The DB row containing Chapter data.
     * @return \WrtCMS\Domain\Chapter
     */
    protected function buildDomainObject(array $row) {
        $chapter = new Chapter();
        $chapter->setId($row['chpt_id']);
        $chapter->setTitle($row['chpt_title']);
        $chapter->setContent($row['chpt_content']);
        return $chapter;
    }
    
     /**
     * Returns a chapter matching the supplied id.
     *
     * @param integer $id
     *
     * @return \WrtCMS\Domain\Chapter|throws an exception if no matching chapter is found
     */
    public function find($id) {
        $sql = "select * from t_chapter where chpt_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No chapter matching id " . $id);
    }
}