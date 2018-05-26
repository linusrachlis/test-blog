<?php declare(strict_types=1);

namespace lib;

class Form
{
    // /** @var Form[]     */ var $subforms; // TODO
    /** @var mixed[]    */ var $fields;
    /** @var string[][] */ var $errors;

    function populate(array $data, array $field_names) : void
    {
        $this->fields = [];
        foreach ($field_names as $field_name)
        {
            $this->fields[$field_name] = isset($data[$field_name]) ?
                $data[$field_name] :
                '';
        }
    }

    function required(string ...$field_names) : void
    {
        foreach ($field_names as $field_name)
        {
            assert(isset($this->fields[$field_name]), "Validating unpopulated field");
            if ('' === $this->fields[$field_name])
            {
                $this->errors[$field_name][] = "Required";
            }
        }
    }

    function is_valid() : bool
    {
        return empty($this->errors);
    }

    function field(
        string $field_name,
        string $format,
        string $error_attributes) : string
    {
        if (empty($this->errors[$field_name]))
        {
            $error_attributes = '';
        }
        $value = isset($this->fields[$field_name]) ?
            Lib::html_escape($this->fields[$field_name]) :
            '';
        return str_replace(
            ['%name', '%value', '%attr'],
            [$field_name, $value, $error_attributes],
            $format);
    }

    function begin_field() : void
    {
        ob_start();
    }

    function end_field(string $field_name, string $error_attributes) : void
    {
        $format = ob_get_clean();
        echo $this->field($field_name, $format, $error_attributes);
    }

    function errors(
        string $field_name,
        string $error_format,
        string $wrapper_format = '%s') : string
    {
        if (empty($this->errors[$field_name]))
        {
            return '';
        }

        $rendered_errors = [];
        foreach ($this->errors[$field_name] as $error)
        {
            $rendered_errors[] = sprintf($error_format, $error);
        }

        return sprintf($wrapper_format, implode('', $rendered_errors));
    }
}
