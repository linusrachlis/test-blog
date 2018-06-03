<?php declare(strict_types=1);

namespace lib;

class Form
{
    // /** @var Form[]     */ var $subforms; // TODO
    /** @var Field[]    */ var $fields;

    function field(string $name) : Field
    {
        $this->fields[$name] = new Field($name);
        return $this->fields[$name];
    }

    function populate(array $data) : void
    {
        foreach ($this->fields as $field_name => $field)
        {
            $field->value = isset($data[$field_name]) ?
                $data[$field_name] :
                '';
        }
    }

    function is_valid() : bool
    {
        foreach ($this->fields as $field)
        {
            if (!empty($field->errors)) return false;
        }
        return true;
    }

    /** @return string[] */
    function values(Field ...$fields) : array
    {
        $result = [];
        foreach ($fields as $field)
        {
            $result[] = $field->value;
        }
        return $result;
    }
}
