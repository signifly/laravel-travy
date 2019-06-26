<?php

namespace Signifly\Travy\Fields;

use Illuminate\Support\Arr;
use Signifly\Travy\Schema\Endpoint;
use Signifly\Travy\Schema\Concerns\HasEndpoint;

class ButtonAction extends Field
{
    use HasEndpoint;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'button-action';

    /**
     * The default method to use for the endpoint.
     *
     * @var string
     */
    protected $defaultMethod = 'post';

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
     * Set the fields of the button-action.
     *
     * @param  array  $fields
     * @return self
     */
    public function fields(array $fields): self
    {
        $fields = collect($fields);

        $preparedFields = $fields
            ->map(function ($field) {
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

        Arr::set($this->actionProps, 'fields', $preparedFields);

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
        Arr::set($this->actionProps, 'onSubmit', $link);

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
    public function applyOptions(): void
    {
        if ($this->hasEndpoint()) {
            Arr::set($this->actionProps, 'endpoint', $this->endpoint->toArray());
        }

        $this->withProps([
            'title' => __($this->name),
            'action' => array_merge(
                ['id' => $this->attribute, 'title' => __($this->name), 'data' => $this->actionData],
                $this->actionProps
            ),
        ]);
    }
}
