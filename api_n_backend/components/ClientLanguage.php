<?php
/**
 * ClientLanguage
 *
 * A helper component
 */

namespace app\components;


class ClientLanguage
{
    const DEFAULT_LANG = 'en';

    /**
     * @return array
     */
    public static function getClientLanguages()
    {
        $result = [];

        if (($list = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']))) {
            if (preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', $list, $list)) {
                $languages = array_combine($list[1], $list[2]);

                foreach ($languages as $code => $value) {
                    $shortCode = strtok($code, '-');

                    if(!isset($result[$shortCode])) {
                        $result[$shortCode] = $value ?: 1.0;
                        continue;
                    }

                    if ($result[$shortCode] < $value) {
                        $result[$shortCode] = $value;
                    }
                }

                arsort($languages, SORT_NUMERIC);
            }
        }

        if (empty($result)) {
            $result = [
                self::DEFAULT_LANG => 1.0,
            ];
        }

        return array_keys($result);
    }
} 