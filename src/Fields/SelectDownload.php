<?php

namespace Signifly\Travy\Fields;

use Closure;
use Signifly\Travy\Schema\Endpoint;
use Signifly\Travy\Schema\Concerns\HasOptions;

class SelectDownload extends Field
{
    use HasOptions;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'select-download';

    /** @var \Signifly\Travy\Schema\Endpoint */
    public $endpoint;

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * The default options for the element.
     *
     * @return array
     */
    public function defaultOptions(): array
    {
        return [
            'key' => 'data',
            'itemKey' => 'data',
            'value' => 'id',
        ];
    }

    /**
     * Set the download url option.
     *
     * @param  string $download
     * @return self
     */
    public function download(string $download)
    {
        return $this->withOptions(compact('download'));
    }

    /**
     * Set the endpoint option.
     *
     * @param  string $url
     * @param  Closure|null $callable
     * @return self
     */
    public function endpoint(string $url, ?Closure $callable = null): self
    {
        $endpoint = new Endpoint($url);

        if (! is_null($callable)) {
            $callable($endpoint);
        }

        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Set the itemKey option.
     *
     * @param  string $itemKey
     * @return self
     */
    public function itemKey(string $itemKey)
    {
        return $this->withOptions(compact('itemKey'));
    }

    /**
     * Set the key option.
     *
     * @param  string $key
     * @return self
     */
    public function key(string $key)
    {
        return $this->withOptions(compact('key'));
    }

    /**
     * Set the label option.
     *
     * @param  string $label
     * @return self
     */
    public function label(string $label)
    {
        return $this->withOptions(compact('label'));
    }

    /**
     * Set the title prop.
     *
     * @param  string $title
     * @return self
     */
    public function title(string $title)
    {
        return $this->withProps(compact('title'));
    }

    /**
     * Set the subtitle prop.
     *
     * @param  string $subtitle
     * @return self
     */
    public function subtitle(string $subtitle)
    {
        return $this->withProps(compact('subtitle'));
    }

    /**
     * Set the value option.
     *
     * @param  string $value
     * @return self
     */
    public function value(string $value)
    {
        return $this->withOptions(compact('value'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        if ($this->endpoint) {
            $this->withOptions(['endpoint' => $this->endpoint->toArray()]);
        }

        $this->withProps([
            'options' => $this->options(),
        ]);
    }
}
