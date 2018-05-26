<?php declare(strict_types=1);

namespace lib;

interface Environment extends BaseEnvironment
{
    function pdo(): \PDO;
}
