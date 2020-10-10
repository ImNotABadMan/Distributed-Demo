<?php


namespace App\Transformer;


class RedisTrans
{
    public function transKeyValue(array $data)
    {
        $arr = [];

        foreach ($data as $index => $item) {
            if (is_array($item[1])) {
                $value = implode("|><|", $item[1]);
            } else {
                $value = $item[1];
            }

            $arr[$index] = [
                "key" => $item[0],
                "value" => $value,
            ];
        }

        return $arr;
    }
}
