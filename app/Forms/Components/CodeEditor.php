<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class CodeEditor extends Field
{
    protected string $view = 'forms.components.code-editor';

    protected string|\Closure|null $language = 'json';

    public function language(string|\Closure|null $lang): static
    {
        $this->language = $lang;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->evaluate($this->language) ?? 'json';
    }
}
