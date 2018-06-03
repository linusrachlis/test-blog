<?php declare(strict_types=1);

namespace lib;

class Field
{
    /** @var string     */ var $name;
    /** @var mixed      */ var $value;
    /** @var string[]   */ var $errors;

    function __construct(string $name)
    {
        $this->name = $name;
    }

    function required(string $message = "Must not be blank") : void
    {
        if ('' === $this->value)
        {
            $this->errors[] = $message;
        }
    }

    function render(
        string $format,
        string $error_attributes) : string
    {
        if (empty($this->errors))
        {
            $error_attributes = '';
        }
        $value = isset($this->value) ?
            Lib::html_escape($this->value) :
            '';
        return str_replace(
            ['%name', '%value', '%attr'],
            [$this->name, $value, $error_attributes],
            $format);
    }

    function begin() : void
    {
        ob_start();
    }

    function end(string $error_attributes) : void
    {
        $format = ob_get_clean();
        echo $this->render($format, $error_attributes);
    }

    function errors(
        string $error_format,
        string $wrapper_format = '%s') : string
    {
        if (empty($this->errors))
        {
            return '';
        }

        $rendered_errors = [];
        foreach ($this->errors as $error)
        {
            $rendered_errors[] = sprintf($error_format, $error);
        }

        return sprintf($wrapper_format, implode('', $rendered_errors));
    }

}
