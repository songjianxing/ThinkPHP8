<?php

namespace helper;

class ValidateHelper
{
    /**
     * 格式化数字参数(不允许小于0)
     *
     * @param   $number : 原始数字
     * @param int $default : 如果原始数字小于0或者不是数字类型则返回默认值
     *
     * @return  int | array
     */
    public static function &number_filter($number, int $default = 0): array|int
    {
        if (is_array($number)) {
            foreach ($number as $k => $val) {
                $number[$k] = self::number_filter($val);
            }
        } else {
            if (is_numeric($number)) {
                if ($number > 2147483647) {
                    $number = 2147483647;
                } else if ($number < 0) {
                    $number = $default;
                }
            } else {
                $number = $default;
            }

            $number = intval($number);
        }

        return $number;
    }

    /**
     * 过滤所有html标签
     *
     * @param   $string : 原始字符串
     *
     * @return  string | array
     */
    public static function &str_filter($string): array|string
    {
        if (is_array($string)) {
            foreach ($string as $k => $val) {
                $string[$k] = self::str_filter($val);
            }
        } else {
            $string = htmlspecialchars($string);
            if (str_contains($string, '&amp;')) {
                $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
            }
        }

        return $string;
    }

    /**
     * 允许html标签，过滤js/object/iframe代码
     *
     * @param   $string
     *
     * @return  string | array
     */
    public static function &html_filter($string): array|string
    {
        if (is_array($string)) {
            foreach ($string as $k => $val) {
                $string[$k] = self::html_filter($val);
            }
        } else {
            $string = str_ireplace([
                '<?', '?>', '<!--', '-->',
                '<script', '</script>', '<iframe', '</iframe>',
                '<object', '</object>', '<input', '<select', '</select>',
                '<option', '</option>', '<textarea', '</textarea>',
                '<button', '</button>', '<form', '</form>',
                '<marquee', '</marquee>', '<style', '</style>'
            ], [
                '&lt;?', '?&gt;', '&lt;!--', '--&gt;',
                '&lt;script', '&lt;/script&gt;', '&lt;iframe', '&lt;/iframe&gt;',
                '&lt;object', '&lt;/object&gt;', '&lt;input', '&lt;select', '&lt;/select&gt;',
                '&lt;option', '&lt;/option&gt;', '&lt;textarea', '&lt;/textarea&gt;',
                '&lt;button', '&lt;button&gt;', '&lt;form', '&lt;/form&gt;',
                '&lt;marquee', '&lt;/marquee&gt;', '&lt;style', '&lt;/style&gt;',
            ], $string);

            $string = preg_replace([
                '/on([a-zA-Z]*(|(\s+)))=/i',
                '/(<.*?\s)id\s*=.*?(\w+\s*=|\s*>)/i'
            ], [
                'on$1&#61;',
                '$1$2'
            ], $string);
        }

        return $string;
    }

}
