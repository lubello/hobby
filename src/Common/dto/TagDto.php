<?php

namespace App\Common\dto;

class TagDto
{
    /** @var string|null $tag */
    protected $tag = '';

    /** @var string|null $tag */
    protected $tagOriginal = '';


    public function __construct(string $tag = null) {
        $this->tag = $tag;
        $this->tagOriginal = $tag;
    }
    public function __toString(): string {
        return $this->tag;
    }



    public function getTag(): ?string {
        return $this->tag;
    }
    public function setTag(?string $tag) {
        $this->tag = $tag;
    }



    public function getTagOriginal(): ?string {
        return $this->tagOriginal;
    }
    public function setTagOriginal(?string $tagOriginal) {
        $this->tagOriginal = $tagOriginal;
    }

    public function isModified(): bool {
        return $this->tag != $this->tagOriginal;
    }


}