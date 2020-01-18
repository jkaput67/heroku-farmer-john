<?php

if (!defined('ABSPATH')) exit;

/* 
 * Based on:         phpSEO
 * Version:          v0.5
 * 
 * Expanded by:      Milan Petrovic, https://www.dev4press.com/
 * 
 * License:          GPL v3
 * Original Date:    17/02/2010
 * Original Author:  Chema Garrido, http://neo22s.com/phpseo
 * Original Notes:   Based on http://neo22s.com/seo-functions-for-php/
 */
class gdcet_terms_extractor {
    private $text;
    private $maxDescriptionLen = 220;
    private $maxKeywords = 25;
    private $minWordLen = 3;
    private $bannedWords = array('able', 'about', 'above', 'act', 'add', 'afraid', 'after', 'again', 'against', 'age', 'ago', 'agree', 'all', 'almost', 'alone', 'along', 'already', 'also', 'although', 'always', 'am', 'amount', 'an', 'and', 'anger', 'angry', 'animal', 'another', 'answer', 'any', 'appear', 'apple', 'are', 'arrive', 'arm', 'arms', 'around', 'arrive', 'as', 'ask', 'at', 'attempt', 'aunt', 'away', 'back', 'bad', 'bag', 'bay', 'be', 'became', 'because', 'become', 'been', 'before', 'began', 'begin', 'behind', 'being', 'bell', 'belong', 'below', 'beside', 'best', 'better', 'between', 'beyond', 'big', 'body', 'bone', 'born', 'borrow', 'both', 'bottom', 'box', 'boy', 'break', 'bring', 'brought', 'bug', 'built', 'busy', 'but', 'buy', 'by', 'call', 'came', 'can', 'cause', 'choose', 'close', 'close', 'consider', 'come', 'consider', 'considerable', 'contain', 'continue', 'could', 'cry', 'cut', 'dare', 'dark', 'deal', 'dear', 'decide', 'deep', 'did', 'die', 'do', 'does', 'dog', 'done', 'doubt', 'down', 'during', 'each', 'ear', 'early', 'eat', 'effort', 'either', 'else', 'end', 'enjoy', 'enough', 'enter', 'even', 'ever', 'every', 'except', 'expect', 'explain', 'fail', 'fall', 'far', 'fat', 'favor', 'fear', 'feel', 'feet', 'fell', 'felt', 'few', 'fill', 'find', 'fit', 'fly', 'follow', 'for', 'forever', 'forget', 'from', 'front', 'gave', 'get', 'gives', 'goes', 'gone', 'good', 'got', 'gray', 'great', 'green', 'grew', 'grow', 'guess', 'had', 'half', 'hang', 'happen', 'has', 'hat', 'have', 'he', 'hear', 'heard', 'held', 'hello', 'help', 'her', 'here', 'hers', 'high', 'hill', 'him', 'his', 'hit', 'hold', 'hot', 'how', 'however', 'I', 'if', 'ill', 'in', 'indeed', 'instead', 'into', 'iron', 'is', 'it', 'its', 'just', 'keep', 'kept', 'knew', 'know', 'known', 'late', 'least', 'led', 'left', 'lend', 'less', 'let', 'like', 'likely', 'likr', 'lone', 'long', 'look', 'lot', 'make', 'many', 'may', 'me', 'mean', 'met', 'might', 'mile', 'mine', 'moon', 'more', 'most', 'move', 'much', 'must', 'my', 'near', 'nearly', 'necessary', 'neither', 'never', 'next', 'no', 'none', 'nor', 'not', 'note', 'nothing', 'now', 'number', 'of', 'off', 'often', 'oh', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'out', 'please', 'prepare', 'probable', 'pull', 'pure', 'push', 'put', 'raise', 'ran', 'rather', 'reach', 'realize', 'reply', 'require', 'rest', 'run', 'said', 'same', 'sat', 'saw', 'say', 'see', 'seem', 'seen', 'self', 'sell', 'sent', 'separate', 'set', 'shall', 'she', 'should', 'side', 'sign', 'since', 'so', 'sold', 'some', 'soon', 'sorry', 'stay', 'step', 'stick', 'still', 'stood', 'such', 'sudden', 'suppose', 'take', 'taken', 'talk', 'tall', 'tell', 'ten', 'than', 'thank', 'that', 'the', 'their', 'them', 'then', 'there', 'therefore', 'these', 'they', 'this', 'those', 'though', 'through', 'till', 'to', 'today', 'told', 'tomorrow', 'too', 'took', 'tore', 'tought', 'toward', 'tried', 'tries', 'trust', 'try', 'turn', 'two', 'under', 'until', 'up', 'upon', 'us', 'use', 'usual', 'various', 'verb', 'very', 'visit', 'want', 'was', 'we', 'well', 'went', 'were', 'what', 'when', 'where', 'whether', 'which', 'while', 'white', 'who', 'whom', 'whose', 'why', 'will', 'with', 'within', 'without', 'would', 'yes', 'yet', 'you', 'young', 'your', 'br', 'img', 'p', 'lt', 'gt', 'quot', 'copy');

