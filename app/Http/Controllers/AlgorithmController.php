<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlgorithmController extends Controller
{
    public function mergeSort()
    {
        function merge_sort($arr)
        {
            $res = [];
            $len = count($arr);

            if ($len <= 1) {
                return $arr;
            }

            $midLen = ($len >> 1) + ($len & 1);
            $arr_l_r = array_chunk($arr, $midLen);

            // 先拆成最小的两个
            // $left得到merge_sort函数的正确排序结果，然后继续把正确结果的left和right合并排序
            $left = merge_sort($arr_l_r[0]);
            $right = merge_sort($arr_l_r[1]);

            $leftLen = count($left);
            $rightLen = count($right);
            $leftIndex = $rightIndex = 0;

            // 比较左右两边的大小，然后排成正确顺序
            while ($leftIndex < $leftLen && $rightIndex < $rightLen) {
                if ($left[$leftIndex] <= $right[$rightIndex]) {
                    $res[] = $left[$leftIndex];
                    $leftIndex++;
                } else {
                    $res[] = $right[$rightIndex];
                    $rightIndex++;
                }
            }

            // 剩余的直接加到结果后面
            while ($rightIndex < $rightLen) {
                $res[] = $right[$rightIndex];
                $rightIndex++;
            }

            while ($leftIndex < $leftLen) {
                $res[] = $left[$leftIndex];
                $leftIndex++;
            }

            // 返回排序后的正确结果
            return $res;
        }

        $arr = range(0, 10);
        shuffle($arr);
        print_r($arr);

        $res = merge_sort($arr);

        print_r($res);
    }
}
