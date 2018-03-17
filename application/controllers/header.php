<?php
/**
 * Created by PhpStorm.
 * User: VladKor
 * Date: 25.02.2018
 * Time: 18:21
 */

if($_POST["clear"])
{
    if($_POST["clear"] == "stats"){
        for($i=1; $i<10; $i++)
        {
            $values["paper"] = '1';
            $values["rock"] = '1';
            $values["scissors"] = '1';

            $db->update(
                "`progress`",
                $values,
                "`id` = '{$i}'"
            );
        }
    }

    if($_POST["clear"] == "game"){

        $db->truncate(
            "`matches`"
        );

        $values[0]["`id`"] = NULL;
        $values[0]["`PC`"] = "'Камень'";
        $values[0]["`player`"] = "'Ножницы'";
        $values[0]["`is_win`"] = "'-1'";

        $value[0]["`id`"] = NULL;
        $value[0]["`PC`"] = "'Ножницы'";
        $value[0]["`player`"] = "'Камень'";
        $value[0]["`is_win`"] = "'1'";

        $db->insert(
            "`matches`",
            $values
        );

        $db->insert(
            "`matches`",
            $value
        );
    }
}

include APP . "/view/templates/header.php";