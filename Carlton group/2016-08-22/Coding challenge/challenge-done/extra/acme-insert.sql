# Inserts new department under @newChildOf id

# Id of the old department
SET @newChildOf = 2;

# Default name for the new departmet
SET @newChildName = CONCAT('Department-', UNIX_TIMESTAMP());

# Setting hierarchy level for the new department
SELECT @hierarchyLevel := (MAX(`hierarchy_level`) + 1) FROM department_department WHERE department_id_child = @newChildOf;

# Insert new department data into department table
INSERT INTO department (id, title) VALUES (NULL, @newChildName);

# Insert new department data into department_department table
INSERT INTO department_department (department_id_father, department_id_child, hierarchy_level) 
	SELECT department_id_father, LAST_INSERT_ID(), @hierarchyLevel FROM department_department
	WHERE department_id_child = @newChildOf
	UNION ALL SELECT LAST_INSERT_ID(), LAST_INSERT_ID(), @hierarchyLevel