<?php

namespace App\Includes;

class Constant
{
    public static $RAVEN_QUIZ = "raven";
    public static $MD_QUESTIONNAIRE_QUIZ = "md_questionnaire";

    public static $QUIZ_STARTED = "q-started";
    public static $QUIZ_TAKING = "q-taking";
    public static $QUIZ_FINISHED = "q-finished";

    public static $TIME_LIMIT_QUIZ_RAVEN = 20;

    public static $QUIZ_TYPES = [
        [
            'name' => 'raven',
            'title' => 'آزمون ریون',
            'desc' => 'توضیحات آزمون ریون'
        ],
        [
            'name' => 'md_questionnaire',
            'title' => 'پرسشنامه اختلال یادگیری (ریاضی)',
            'desc' => 'توضیحات پرسشنامه'
        ],
    ];

    public static $MD_LEVEL_ONE_TO_THREE = "md_level_one_to_three";
    public static $MD_LEVEL_ONE_TO_THREE_QUESTION_COUNT = 50;

    public static $MD_LEVEL_THREE_TO_SIX = "md_level_three_to_six";
    public static $MD_LEVEL_THREE_TO_SIX_QUESTION_COUNT = 44;

    public static $MD_LEVELS_TEXT = [
        "md_level_one_to_three" => "تا سه سال",
        "md_level_three_to_six" => "سه تا شش سال"
    ];
}
