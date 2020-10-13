<?php


namespace App\Transformer;


class RedisTrans
{
    private $maxStrLen = 255;

    public function transKeyValue(array $data)
    {
        $arr = [];

        foreach ($data as $index => $item) {
            if (is_array($item[1])) {
                $value = implode("|><|", $item[1]);
            } else {
                $value = is_string($item[1]) && strlen($item[1]) > $this->maxStrLen ?
                    substr($item[1], 0, $this->maxStrLen) : $item[1];
            }

            $arr[$index] = [
                "key" => $item[0],
                "value" => $value,
            ];
        }

        return $arr;
    }
}
