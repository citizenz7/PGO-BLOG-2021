<?php

namespace App\Form\Model;

/**
 * Class SearchPost
 * @package App\Form\Model
 */
class SearchPost
{
    private string $title;

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return $this
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }
}
