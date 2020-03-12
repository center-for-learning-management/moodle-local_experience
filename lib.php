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
 * @copyright  2018 Digital Education Society (http://www.dibig.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot . '/local/experience/locallib.php');

function local_experience_before_standard_html_head() {
    global $CFG, $DB, $PAGE;

    $level = get_user_preferences('local_experience_level', 0);
    $rulesapplied = 0;

    if (empty($level)) {
        $scriptname = str_replace($CFG->dirroot, "", $_SERVER["SCRIPT_FILENAME"]);
        $sql = "SELECT *
                    FROM {local_experience_conditions}
                    WHERE patternscriptnames LIKE ?
                        OR patternscriptnames='*'";
        $conditions = $DB->get_records_sql($sql, array($scriptname));
        $applyconditions = array();
        foreach ($conditions AS $condition) {
            $params = explode('&', $condition->patternparameters);
            $isok = true;
            foreach ($params AS $param) {
                $pair = explode('=', $param);
                if (count($pair) == 2 && optional_param($pair[0], '', PARAM_RAW) != $pair[1]) {
                    $isok = false;
                }
            }
            if ($isok) {
                $applyconditions[] = $condition->id;
            }
        }
        if (count($applyconditions) > 0) {
            $sql = "SELECT *
                        FROM {local_experience_rules}
                        WHERE id IN (" . implode(',', $applyconditions) . ")
                        ORDER BY sort ASC";
            $rules = $DB->get_records_sql($sql, array());
            foreach ($rules AS $rule) {
                $rulesapplied = 1;
                $PAGE->requires->js_call_amd("local_experience/main", "applyRules", array($rule->elementstohide, $rule->elementstoset));
            }
        }
    }
    $PAGE->requires->js_call_amd("local_experience/main", "injectButton", array($level, $rulesapplied));

    return "";
}

function local_experience_extend_navigation($navigation) {

}
/**
 * Extend navigation.
 */
function local_experience_extend_navigation_frontpage($parentnode) {
    // @TODO add a button somehow to toggle between advanced and basic mode.
}
