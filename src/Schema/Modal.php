<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Support\FieldCollection;
use Signifly\Travy\Schema\Concerns\HasEndpoint;

class Modal extends Action
{
    use HasEndpoint;

    /**
     * The modal fields.
     *
     * @var array
     */
    protected $fields;

    /**
     * The request payload.
     *
     * @var array
     */
    protected $payload;

    /**
     * The action type.
     *
     * @return array
     */
    public function actionType(): array
    {
        $fields = FieldCollection::make($this->fields);

        return [
            'id' => 'modal',
            'props' => [
                'name' => $this->name,
                'endpoint' => $this->endpoint->toArray(),
                'fields' => $fields->prepared(),
                'payload' => array_merge($fields->toData(), $this->payload),
            ],
        ];
    }

    /**
     * Set the fields prop.
     *
     * @param  array $value
     * @return self
     */
    public function fields(array $fields): self
    {
        $this->fields = $value;

        return $this;
    }

    /**
     * Set the payload prop.
     *
     * @param  array $value
     * @return self
     */
    public function payload(array $value): self
    {
        $this->payload = $value;

        return $this;
    }
}