    function __construct($text = null) {
        $this->setText($text);
    }

    /**
     * Get the description.
     *
     * @param ing $len length for the description
     * @return string 
     */
    public function getMetaDescription($len = null) {
        $this->setDescriptionLen($len);

        return substr($this->getText(), 0, $this->getDescriptionLen());
    }

    /**
     * Get the list of keywords.
     *
     * @param ing $mKw number of keywords
     * @return array list of the keywords
     */
    public function getKeyWords($mKw = null) {
        $this->setMaxKeywords($mKw);

        $text = $this->getText();
        $text = str_replace(array('Ã¢â‚¬â€œ', '{', '}', '[', ']', '(', ')', '+', ':', '.', '?', '!', '_', '*', '-'), '', $text);
        $text = str_replace(array(' ', '.'), ',', $text);

        $wordCounter = array();

        $arrText = explode(',', $text);
        unset($text);

        foreach ($arrText as $value)  {
            $value = trim($value);

            if (strlen($value) >= $this->getMinWordLen() && !in_array($value, $this->getBannedWords())) {
                if (array_key_exists($value, $wordCounter)) {
                    $wordCounter[$value] = $wordCounter[$value]+1;
                } else {
                    $wordCounter[$value] = 1;
                }
            }
        }

        unset($arrText);

        uasort($wordCounter, array($this, 'cmp'));

        $i = 1;
        $keywords = array();
        foreach($wordCounter as $key => $value) {
            $keywords[] = sanitize_title($key);

            if ($i < $this->getMaxKeywords()) {
                $i++;
            } else {
                break;
            }
        }

        unset($wordCounter);
        return $keywords;
    }

    /**
     * Set the content for parsing.
     *
     * @param string $text content for parsing.
     */
    public function setText($text) {
        $text = strip_shortcodes($text);
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);
        $text = strip_tags($text);
        $text = preg_replace('/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $text);

        $text = str_replace(array('\t'), ' ', $text);
        $text = str_replace(array('\r\n', '\n', '\r', '+'), ',', $text);
        $text = remove_accents($text);

        $text = strtolower($text);
        $this->text = $text;
    }

    /**
     * Get the content.
     *
     * @return string content.
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set length for the description.
     *
     * @param int $len length for the descritpion
     */
    public function setDescriptionLen($len) {
        if (is_numeric($len)) {
            $this->maxDescriptionLen = $len;
        }
    }

    /**
     * Get length for the description.
     *
     * @return int length for the descritpion
     */
    public function getDescriptionLen() {
        return $this->maxDescriptionLen;
    }

    /**
     * Set number of keywords.
     *
     * @param int $len number of keywords
     */
    public function setMaxKeywords($len) {
        if (is_numeric($len)) {
            $this->maxKeywords = $len;
        }
    }

    /**
     * Get number of keywords.
     *
     * @return int number of keywords
     */
    public function getMaxKeywords() {
        return $this->maxKeywords;
    }

    /**
     * Set minimal keyword length.
     *
     * @param type $len minimal keyword length
     */
    public function setMinWordLen($len) {
        if (is_numeric($len)) {
            $this->minWordLen = $len;
        }
    }

    /**
     * Get minimal keyword length.
     *
     * @return int minimal keyword length
     */
    public function getMinWordLen() {
        return $this->minWordLen;
    }

    /**
     * Set list of banned keywords.
     *
     * @param string|array $words comma separated keywords string or array 
     * with keywords.
     */
    public function setBannedWords($words) {
        if (isset($words)) {
            if (!is_array($words)) {
                $words = explode(",", $words);
            }

            $this->bannedWords = $words;
        }
    }

    /**
     * Get the list of banned words.
     *
     * @return array list of banned words
     */
    public function getBannedWords() {
        return $this->bannedWords;
    }

    /**
     * Compare two values to determine if they are equal, smaller or bigger.
     *
     * @param mixed $a first value to compare
     * @param mixed $b second value to compare
     * @return int 0 if equal, 1 if $a is smaller, -1 if $b is smaller
     */
    public function cmp($a, $b) {
        if ($a == $b) {
            return 0;
        }

        return ($a < $b) ? 1 : -1;
    }
}
