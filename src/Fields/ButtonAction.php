<?php

namespace Signifly\Travy\Fields;

class ButtonAction extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'button-action';

    /** @var array */
    protected $actionData = [];

    /** @var array */
    protected $actionProps = [];

    /**
     * Set the color of the button-action.
     *
     * @param  string $status
     * @return self
     */
    public function color(string $status): self
    {
        return $this->withProps(compact('status'));
    }

    /**
     * Set the data of the button-action.
     *
     * @param  array  $data
     * @return self
     */
    public function data(array $data): self
    {
        $this->actionData = array_merge($this->actionData, $data);

        return $this;
    }

    /**
     * Set the endpoint of the button-action.
     *
     * @param  string $url
     * @param  string $method
     * @param  array  $params
     * @return self
     */
    public function endpoint(string $url, string $method = 'post', array $params = []): self
    {
        array_set($this->actionProps, 'endpoint', compact('url', 'method', 'params'));

        return $this;
    }

    /**
     * Set the fields of the button-action.
     *
     * @param  array  $fields
     * @return self
     */
    public function fields(array $fields): self
    {
        $fields = collect($fields);

        $preparedFields = $fields->map(function ($field) {
                $field->linkable(false);
                return $field->jsonSerialize();
            })
            ->toArray();

        $data = $fields
            ->mapWithKeys(function ($field) {
                return [$field->attribute => $field->defaultValue ?? ''];
            })
            ->toArray();

        $this->data($data);

        array_set($this->actionProps, 'fields', $preparedFields);

        return $this;
    }

    /**
     * Set the icon of the button-action.
     *
     * @param  string $icon
     * @return self
     */
    public function icon(string $icon): self
    {
        return $this->withProps(compact('icon'));
    }

    /**
     * Set on submit link of the button-action.
     *
     * @param  string $link
     * @return self
     */
    public function onSubmit(string $link): self
    {
        array_set($this->actionProps, 'onSubmit', $link);

        return $this;
    }

    /**
     * Set the size of the button-action.
     *
     * @param  string $size
     * @return self
     */
    public function size(string $size): self
    {
        return $this->withProps(compact('size'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps([
            'title' => __($this->name),
            'action' => array_merge(
                ['id' => $this->attribute, 'title' => __($this->name), 'data' => $this->actionData],
                $this->actionProps
            ),
        ]);
    }
}
