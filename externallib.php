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
