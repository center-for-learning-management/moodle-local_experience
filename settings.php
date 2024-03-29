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

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_experience_settings', get_string('pluginname:settings', 'local_experience'));
    $ADMIN->add('localplugins', new admin_category('local_experience', get_string('pluginname', 'local_experience')));
    $ADMIN->add('local_experience', $settings);

    $settings->add(
        new admin_setting_configcheckbox(
            'local_experience/auto_set_completion_details',
            get_string('auto_set_completion_details', 'local_experience'),
            get_string('auto_set_completion_details:description', 'local_experience'),
            1
        )
    );
    $settings->add(
        new admin_setting_configtext(
            'local_experience/auto_set_completion_add_days',
            get_string('auto_set_completion_add_days', 'local_experience'),
            get_string('auto_set_completion_add_days:description', 'local_experience'),
            7,
            PARAM_INT
        )
    );
    $settings->add(
        new admin_setting_configtext(
            'local_experience/auto_set_completion_add_days_dnd',
            get_string('auto_set_completion_add_days_dnd', 'local_experience'),
            get_string('auto_set_completion_add_days_dnd:description', 'local_experience'),
            3,
            PARAM_INT
        )
    );

    $ADMIN->add(
        'local_experience',
        new admin_externalpage(
            'local_experience_conditions',
            get_string('conditions', 'local_experience'),
            $CFG->wwwroot . '/local/experience/conditions.php'
        )
    );
    $ADMIN->add(
        'local_experience',
        new admin_externalpage(
            'local_experience_rules',
            get_string('rules', 'local_experience'),
            $CFG->wwwroot . '/local/experience/rules.php'
        )
    );
    $ADMIN->add(
        'local_experience',
        new admin_externalpage(
            'local_experience_c_r',
            get_string('c_r', 'local_experience'),
            $CFG->wwwroot . '/local/experience/c_r.php'
        )
    );

    $settings->add(
        new admin_setting_configtextarea(
            'local_experience/attachlevelselectto',
            get_string('attachlevelselectto', 'local_experience'),
            get_string('attachlevelselectto:description', 'local_experience'),
            "#page-wrapper>.navbar>ul:last-child|prepend\n#chooserform div.submitbuttons|prepend|false",
            PARAM_TEXT
        )
    );
}
