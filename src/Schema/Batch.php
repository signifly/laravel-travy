<?php

namespace Signifly\Travy\Schema;

use Illuminate\Contracts\Support\Arrayable;
use Signifly\Travy\Schema\Concerns\Buildable;
use Signifly\Travy\Schema\Concerns\HasActions;

class Batch implements Arrayable
{
    use Buildable;
    use HasActions;

    protected $sequential;

    protected $selectedOptions;

    /**
     * Checks if sequential is active.
     *
     * @return boolean
     */
    public function hasSequential()
    {
        return !! $this->sequential;
    }

    /**
     * Add sequential editing.
     *
     * @return void
     */
    public function sequential($url = '')
    {
        $this->sequential = $url;

        return $this;
    }

    /**
     * Add selected options.
     *
     * @param  string $label
     * @param  string $link
     * @return self
     */
    public function selectedOptions($label, $link)
    {
        $this->selectedOptions = compact('label', 'link');

        return $this;
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray()
    {
        $data = [
            'bulk' => $this->hasActions(),
            'actions' => $this->preparedActions(),
            'selectedOptions' => $this->selectedOptions ?: (object) [],
        ];

        if ($this->hasSequential()) {
            array_set($data, 'sequential.url', $this->sequential);
        }

        return $data;
    }
}
