# Selects all departmens directly under IT and bellow, orders by level in hierarchy and title
SELECT
		dd.department_id_father, dd.department_id_child, dd.hierarchy_level,
		df.title as title_father,
		dc.title as title_child
	FROM department_department as dd
	LEFT JOIN department as df ON (dd.department_id_father = df.id)
	LEFT JOIN department as dc ON (dd.department_id_child = dc.id)
	
	WHERE 
		dd.department_id_father != dd.department_id_child
		AND df.title LIKE 'IT'
		
	ORDER BY 
		dd.hierarchy_level ASC, dc.title ASC