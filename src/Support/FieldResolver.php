<?php

namespace Signifly\Travy\Support;

use Closure;
use Illuminate\Support\Str;
use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Field as SchemaField;
use Signifly\Travy\Http\Requests\TravyRequest;

class FieldResolver
{
    /** @var \Signifly\Travy\Fields\Field */
    protected $field;

    /** @var \Signifly\Travy\Http\Requests\TravyRequest */
    protected $request;

    /** @var \Signifly\Travy\Schema\Field */
    protected $schemaField;

    /**
     * Create a new column resolver.
     *
     * @param \Signifly\Travy\Http\Requests\TravyRequest $request
     */
    public function __construct(TravyRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Resolve the field.
     *
     * @param  \Signifly\Travy\Fields\Field  $field
     * @return \Signifly\Travy\Schema\Field
     */
    public function resolve(Field $field)
    {
        $this->field = $field;

        $this->initSchemaField();
        $this->applyFieldTypeOptions();

        return $this->schemaField;
    }

    /**
     * Apply field type options.
     *
     * @return void
     */
    protected function applyFieldTypeOptions()
    {
        $method = 'applyOptions';

        if (method_exists($this->field, $method)) {
            if ($this->field->component == 'text') {
                $this->field->component = 'input';
            }

            $this->schemaField->fieldType(
                $this->field->component,
                Closure::fromCallable([$this->field, $method])
            );

            $this->schemaField->tapFieldType(function ($fieldType) {
                foreach ($this->field->meta() as $key => $value) {
                    $fieldType->$key($value);
                }
            });
        }
    }

    /**
     * Instantiate a schema field from a field object.
     *
     * @return void
     */
    protected function initSchemaField()
    {
        $this->schemaField = new SchemaField(
            $this->field->attribute,
            $this->field->name
        );
    }
}
