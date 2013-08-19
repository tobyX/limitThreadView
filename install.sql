ALTER TABLE wbb1_1_board ADD
	limitThreadView TINYINT( 1 ) NOT NULL DEFAULT -1;

ALTER TABLE wbb1_1_board_to_group ADD
	canViewLimitedContent TINYINT(1) NOT NULL DEFAULT -1;

ALTER TABLE wbb1_1_board_to_user ADD
	canViewLimitedContent TINYINT(1) NOT NULL DEFAULT -1;