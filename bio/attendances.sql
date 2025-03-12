-- the UNIQUE keyword will make sure that there is no duplicate data
CREATE TABLE `attendances` (
	`userid` VARCHAR(20) NULL,
	`attn_timestamp` DATETIME,
	`attn_type` VARCHAR(50),
	UNIQUE (`userid`, `attn_date`, `attn_timestamp`)
);
