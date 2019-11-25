<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Contracts\Index as Contract;

abstract class Index extends Definition implements Contract
{
    abstract public function pageTitle(): string;

    abstract public function hero(): array;

    abstract public function tabs(): array;

    public function toSchema(): Schema
    {
        $schema = new Schema([
            'pageTitle' => $this->pageTitle(),
            'hero' => $this->hero(),
            'tabs' => $this->tabs(),
        ]);

        $this->applyConcerns($schema);

        // Allow doing some final configurations
        if (method_exists($this, 'prepareSchema')) {
            $this->prepareSchema($schema);
        }

        return $schema;
    }

    public function toArray()
    {
        return $this->toSchema()->toArray();
    }

    protected function applyConcerns(Schema $schema): void
    {
        foreach (class_implements($this) as $interface) {
            $method = 'apply'.class_basename($interface);

            if (method_exists($this, $method)) {
                $this->$method($schema);
            }
        }
    }

    protected function applyWithModifiers(Schema $schema): void
    {
        $schema->set('modifiers', $this->modifiers());
    }
}
