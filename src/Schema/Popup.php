<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Schema\Concerns\HasEndpoint;

class Popup extends Action
{
    use HasEndpoint;

    /**
     * The request payload.
     *
     * @var array
     */
    protected $payload;

    /**
     * The text to display in the popup.
     *
     * @var string
     */
    protected $text;

    /**
     * The action type.
     *
     * @return array
     */
    public function actionType(): array
    {
        return [
            'id' => 'popup',
            'props' => [
                'title' => $this->name,
                'text' => $this->text ?? $this->defaultText(),
                'endpoint' => $this->endpoint->toArray(),
                'payload' => $this->payload ?? (object) [],
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

    /**
     * Set the text prop.
     *
     * @param  string $value
     * @return self
     */
    public function text(string $value): self
    {
        $this->text = $value;

        return $this;
    }

    /**
     * The default text to display in the popup.
     *
     * @todo Refactor to language files
     * @return string
     */
    protected function defaultText(): string
    {
        return 'Are you sure? Please confirm this action.';
    }
}
