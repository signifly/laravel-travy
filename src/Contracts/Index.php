<?php

namespace Signifly\Travy\Contracts;

interface Index
{
    public function pageTitle(): string;

    public function hero(): array;

    public function tabs(): array;
}
