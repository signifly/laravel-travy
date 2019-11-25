<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Schema\Concerns\HasEndpoint;

class Show extends Action
{
    use HasEndpoint;

    /**
     * The action type.
     *
     * @return array
     */
    public function actionType(): array
    {
        return [
            'id' => 'show',
            'props' => [
                'endpoint' => $this->endpoint->toArray(),
            ],
        ];
    }

    /**
     * Set the endpoint by url.
     *
     * @param  string $url
     * @return self
     */
    public function url(string $url): self
    {
        return $this->endpoint($url, 'get');
    }
}
