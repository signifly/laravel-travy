<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Signifly\Travy\Schema\Concerns\HasActions;

class Batch implements JsonSerializable
{
    use HasActions;

    /**
     * The attribute / column name for the label.
     *
     * @var string
     */
    public $attribute;

    /**
     * The link for the sequential tooltip.
     *
     * @var string
     */
    public $link;

    /**
     * The sequential url.
     *
     * @var string
     */
    public $sequential;

    /**
     * Create a new field.
     *
     * @param string $name
     * @param string|null $attribute
     */
    public function __construct($attribute, $link = null)
    {
        $this->attribute = $attribute;
        $this->link = $link;
    }

    /**
     * Create a new element.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }


    /**
     * Set the link of the sequential tooltip.
     *
     * @param  string $link
     * @return self
     */
    public function link(string $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Set the sequential url.
     *
     * @param  string $url
     * @return self
     */
    public function sequential(string $url)
    {
        $this->sequential = $url;

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize() : array
    {
        $data = [
            'selectedOptions' => [
                'label' => $this->attribute,
                'link' => $this->link,
            ],
            'sequential' => [
                'url' => $this->sequential ?? $this->link,
            ],
        ];

        if ($this->hasActions()) {
            array_set($data, 'bulk.actions', $this->preparedActions());
        }

        return $data;
    }
}
