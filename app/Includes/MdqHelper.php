<?php

namespace App\Includes;

use App\Models\MdItem;

class MdqHelper
{
    public function getUserExercisesTable($sheet)
    {
        if (!empty($sheet)) {
            $filtered_result = array_filter(
                $sheet,
                fn ($answer, $number) => ($answer == 1 && $number == 48) || ($answer == 0 && $number != 48),
                ARRAY_FILTER_USE_BOTH
            );

            $items = MdItem::whereIn("number", array_keys($filtered_result))->get(['number', 'exercises']);
        } else $items = [];

        $final_result = [];
        foreach ($items as $item) {
            $execrcises = json_decode($item->exercises);
            foreach ($execrcises as $execrcise) {
                $keys = $this->getContentKeyInArray($final_result, $execrcise->content);
                if (!empty($keys)) {
                    foreach ($keys as $key) array_push($final_result[$key]['numbers'], $item->number);
                } else {
                    array_push($final_result, [
                        'numbers' => [$item->number],
                        'content' => $execrcise->content,
                        'image' => $execrcise->image
                    ]);
                }
            }
        }

        return $final_result;
    }

    private function getContentKeyInArray($array, $content)
    {
        $keys = [];
        foreach ($array as $key => $data)
        {
            if ($data['content'] == $content)
                array_push($keys, $key);
        }

        return $keys;
    }
}
