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
 * Book module upgrade code
 *
 * @package    mod_book
 * @copyright  2009-2011 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 * Book module upgrade task
 *
 * @param int $oldversion the version we are upgrading from
 * @return bool always true
 */
function xmldb_book_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    // Moodle v2.2.0 release upgrade line
    // Put any upgrade step following this

    // Moodle v2.3.0 release upgrade line
    // Put any upgrade step following this
    if ($oldversion < 2013012100) {
    	//create extra table for new settings leaving core alone
		$table = new xmldb_table('book_extras');
		
        // Adding fields to table role_reassign_rules
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('bookid', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);
        $table->add_field('linkstyle', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);

        // Adding keys to table role_reassign_rules
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));	
			
       	if (!$dbman->table_exists($table)) {
           	$dbman->create_table($table);
       	}		
		
		
    	//check for existance of field that was created in previous version that should not :(
        $table = new xmldb_table('book');
        $field = new xmldb_field('linkstyle', XMLDB_TYPE_INTEGER, '4' , XMLDB_UNSIGNED, XMLDB_NOTNULL, null, 0);

        // Conditionally launch field migration
		if ($dbman->field_exists($table, $field)) {
			//move values to the new table
			$sql = "SELECT id, linkstyle FROM {book}";
			$rs = $DB->get_recordset_sql($sql);
			foreach($rs as $res) {
				$extra = new stdClass();
				$extra->bookid = $res->id;
				$extra->linkstyle = $res->linkstyle;
				$extra_update = $DB->insert_record('book_extras', $extra);			
			}
			$rs->close();
			//remove the bad field
            $dbman->drop_field($table, $field);
        }


        // book savepoint reached
        upgrade_mod_savepoint(true, 2013012100, 'book');
    }

    return true;
}
