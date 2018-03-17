<?php
/**
 * Created by PhpStorm.
 * User: VladKor
 * Date: 02.02.2018
 * Time: 14:36
 */

    /**
     * Раздатчик адрессов шаблонов стилей и HTML-текста для шапки
     * @param array        $get      массив GET
     * @param string        $kind      название типа шаблона
     * @return string
     */
    function chooseHeader($get, $kind)
    {
        if ($kind == "css")
        {
            switch ($get['go'])
            {
                default:
                    return APP . "/view/css/header.css";
            };
        }
        else
        {
            switch ($get['go'])
            {
                default:
                    return APP . "/controllers/header.php";
            };
        };
    };

    /**
     * Раздатчик адрессов шаблонов стилей и HTML-текста для тела
     * @param array        $get      массив GET
     * @param string        $kind      название типа шаблона
     * @return string
     */
    function chooseBody($get, $kind)
    {
        if ($kind == "css")
        {
            switch ($get['go'])
            {
                default:
                    return APP . "/view/" . $kind . "/gameBody.css";
            }
        }
        else
        {
            switch ($get['go']) {
                default:
                    return APP . "/controllers/gameBody.php";
            }
        }
    }