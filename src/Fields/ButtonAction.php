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

    protected $actionData = [];
    protected $actionProps = [];

    public function data(array $data)
    {
        $this->actionData = array_merge($this->actionData, $data);

        return $this;
    }

    public function endpoint(string $url, string $method = 'post', array $params = [])
    {
        array_set($this->actionProps, 'endpoint', compact('url', 'method', 'params'));

        return $this;
    }

    public function fields(array $fields)
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

    public function icon(string $icon)
    {
        return $this->withProps(compact('icon'));
    }

    public function onSubmit(string $link)
    {
        array_set($this->actionProps, 'onSubmit', $link);

        return $this;
    }

    public function status(string $status)
    {
        return $this->withProps(compact('status'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps([
            'title' => $this->name,
            'action' => array_merge(
                ['id' => $this->attribute, 'title' => $this->name, 'data' => $this->actionData],
                $this->actionProps
            ),
        ]);
    }
}
