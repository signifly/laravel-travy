<?php

namespace Signifly\Travy\Schema;

class Width
{
    /** @var int */
    protected $value;

    /** @var int|null */
    protected $onCreation = null;

    /** @var int|null */
    protected $onIndex = null;

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

    public function onCreation(int $value): self
    {
        $this->onCreation = $value;

        return $this;
    }

    public function onIndex(int $value): self
    {
        $this->onIndex = $value;

        return $this;
    }

    public function onUpdate(int $value): self
    {
        $this->onUpdate = $value;

        return $this;
    }

    public function getOnCreation(): int
    {
        return $this->onCreation ?? $this->value;
    }

    public function getOnIndex(): int
    {
        return $this->onIndex ?? $this->value;
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
