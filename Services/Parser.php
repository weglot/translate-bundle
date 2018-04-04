<?php
/**
 * @author Remy Pagliai
 * Date: 13/11/2017
 * Time: 17:51
 */

namespace Weglot\TranslateBundle\Services;

class Parser
{
    private $client;
    private $excludeBlocks;

    /**
     * Parser constructor.
     * @param Client $client
     * @param $excludeBlocks
     */
    public function __construct(Client $client, $excludeBlocks)
    {
        $this->client = $client;
        $this->excludeBlocks = $excludeBlocks;
    }

    public function checkText($row)
    {
        return ($row->parent()->tag != 'script'
            && $row->parent()->tag != 'style'
            && !is_numeric($this->full_trim($row->outertext))
            && !preg_match('/^\d+%$/', $this->full_trim($row->outertext))
            && strpos($row->outertext, '[vc_') === false);
    }

    function full_trim($word)
    {
        return trim($word, " \t\n\r\0\x0B\xA0�");
    }

    public function checkButton($row)
    {
        return (!is_numeric($this->full_trim($row->value))
            && !preg_match('/^\d+%$/', $this->full_trim($row->value)));
    }

    public function checkTd_dt($row)
    {
        return true;
    }

    public function checkInput_dv($row)
    {
        return true;
    }

    public function checkInput_dobt($row)
    {
        return true;
    }

    public function checkRad_obt($row)
    {
        return true;
    }


    public function checkPlaceholder($row)
    {
        return (!is_numeric($this->full_trim($row->placeholder))
            && !preg_match('/^\d+%$/', $this->full_trim($row->placeholder)));
    }

    public function checkMeta_desc($row)
    {
        return (!is_numeric($this->full_trim($row->placeholder))
            && !preg_match('/^\d+%$/', $this->full_trim($row->placeholder)));
    }

    public function checkIframe_src($row)
    {
        return (strpos($this->full_trim($row->src), '.youtube.') !== false);
    }

    public function checkImg_src($row)
    {
        return true;
    }

    public function checkImg_alt($row)
    {
        return true;
    }

    public function checkA_pdf($row)
    {
        return (
            strtolower(substr($this->full_trim($row->href), -4)) == '.pdf'
            || strtolower(substr($this->full_trim($row->href), -4)) == '.rar'
            || strtolower(substr($this->full_trim($row->href), -4)) == '.docx'
        );
    }

    public function checkA_title($row)
    {
        return true;
    }

    public function checkA_dv($row)
    {
        return true;
    }

    public function checkA_dt($row)
    {
        return true;
    }

    public function checkA_dto($row)
    {
        return true;
    }

    public function checkA_dho($row)
    {
        return true;
    }

    public function checkA_dco($row)
    {
        return true;
    }

    public function checkA_dte($row)
    {
        return true;
    }

