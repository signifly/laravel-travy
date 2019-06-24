<?php

namespace Signifly\Travy\Fields;

abstract class FieldElement
{
    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = true;

    /**
     * Indicates if the element should be shown on the creation view.
     *
     * @var bool
     */
    public $showOnCreation = true;

    /**
     * Indicates if the element should be shown on the update view.
     *
     * @var bool
     */
    public $showOnUpdate = true;

    /**
     * Specify that the element should be hidden from the index view.
     *
     * @return $this
     */
    public function hideFromIndex(): self
    {
        $this->showOnIndex = false;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the creation view.
     *
     * @return $this
     */
    public function hideWhenCreating(): self
    {
        $this->showOnCreation = false;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the update view.
     *
     * @return $this
     */
    public function hideWhenUpdating(): self
    {
        $this->showOnUpdate = false;

        return $this;
    }

    /**
     * Specify that the element should only be shown on the creation view.
     *
     * @return $this
     */
    public function onlyOnCreation(): self
    {
        $this->showOnIndex = false;
        $this->showOnCreation = true;
        $this->showOnUpdate = false;

        return $this;
    }

    /**
     * Specify that the element should only be shown on the update view.
     *
     * @return $this
     */
    public function onlyOnUpdate(): self
    {
        $this->showOnIndex = false;
        $this->showOnCreation = false;
        $this->showOnUpdate = true;

        return $this;
    }

    /**
     * Specify that the element should only be shown on the index view.
     *
     * @return $this
     */
    public function onlyOnIndex(): self
    {
        $this->showOnIndex = true;
        $this->showOnCreation = false;
        $this->showOnUpdate = false;

        return $this;
    }

    /**
     * Specify that the element should only be shown on forms.
     *
     * @return $this
     */
    public function onlyOnForms(): self
    {
        $this->showOnIndex = false;
        $this->showOnCreation = true;
        $this->showOnUpdate = true;

        return $this;
    }

    /**
     * Specify that the element should be hidden from forms.
     *
     * @return $this
     */
    public function exceptOnForms(): self
    {
        $this->showOnIndex = true;
        $this->showOnCreation = false;
        $this->showOnUpdate = false;

        return $this;
    }

    /**
     * Localize text.
     *
     * @param  mixed $text
     * @return mixed
     */
    protected function localize($text)
    {
        return is_string($text) ? __($text) : $text;
    }
}
