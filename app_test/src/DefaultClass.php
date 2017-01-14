<?php
namespace AppTest;

class DefaultClass
{
    static $value = null;

    public function justForTest($b = 2)
    {
        if ($b % 2) {
            $a = $b/2;
        } else {
            $a = $b*2;
        }

        return $a === $b;
    }
}
