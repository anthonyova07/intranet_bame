<?php

namespace Bame\Models\Department;

trait Department
{
    protected static function getDepartment($path, $inverted = false)
    {
        $parts = explode('/', $path);

        if ($inverted) {
            return array_pop($parts);
        }

        return $parts[0];
    }
}