    function searchForId($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['uid'] === $id) {
                return $key;
            }
        }
        return null;
    }

    public function translateDomFromTo($dom, $l_from, $l_to)
    {
        if (strlen($this->client->getApiKey()) === 36) {
            $dom = $this->ignoreNodes($dom);
        }

        $html = str_get_html($dom, true, true, DEFAULT_TARGET_CHARSET, false, DEFAULT_BR_TEXT,
            DEFAULT_SPAN_TEXT);

        foreach ($this->excludeBlocks as $exception) {
            foreach ($html->find($exception) as $k => $row) {
                $attribute = 'data-wg-notranslate';
                $row->$attribute = '';
            }
        }

        $words = array();
        $nodes = array();

        $elements_to_check = array(
            'text'
            => array(
                array(
                    'property' => 'outertext',
                    't' => 1,
                    'type' => 'text',
                ),
            ),

            "input[type='submit'],input[type='button']"
            => array(
                array(
                    'property' => 'value',
                    't' => 2,
                    'type' => 'button',
                ),
                array(
                    'property' => 'data-value',
                    't' => 1,
                    'type' => 'input_dv',
                ),
                array(
                    'property' => 'data-order_button_text',
                    't' => 1,
                    'type' => 'input_dobt',
                ),
            ),

            "input[type='radio']"
            => array(
                array(
                    'property' => 'data-order_button_text',
                    't' => 2,
                    'type' => 'rad_obt',
                ),
            ),


            "td"
            => array(
                array(
                    'property' => 'data-title',
                    't' => 2,
                    'type' => 'td_dt',
                ),
            ),

            "input[type=\'text\'],input[type=\'password\'],input[type=\'search\'],input[type=\'email\'],input:not([type]),textarea"
            => array(
                array(
                    'property' => 'placeholder',
                    't' => 3,
                    'type' => 'placeholder',
                ),
            ),

            'meta[name="description"],meta[property="og:title"],meta[property="og:description"],meta[property="og:site_name"],meta[name="twitter:title"],meta[name="twitter:description"]'
            => array(
                array(
                    'property' => 'content',
                    't' => 4,
                    'type' => 'meta_desc',
                ),
            ),

            'iframe'
            => array(
                array(
                    'property' => 'src',
                    't' => 5,
                    'type' => 'iframe_src',
                ),
            ),

            'img'
            => array(
                array(
                    'property' => 'src',
                    't' => 6,
                    'type' => 'img_src',
                ),
                array(
                    'property' => 'alt',
                    't' => 7,
                    'type' => 'img_alt',
                ),
            ),

            'a'
            => array(
                array(
                    'property' => 'href',
                    't' => 8,
                    'type' => 'a_pdf',
                ),
                array(
                    'property' => 'title',
                    't' => 1,
                    'type' => 'a_title',
                ),
                array(
                    'property' => 'data-value',
                    't' => 1,
                    'type' => 'a_dv',
                ),
                array(
                    'property' => 'data-title',
                    't' => 1,
                    'type' => 'a_dt',
                ),
                array(
                    'property' => 'data-tooltip',
                    't' => 1,
                    'type' => 'a_dto',
                ),
                array(
                    'property' => 'data-hover',
                    't' => 1,
                    'type' => 'a_dho',
                ),
                array(
                    'property' => 'data-content',
                    't' => 1,
                    'type' => 'a_dco',
                ),
                array(
                    'property' => 'data-text',
                    't' => 1,
                    'type' => 'a_dte',
                ),
            ),

        );

        foreach ($elements_to_check as $key => $elem) {
            foreach ($html->find($key) as $k => $row) {

                foreach ($elem as $element) {

                    $property = $element['property'];
                    $t = $element['t'];
                    $type = $element['type'];
                    $functionName = 'check' . ucfirst($type);

                    if ($this->full_trim($row->$property) != '' && !$this->hasAncestorAttribute($row,
                            'data-wg-notranslate')
                        && $this->$functionName($row)
                    ) {
                        array_push(
                            $words, array(
                                't' => $t,
                                'w' => $row->$property,
                            )
                        );
                        array_push(
                            $nodes, array(
                                'node' => $row,
                                'type' => $type,
                                'property' => $property,
                            )
                        );
                    }
                }
            }
        }


        $microData = array("description");
        $jsons = array();
        $nbJsonStrings = 0;


        foreach ($html->find('script[type="application/ld+json"]') as $k => $row) {
            $mustAddjson = false;
            $json = json_decode($row->innertext, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                foreach ($microData as $key) {

                    $path = explode(">", $key);
                    $value = $this->getValue($json, $path);

                    if (isset($value)) {
                        $mustAddjson = true;
                        $this->addValues($value, $words, $nbJsonStrings);
                    }

                }

                if ($mustAddjson) {
                    array_push($jsons, array('node' => $row, 'json' => $json));
                }
            }
        }

        $title = 'Empty title';
        foreach ($html->find('title') as $k => $row) {
            if ($row->innertext != '') {
                $title = $row->innertext;
            }
        }


        $absolute_url = $this->full_url($_SERVER);
        $bot = $this->bot_detected();
        $json = $this->client->translate($l_from, $l_to, $bot, $title, $absolute_url, $words);
        $answer = $json;
        if (isset($answer['to_words'])) {
            $translated_words = $answer['to_words'];

            if ((count($nodes) + $nbJsonStrings) == count($translated_words)) {
                for ($i = 0; $i < count($nodes); $i++) {

                    $property = $nodes[$i]['property'];
                    $type = $nodes[$i]['type'];

                    if ($type == "meta_desc") {
                        $nodes[$i]['node']->$property = htmlspecialchars($translated_words[$i]);
                    } else {
                        $nodes[$i]['node']->$property = $translated_words[$i];
                    }


                    if ($nodes[$i]['type'] == 'img_src') {
                        $nodes[$i]['node']->src = $translated_words[$i];
                        if ($nodes[$i]['node']->hasAttribute('srcset') && $nodes[$i]['node']->srcset != '' && $translated_words[$i] != $words[$i]['w']) {
                            $nodes[$i]['node']->srcset = '';
                        }
                    }
                }
                $index = count($nodes);
                for ($j = 0; $j < count($jsons); $j++) {
                    $jsonArray = $jsons[$j]['json'];
                    $node = $jsons[$j]['node'];
                    foreach ($microData as $key) {

                        $path = explode(">", $key);
                        $hasV = $this->getValue($jsonArray, $path);

                        if (isset($hasV)) {
                            $this->setValues($jsonArray, $path, $translated_words, $index);
                        }
                    }
                    $node->innertext = json_encode($jsonArray, JSON_PRETTY_PRINT);

                }

                return $html->save();
            } else {
                throw new \Exception('Unknown error with Weglot Api (0006)');
            }
        } else {
            throw new \Exception('Unknown error with Weglot Api (0005) Error is: ' . $json);
        }
    }

    public function ignoreNodes($dom)
    {
        $nodes_to_ignore = array(
            array('<strong>', '</strong>'),
            array('<em>', '</em>'),
            array('<abbr>', '</abbr>'),
            array('<acronym>', '</acronym>'),
            array('<b>', '</b>'),
            array('<bdo>', '</bdo>'),
            array('<big>', '</big>'),
            array('<cite>', '</cite>'),
            array('<kbd>', '</kbd>'),
            array('<q>', '</q>'),
            array('<small>', '</small>'),
            array('<sub>', '</sub>'),
            array('<sup>', '</sup>'),
        );

        foreach ($nodes_to_ignore as $ignore) {
            $pattern = '#' . $ignore[0] . '([^>]*)?' . $ignore[1] . '#';
            $replace = htmlentities($ignore[0]) . '$1' . htmlentities($ignore[1]);
            $dom = preg_replace($pattern, $replace, $dom);
        }

        return $dom;
    }

    public function hasAncestorAttribute($node, $attribute)
    {

        $currentNode = $node;

        if (isset($currentNode->$attribute)) {
            return true;
        }

        while ($currentNode->parent() && $currentNode->parent()->tag != 'html') {

            if (isset($currentNode->parent()->$attribute)) {
                return true;
            } else {
                $currentNode = $currentNode->parent();
            }
        }
        return false;
    }

    function getValue($data, $path)
    {
        $temp = $data;
        foreach ($path as $key) {
            if (array_key_exists($key, $temp)) {
                $temp = $temp[$key];
            } else {
                return null;
            }
        }
        return $temp;
    }

    function addValues($value, &$words, &$nbJsonStrings)
    {
        if (is_array($value)) {
            foreach ($value as $key => $val) {
                $this->addValues($val, $words, $nbJsonStrings);
            }

        } else {
            array_push(
                $words, array(
                    't' => 1,
                    'w' => $value,
                )
            );
            $nbJsonStrings++;
        }
    }

    function full_url($s, $use_forwarded_host = false)
    {
        return $this->url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
    }

    function url_origin($s, $use_forwarded_host = false)
    {
        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true : false;
        $sp = strtolower($s['SERVER_PROTOCOL']);
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = $s['SERVER_PORT'];
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
        $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }

    function bot_detected()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
