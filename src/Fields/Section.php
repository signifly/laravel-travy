<?php

namespace Signifly\Travy\Fields;

class Section extends Tab
{
    /** @var int */
    protected $width = 50;

    /**
     * Set the width on the section.
     *
     * @param  int    $value
     * @return self
     */
    public function width(int $value): self
    {
        $this->width = $value;

        return $this;
    }

    /**
     * Prepare the sidebar for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'width' => $this->width,
        ]);
    }
}
