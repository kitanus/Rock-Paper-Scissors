<?php
/**
 * Created by PhpStorm.
 * User: VladKor
 * Date: 01.02.2018
 * Time: 11:40
 */

    /**
     * Раздатчик массивов инструкций для аргумента select
     * @param string        $name      название нужного массива инструкции
     * @return array
     */
    function chooseSelect($name)
    {
        switch ($name) {
            case "progress":
                $select['progress']['id'] = "id";
                $select['progress']['name'] = "name";
                $select['progress']['paper'] = "paper";
                $select['progress']['rock'] = "rock";
                $select['progress']['scissors'] = "scissors";
                return $select;
                break;

            case "matches":
                $select['matches']['id'] = "id";
                $select['matches']['PC'] = "PC";
                $select['matches']['player'] = "player";
                $select['matches']['is_win'] = "isWin";
                return $select;
                break;

            default:
                echo "Массив не сработал";

        }
    }

    /**
     * Раздатчик массивов инструкций для аргумента join
     * @param string        $name      название нужного массива инструкции
     * @return array
     */
    function chooseJoin($name)
    {
        switch ($name) {
            case "pAUser":
                $join["`stud_group`"]["`sg`"] = "`u`.`group_id` = `sg`.`id`";
                $join["`institute`"]["`i`"] = "`sg`.`institute_id` = `i`.`id`";
                $join["`user_type`"]["`ut`"] = "`u`.`user_type_id` = `ut`.`id`";
                return $join;
                break;

            default:
                echo "Массив не сработал";

        }
    }

    /**
     * Раздатчик массивов инструкций для аргумента insert
     * @param string        $name      название нужного массива инструкции
     * @param array        $get      массив GET
     * @param array        $post      массив POST
     * @param array        $var      массив необходимых переменных
     * @return array
     */
    function chooseInsert($name, $get = null, $post = null, $var = null)
    {
        switch ($name) {
            case "matches":
                $values[0]["`id`"] = NULL;
                $values[0]["`PC`"] = "'{$var[0]}'";
                $values[0]["`player`"] = "'{$post["choosePlayer"]}'";
                $values[0]["`is_win`"] = "'{$var[1]}'";
                return $values;
                break;

            case "clearMatches":
                $values[0]["`id`"] = NULL;
                $values[0]["`PC`"] = "''Камень'";
                $values[0]["`player`"] = "'Ножницы'";
                $values[0]["`is_win`"] = "'-1'";
                $values[1]["`id`"] = NULL;
                $values[1]["`PC`"] = "'Ножницы'";
                $values[1]["`player`"] = "'Камень'";
                $values[1]["`is_win`"] = "'1'";
                return $values;
                break;
            default:
                echo "Массив не сработал";

        }
    }

    /**
     * Раздатчик массивов инструкций для аргумента update
     * @param string        $name      название нужного массива инструкции
     * @param array        $post      массив POST
     * @param array        $var      массив необходимых для инструкции переменных
     * @return array
     */
    function chooseUpdate($name, $post = null, $var = null)
    {
        switch ($name) {
            case "event":
                $values["event_check"] = "{$var}";
                return $values;
                break;

            default:
                echo "Массив не сработал";
        };
    }