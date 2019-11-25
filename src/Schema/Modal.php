<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Support\FieldCollection;
use Signifly\Travy\Schema\Concerns\HasEndpoint;

class Modal extends Action
{
    use HasEndpoint;

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
     * Set the payload prop.
     *
     * @param  string $value
     * @return self
     */
    public function payload(string $value): self
    {
        $this->payload = $value;

        return $this;
    }
}
