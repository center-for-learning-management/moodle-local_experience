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
 * @copyright  2021 Center for Learning Management (https://www.lernmanagement.at)
 * @author     Robert Schrenk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_experience;

defined('MOODLE_INTERNAL') || die;

class lib_wshelper {
    public static $navbarnodes = [];
    private static $debug = false;

    /**
     * Recognizes the result of a certain script and registers an output buffer for it.
     */
    public static function buffer() {
        global $CFG;
        self::$debug = ($CFG->debug == 32767); // Developer debugging
        $func = str_replace('__', '_', 'buffer_' . str_replace('/', '_', str_replace('.php', '', str_replace($CFG->dirroot, '', $_SERVER["SCRIPT_FILENAME"]))));
        if (method_exists(__CLASS__, $func)) {
            if (self::$debug) {
                error_log('Buffer function ' . $func . ' called');
            }
            ob_start();
            register_shutdown_function('\local_experience\lib_wshelper::buffer_modify');
        } else {
            if (self::$debug) {
                error_log('Buffer function ' . $func . ' not found');
            }
            return false;
        }
    }

    /**
     * Determines the appropriate handler-method for this output buffer.
     */
    public static function buffer_modify() {
        global $CFG;
        $buffer = ob_get_clean();
        $func = str_replace('__', '_', 'buffer_' . str_replace('/', '_', str_replace('.php', '', str_replace($CFG->dirroot, '', $_SERVER["SCRIPT_FILENAME"]))));
        call_user_func('self::' . $func, $buffer);
    }

    public static function buffer_course_dndupload($buffer) {
        global $DB;

        $enabled = \get_config('local_experience', 'auto_set_completion_details');
        $dnddays = \get_config('local_experience', 'auto_set_completion_add_days_dnd');
        if (empty($enabled) || empty($dnddays)) {
            die($buffer);
        }

        $courseid = optional_param('course', '', PARAM_INT);
        $section = optional_param('section', '', PARAM_INT);
        $type = optional_param('type', '', PARAM_TEXT);
        $modulename = optional_param('module', '', PARAM_PLUGIN);

        if (!empty($courseid) && ($modulename == 'resource' || $modulename == 'label')) {
            error_log("course $courseid section $section type $type modulename $modulename");
            $section = array_values($DB->get_records('course_sections', ['course' => $courseid, 'section' => $section]));
            error_log(print_r($section, 1));
            if (count($section) > 0) {
                $sectionid = $section[0]->id;
                error_log('section ' . $sectionid);

                $sql = 'SELECT id
                            FROM {course_modules}
                            WHERE course = ?
                                AND section = ?
                            ORDER BY id DESC LIMIT 0,1';
                $mod = $DB->get_record_sql($sql, [$courseid, $sectionid]);
                $DB->set_field('course_modules', 'completion', 2, ['id' => $mod->id]);
                $DB->set_field('course_modules', 'completionview', 1, ['id' => $mod->id]);
                $DB->set_field('course_modules', 'completionexpected', strtotime("+$dnddays days"), ['id' => $mod->id]);

                error_log('mod ' . $mod->id);

                $strfrom = get_string('completion-alt-manual-enabled', 'core_completion');
                $strfrom = substr($strfrom, 0, strpos($strfrom, ':'));
                $strto = get_string('completion-alt-auto-enabled', 'core_completion');
                $strto = substr($strto, 0, strpos($strto, ':'));
                error_log("replace $strfrom to $strto");
                $buffer = str_replace($strfrom, $strto, $buffer);
                $buffer = str_replace('completion-manual-enabled', 'completion-auto-enabled', $buffer);
            }
        }

        echo $buffer;
    }
}
