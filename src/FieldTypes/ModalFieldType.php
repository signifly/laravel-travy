<?php

namespace Signifly\Travy\FieldTypes;

use Signifly\Travy\Schema\Concerns\HasFields;

class ModalFieldType extends FieldType
{
    use HasFields;

    protected $id = 'vButtonAction';

    protected $data;

    protected $endpoint;

    protected $onSubmit;

    protected $title;

    public function button($text, $icon = 'plus', $type = 'primary')
    {
        $this->addProp('title', $text);
        $this->addProp('icon', $icon);

        return $this->addProp('type', $type);
    }

    public function fieldsData(array $data)
    {
        $this->data = (object) $data;

        return $this;
    }

    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    public function endpoint($url, $method = 'post')
    {
        $this->endpoint = compact('method', 'url');

        return $this;
    }

    public function onSubmit($onSubmit)
    {
        $this->onSubmit = $onSubmit;

        return $this;
    }

    protected function beforeBuild()
    {
        $this->addProp('action', [
            'id'       => 'modal',
            'endpoint' => $this->endpoint,
            'title'    => $this->title ?? $this->props['title'],
            'fields'   => $this->preparedFields(),
            'data'     => $this->data,
        ]);
    }
}
