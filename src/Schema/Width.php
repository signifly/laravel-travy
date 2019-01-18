<?php

namespace Signifly\Travy\Schema;

class Width
{
    /** @var int */
    protected $value;

    /** @var int|null */
    protected $forColumn = null;

    /** @var int|null */
    protected $onCreation = null;

    /** @var int|null */
    protected $onUpdate = null;

    /**
     * Create a new Width instance.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function forColumn(int $value): self
    {
        $this->forColumn = $value;

        return $this;
    }

    public function onCreation(int $value): self
    {
        $this->onCreation = $value;

        return $this;
    }

    public function onUpdate(int $value): self
    {
        $this->onUpdate = $value;

        return $this;
    }

    public function getForColumn()
    {
        return $this->forColumn;
    }

    public function getOnCreation(): int
    {
        return $this->onCreation ?? $this->value;
    }

    public function getOnUpdate(): int
    {
        return $this->onUpdate ?? $this->value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
