<?php declare(strict_types=1);

namespace lib;

interface BaseEnvironment
{
    /**
     * @param string[] $routes
     */
    function route(array $routes, string $request_uri): void;
}

trait Router
{
    function route(array $routes, string $request_uri) : void
    {
        $query_string_begin_pos = strpos($request_uri, '?');
        $url = (false === $query_string_begin_pos) ?
            $request_uri :
            substr($request_uri, 0, $query_string_begin_pos);

        foreach ($routes as $pattern => $function)
        {
            if (preg_match("<$pattern>", $url, $matches))
            {
                array_shift($matches);
                call_user_func_array($function, $matches);
                break;
            }
        }
    }
}

// function assign_to(object $object, array $array) : void
// {
//     foreach ($array as $key => $value)
//     {
//         $object->$key = $value;
//     }
// }

function h(string $unsafe_string) : string
{
    return htmlspecialchars($unsafe_string);
}

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
            $this->fields[$field_name] = isset($data[$field_name]) ? $data[$field_name] : '';
        }
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
            h($this->fields[$field_name]) :
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
