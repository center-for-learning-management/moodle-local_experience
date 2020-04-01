<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local_experience
 * @copyright  2020 Center for Learning Management (http://www.lernmanagement.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . "/externallib.php");

class local_experience_external extends external_api {
    public static function injecttext_parameters() {
        return new external_function_parameters(array(
            'pageid' => new external_value(PARAM_TEXT, 'the page id'),
        ));
    }

    /**
     * Get a tutorial text to inject.
     */
    public static function injecttext($pageid) {
        global $PAGE;
        $PAGE->set_context(context_system::instance());
        $params = self::validate_parameters(self::injecttext_parameters(), array('pageid' => $pageid));
        $ret = array(
            'appendto' => '',
            'prependto' => '',
            'text' => '',
        );
        switch ($pageid) {
            case 'page-question-type-ddwtos':
                $ret['prependto'] = 'form[action="question.php"]';
                $ret['text'] = get_string('injecttext:' . $pageid, 'local_experience');
            break;
            case 'page-question-type-multianswer':
                $ret['prependto'] = 'form[action="question.php"]';
                $ret['text'] = get_string('injecttext:' . $pageid, 'local_experience');
            break;
            case 'page-question-type-wordselect':
                $ret['prependto'] = 'form[action="question.php"]';
                $ret['text'] = get_string('injecttext:' . $pageid, 'local_experience');
            break;
        }
        return $ret;
    }
    /**
     * Return definition.
     * @return external_value
     */
    public static function injecttext_returns() {
        return new external_single_structure(array(
            'appendto' => new external_value(PARAM_TEXT, 'element(s) to append text to'),
            'prependto' => new external_value(PARAM_TEXT, 'element(s) to prepend text to'),
            'text' => new external_value(PARAM_RAW, 'the text'), // may contain HTML
        ));
    }


    public static function switch_parameters() {
        return new external_function_parameters(array(
            'level' => new external_value(PARAM_INT, 'the new level'),
        ));
    }

    /**
     * Switch users's experience level.
     */
    public static function switch($level) {
        global $PAGE;
        $PAGE->set_context(context_system::instance());
        $params = self::validate_parameters(self::switch_parameters(), array('level' => $level));
        set_user_preference('local_experience_level', $params['level']);
        return 1;
    }
    /**
     * Return definition.
     * @return external_value
     */
    public static function switch_returns() {
        return new external_value(PARAM_INT, 'Return 1 if we stored the new preference');
    }
}
