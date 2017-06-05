<?php

namespace WrtCMS\Domain;

class Chapter 
{
    /**
     * Chapter id.
     *
     * @var integer
     */
    private $id;

    /**
     * Chapter title.
     *
     * @var string
     */
    private $title;

    /**
     * Chapter content.
     *
     * @var string
     */
    private $content;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
}