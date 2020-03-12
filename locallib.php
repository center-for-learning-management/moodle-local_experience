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
 * @copyright  2020 Zentrum für Lernmanagement (www.lernmanagement.at)
 * @author    Robert Schrenk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_experience;

defined('MOODLE_INTERNAL') || die;

class lib {
    public static function addrule() {
        global $DB;
        $rule = (object) array(
            'name' => '',
            'sort' => 99,
            'elementstohide' => '',
            'elementstoset' => '',
        );
        $rule->id = $DB->insert_record('local_experience_rules', $rule);
        return $rule;
    }
    public static function addcondition() {
        global $DB;
        $condition = (object) array(
            'name' => '',
            'patternscriptnames' => '',
            'patternparameters' => '',
        );
        $condition->id = $DB->insert_record('local_experience_conditions', $condition);
        return $condition;
    }
}
