<?php

namespace App\Common\dto;

class TagsDto
{
    /** @var string|null $tag */
    protected $tag1 = '';

    /** @var string|null $tag */
    protected $tag2 = '';

    /** @var string|null $tag3 */
    protected $tag3 = '';

    /** @var string|null $tag4 */
    protected $tag4 = '';

    /** @var string|null $tag5 */
    protected $tag5 = '';

    /** @var string|null $tag6 */
    protected $tag6 = '';

    /** @var int|null $total */
    protected $total = '';

    public function __construct(string $tag1 = null, string $tag2 = null, string $tag3 = null, string $tag4 = null, string $tag5 = null, string $tag6 = null, int $total = 0) {
        $this->tag1 = $tag1;
        $this->tag2 = $tag2;
        $this->tag3 = $tag3;
        $this->tag4 = $tag4;
        $this->tag5 = $tag5;
        $this->tag6 = $tag6;
        $this->total= $total;
    }
    public function __toString(): string {
        // TODO: Implement __toString() method.
        return $this->tag1 . ' - ' . $this->tag2;
    }

    public function getTag1(): ?string {
        return $this->tag1;
    }
    public function setTag1(?string $tag1) {
        $this->tag1 = $tag1;
    }


    public function getTag2(): ?string {
        return $this->tag2;
    }
    public function setTag2(?string $tag2) {
        $this->tag2 = $tag2;
    }


    public function getTag3(): ?string {
        return $this->tag3;
    }
    public function setTag3(?string $tag3) {
        $this->tag3 = $tag3;
    }


    public function getTag4(): ?string {
        return $this->tag4;
    }
    public function setTag4(?string $tag4) {
        $this->tag4 = $tag4;
    }


    public function getTag5(): ?string {
        return $this->tag5;
    }
    public function setTag5(?string $tag5) {
        $this->tag5 = $tag5;
    }


    public function getTag6(): ?string {
        return $this->tag6;
    }
    public function setTag6(?string $tag6) {
        $this->tag6 = $tag6;
    }


    public function getTotal(): ?int {
        return $this->total;
    }
    public function setTotal(?int $total) {
        $this->total = $total;
    }
}