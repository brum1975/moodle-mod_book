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
 * Book plugin settings
 *
 * @package    mod_book
 * @copyright  2004-2011 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once(dirname(__FILE__).'/lib.php');

    // General settings

    $settings->add(new admin_setting_configcheckbox('book/requiremodintro',
        get_string('requiremodintro', 'admin'), get_string('configrequiremodintro', 'admin'), 1));

    $options = book_get_numbering_types();

    $settings->add(new admin_setting_configmultiselect('book/numberingoptions',
        get_string('numberingoptions', 'mod_book'), get_string('numberingoptions_desc', 'mod_book'),
        array_keys($options), $options));

    $options2 = book_get_link_types();
    $settings->add(new admin_setting_configmultiselect('book/linkoptions',
        get_string('linkoptions', 'mod_book'), get_string('linkoptions_desc', 'mod_book'),
        array_keys($options2), $options2));

    // Modedit defaults.

    $settings->add(new admin_setting_heading('bookmodeditdefaults', get_string('modeditdefaults', 'admin'), get_string('condifmodeditdefaults', 'admin')));

    $settings->add(new admin_setting_configselect('book/numbering',
        get_string('numbering', 'mod_book'), '', BOOK_NUM_NUMBERS, $options));

    $settings->add(new admin_setting_configselect('book/linkstyle',
        get_string('linkstyle', 'mod_book'), '', BOOK_LINK_IMAGE, $options2));



}
