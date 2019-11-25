<?php

namespace Signifly\Travy\Schema;

use JsonSerializable;
use Signifly\Travy\Contracts\Table;
use Illuminate\Contracts\Support\Arrayable;
use Signifly\Travy\Support\FieldCollection;
use Signifly\Travy\Schema\Concerns\HasEndpoint;

class Tab implements Arrayable, JsonSerializable
{
    use HasEndpoint;

    const TYPE_FIELDS = 'fields';
    const TYPE_TABLE = 'table';

    /**
     * The display name for the tab.
     *
     * @var string
     */
    protected $name;

    /**
     * The type of the tab.
     *
     * @var string
     */
    protected $type = self::TYPE_FIELDS;

    /**
     * The fields for the tab.
     *
     * @var array
     */
    protected $fields;

    /**
     * The table to load definitions for.
     *
     * @var \Signifly\Travy\Contracts\Table
     */
    protected $table;

    /**
     * Create a new tab.
     *
     * @param string $name
     * @param string|null $id
     */
    public function __construct($name, $definition = null)
    {
        $this->name = $name;

        if (is_array($definition)) {
            $this->fields($definition);
        } elseif ($definition instanceof Table) {
            $this->table($definition);
        }
    }

    /**
     * Initialize Tab statically.
     *
     * @param  mixed $arguments
     * @return self
     */
    public static function make(...$arguments): self
    {
        return new self(...$arguments);
    }

    /**
     * Define a list of fields for the tab.
     *
     * @param  array  $fields
     * @return self
     */
    public function fields(array $fields): self
    {
        $this->type = self::TYPE_FIELDS;
        $this->fields = $fields;

        return $this;
    }

    /**
     * Load definitions for the specified table.
     *
     * @param  \Signifly\Travy\Contracts\Table  $table
     * @return self
     */
    public function table(Table $table): self
    {
        $this->type = self::TYPE_TABLE;
        $this->table = $table;

        return $this;
    }

    /**
     * Prepare the definitions for the tab.
     *
     * @return mixed
     */
    protected function prepareDefinitions()
    {
        if ($this->type === 'table') {
            return $this->table;
        }

        if ($this->type === 'fields') {
            return [
                'endpoint' => $this->endpoint,
                'fields' => FieldCollection::make($this->fields),
            ];
        }

        throw new InvalidDefinitionException(
            sprintf('Invalid tab type `%s` defined', $this->type)
        );
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        return (new Schema([
            'name' => $this->name,
            'type' => $this->type,
            'definitions' => $this->prepareDefinitions(),
        ]))->toArray();
    }
}
