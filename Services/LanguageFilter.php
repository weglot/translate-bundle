<?php
/**
 * @author Floran Pagliai
 * Date: 13/12/2017
 * Time: 16:04
 */

namespace Weglot\TranslateBundle\Services;


class LanguageFilter
{

    public static function languageFilter($locale, $getEnglish = true)
    {
        switch ($locale) {
            case "sq":
                return $getEnglish ? "Albanian" : "Shqip";
            case "en":
                return $getEnglish ? "English" : "English";
            case "ar":
                return $getEnglish ? "Arabic" : "‏العربية‏";
            case "hy":
                return $getEnglish ? "Armenian" : "հայերեն";
            case "az":
                return $getEnglish ? "Azerbaijani" : "Azərbaycan dili";
            case "af":
                return $getEnglish ? "Afrikaans" : "Afrikaans";
            case "eu":
                return $getEnglish ? "Basque" : "Euskara";
            case "be":
                return $getEnglish ? "Belarusian" : "Беларуская";
            case "bg":
                return $getEnglish ? "Bulgarian" : "български";
            case "bs":
                return $getEnglish ? "Bosnian" : "Bosanski";
            case "cy":
                return $getEnglish ? "Welsh" : "Cymraeg";
            case "vi":
                return $getEnglish ? "Vietnamese" : "Tiếng Việt";
            case "hu":
                return $getEnglish ? "Hungarian" : "Magyar";
            case "ht":
                return $getEnglish ? "Haitian" : "Kreyòl ayisyen";
            case "gl":
                return $getEnglish ? "Galician" : "Galego";
            case "nl":
                return $getEnglish ? "Dutch" : "Nederlands";
            case "el":
                return $getEnglish ? "Greek" : "Ελληνικά";
            case "ka":
                return $getEnglish ? "Georgian" : "ქართული";
            case "da":
                return $getEnglish ? "Danish" : "Dansk";
            case "he":
                return $getEnglish ? "Hebrew" : "עברית";
            case "id":
                return $getEnglish ? "Indonesian" : "Bahasa Indonesia";
            case "ga":
                return $getEnglish ? "Irish" : "Gaeilge";
            case "it":
                return $getEnglish ? "Italian" : "Italiano";
            case "is":
                return $getEnglish ? "Icelandic" : "Íslenska";
            case "es":
                return $getEnglish ? "Spanish" : "Español";
            case "kk":
                return $getEnglish ? "Kazakh" : "Қазақша";
            case "ca":
                return $getEnglish ? "Catalan" : "Català";
            case "ky":
                return $getEnglish ? "Kyrgyz" : "кыргызча";
            case "zh":
                return $getEnglish ? "Simplified Chinese" : "中文 (简体)";
            case "tw":
                return $getEnglish ? "Traditional Chinese" : "中文 (繁體)";
            case "ko":
                return $getEnglish ? "Korean" : "한국어";
            case "lv":
                return $getEnglish ? "Latvian" : "Latviešu";
            case "lt":
                return $getEnglish ? "Lithuanian" : "Lietuvių";
            case "mg":
                return $getEnglish ? "Malagasy" : "Malagasy";
            case "ms":
                return $getEnglish ? "Malay" : "Bahasa Melayu";
            case "mt":
                return $getEnglish ? "Maltese" : "Malti";
            case "mk":
                return $getEnglish ? "Macedonian" : "Македонски";
            case "mn":
                return $getEnglish ? "Mongolian" : "Монгол";
            case "de":
                return $getEnglish ? "German" : "Deutsch";
            case "no":
                return $getEnglish ? "Norwegian" : "Norsk";
            case "fa":
                return $getEnglish ? "Persian" : "فارسی";
            case "pl":
                return $getEnglish ? "Polish" : "Polski";
            case "pt":
                return $getEnglish ? "Portuguese" : "Português";
            case "ro":
                return $getEnglish ? "Romanian" : "Română";
            case "ru":
                return $getEnglish ? "Russian" : "Русский";
            case "sr":
                return $getEnglish ? "Serbian" : "Српски";
            case "sk":
                return $getEnglish ? "Slovak" : "Slovenčina";
            case "sl":
                return $getEnglish ? "Slovenian" : "Slovenščina";
            case "sw":
                return $getEnglish ? "Swahili" : "Kiswahili";
            case "tg":
                return $getEnglish ? "Tajik" : "Тоҷикӣ";
            case "th":
                return $getEnglish ? "Thai" : "ภาษาไทย";
            case "tl":
                return $getEnglish ? "Tagalog" : "Tagalog";
            case "tt":
                return $getEnglish ? "Tatar" : "Tatar";
            case "tr":
                return $getEnglish ? "Turkish" : "Türkçe";
            case "uz":
                return $getEnglish ? "Uzbek" : "O'zbek";
            case "uk":
                return $getEnglish ? "Ukrainian" : "Українська";
            case "fi":
                return $getEnglish ? "Finnish" : "Suomi";
            case "fr":
                return $getEnglish ? "French" : "Français";
            case "hr":
                return $getEnglish ? "Croatian" : "Hrvatski";
            case "cs":
                return $getEnglish ? "Czech" : "Čeština";
            case "sv":
                return $getEnglish ? "Swedish" : "Svenska";
            case "et":
                return $getEnglish ? "Estonian" : "Eesti";
            case "ja":
                return $getEnglish ? "Japanese" : "日本語";
            case "hi":
                return $getEnglish ? "Hindi" : "हिंदी";
            case "ur":
                return $getEnglish ? "Urdu" : "اردو";
            case "co":
                return $getEnglish ? "Corsican" : "Corsu";
            case "fj":
                return $getEnglish ? "Fijian" : "Vosa Vakaviti";
            case "haw":
                return $getEnglish ? "Hawaiian" : "‘Ōlelo Hawai‘i";
            case "ig":
                return $getEnglish ? "Igbo" : "Igbo";
            case "ny":
                return $getEnglish ? "Chichewa" : "chiCheŵa";
            case "ps":
                return $getEnglish ? "Pashto" : "پښت";
            case "sd":
                return $getEnglish ? "Sindhi" : "سنڌي، سندھی, सिन्धी";
            case "sn":
                return $getEnglish ? "Shona" : "chiShona";
            case "to":
                return $getEnglish ? "Tongan" : "faka-Tonga";
            case "yo":
                return $getEnglish ? "Yoruba" : "Yorùbá";
            case "zu":
                return $getEnglish ? "Zulu" : "isiZulu";
            case "ty":
                return $getEnglish ? "Tahitian" : "te reo Tahiti, te reo Māʼohi";
            case "sm":
                return $getEnglish ? "Samoan" : "gagana fa'a Samoa";
            case "ku":
                return $getEnglish ? "Kurdish" : "كوردی";
            case "ha":
                return $getEnglish ? "Hausa" : "هَوُسَ";
            case "bn":
                return $getEnglish ? "Bengali" : "বাংলা";
            case "st":
                return $getEnglish ? "Southern Sotho" : "seSotho";
        }
    }
}