//            $ua = sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])); // TODO : use php function
            $ua = $_SERVER['HTTP_USER_AGENT'];
        }
        if (isset($ua)) {
            if (preg_match('/bot|favicon|crawl|facebook|slurp|spider/i', $ua)) {
                if (strpos($ua, 'Google') !== false || strpos($ua, 'facebook') !== false || strpos($ua,
                        'wprocketbot') !== false || strpos($ua, 'SemrushBot') !== false) {
                    return 2;
                } elseif (strpos($ua, 'bing') !== false) {
                    return 3;
                } elseif (strpos($ua, 'yahoo') !== false) {
                    return 4;
                } elseif (strpos($ua, 'Baidu') !== false) {
                    return 5;
                } elseif (strpos($ua, 'Yandex') !== false) {
                    return 6;
                } else {
                    return 1;
                }
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }

    function setValues(&$data, $path, $translatedwords, &$index)
    {

        $temp = &$data;
        foreach ($path as $key) {
            if (array_key_exists($key, $temp)) {
                $temp = &$temp[$key];
            } else {
                return null;
            }
        }

        if (is_array($temp)) {
            foreach ($temp as $key => &$val) {
                $this->setValues($val, null, $translatedwords, $index);
            }
        } else {
            $temp = $translatedwords[$index];
            $index++;
        }

        return;
    }
}