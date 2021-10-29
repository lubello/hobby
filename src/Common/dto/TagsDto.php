<?php

namespace App\Common\dto;

class TagsDto
{
    /** @var TagDto|null $tag */
    protected $tag1 = '';

    /** @var TagDto|null $tag */
    protected $tag2 = '';

    /** @var TagDto|null $tag3 */
    protected $tag3 = '';

    /** @var TagDto|null $tag4 */
    protected $tag4 = '';

    /** @var TagDto|null $tag5 */
    protected $tag5 = '';

    /** @var TagDto|null $tag6 */
    protected $tag6 = '';

    /** @var int|null $total */
    protected $total = '';

    public function __construct(TagDto $tag1 = null, TagDto $tag2 = null, TagDto $tag3 = null,
                                TagDto $tag4 = null, TagDto $tag5 = null, TagDto $tag6 = null, int $total = 0) {

        $this->tag1 = $tag1 ? $tag1 : new TagDto();
        $this->tag2 = $tag2 ? $tag2 : new TagDto();
        $this->tag3 = $tag3 ? $tag3 : new TagDto();
        $this->tag4 = $tag4 ? $tag4 : new TagDto();
        $this->tag5 = $tag5 ? $tag5 : new TagDto();
        $this->tag6 = $tag6 ? $tag6 : new TagDto();
        $this->total= $total;
    }
    public function __toString(): string {
        return $this->tag1;
    }

    public function getTag1(): ?TagDto {
        return $this->tag1;
    }
    public function setTag1(?TagDto $tag1) {
        $this->tag1 = $tag1;
    }


    public function getTag2(): ?TagDto {
        return $this->tag2;
    }
    public function setTag2(?TagDto $tag2) {
        $this->tag2 = $tag2;
    }


    public function getTag3(): ?TagDto {
        return $this->tag3;
    }
    public function setTag3(?TagDto $tag3) {
        $this->tag3 = $tag3;
    }


    public function getTag4(): ?TagDto {
        return $this->tag4;
    }
    public function setTag4(?TagDto $tag4) {
        $this->tag4 = $tag4;
    }


    public function getTag5(): ?TagDto {
        return $this->tag5;
    }
    public function setTag5(?TagDto $tag5) {
        $this->tag5 = $tag5;
    }


    public function getTag6(): ?TagDto {
        return $this->tag6;
    }
    public function setTag6(?TagDto $tag6) {
        $this->tag6 = $tag6;
    }


    public function getTotal(): ?int {
        return $this->total;
    }
    public function setTotal(?int $total) {
        $this->total = $total;
    }

    public function isModified(): bool {
        return
            $this->getTag1()->isModified() ||
            $this->getTag2()->isModified() ||
            $this->getTag3()->isModified() ||
            $this->getTag4()->isModified() ||
            $this->getTag5()->isModified() ||
            $this->getTag6()->isModified();
    }
}