<?php


namespace App\Transformer;


class RedisTrans
{
    private $maxStrLen = 255;

    public function transKeyValue(array $data)
    {
        $arr = [];

        foreach ($data as $index => $item) {

            if (isset($item[1])) {

                if (is_array($item[1])) {
                    $encodingStrArr = array_map(function ($value) {
                        return mb_convert_encoding($value, 'utf8', mb_detect_encoding($value));
                    }, $item[1]);
                    $value = implode("|><|", $encodingStrArr);
                } else {
                    $value = is_string($item[1]) && strlen($item[1]) > $this->maxStrLen ?
                        substr($item[1], 0, $this->maxStrLen) : $item[1];
                    $value = mb_convert_encoding($value, 'utf8', mb_detect_encoding($value));
                }
            }

            $arr[$index] = [
                "key" => $item[0],
                "value" => $value ?? '',
            ];
        }

        return $arr;
    }
}
