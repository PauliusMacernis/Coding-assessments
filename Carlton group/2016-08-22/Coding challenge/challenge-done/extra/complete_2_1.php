<?php

/**
 * Get all departments data
 *    from DB (=from table department_department with names joined to department_id_father and department_id_child).
 *    The amount of departments isn't big in practice so querying for all data at once is the good way to go this time.
 *
 * @return array
 */
function getHierarchy()
{

    $host = 'localhost';
    $dbName = 'acme';
    $user = 'root';
    $pass = '';

    try {
        // Connect to DB
        $PDO = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $user, $pass);

        // Get hierarchy from DB
        $q = 'SELECT
                dd.department_id_father, dd.department_id_child, dd.hierarchy_level,
                df.title as title_father,
                dc.title as title_child
            FROM department_department as dd
            LEFT JOIN department as df ON (dd.department_id_father = df.id)
            LEFT JOIN department as dc ON (dd.department_id_child = dc.id)';
        $PDOStatement = $PDO->prepare($q);
        $PDOStatement->execute();

        // return hierarchy
        return $PDOStatement->fetchAll($PDO::FETCH_OBJ);

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

}

/**
 * Returns top member of the tree
 * Important! We treat that company has only one top member (aka. head department)
 *
 * @param $tree array of objects
 *
 * @return object|null
 */
function getHeadOfHierarchy($tree)
{

    if (empty($tree)) {
        return;
    }

    foreach ($tree as $item) {
        if ($item->hierarchy_level == 1) {
            // We treat that company has only one top member (aka. department)
            return $item;
        }
    }

}

/**
 * Gets all children of given department
 *
 * @param $departmentInfo   Department information as object
 * @param array $tree Entire tree of departments
 * @return array            Array of objects representing children of given department
 */
function getChildren($departmentInfo, array $tree)
{

    if (!isset($departmentInfo)) {
        return array();
    }

    // get and return all children of $departmentInfo from $tree
    $children = array();
    $childrenLevel = $departmentInfo->hierarchy_level + 1;
    foreach ($tree as $item) {
        if ($item->hierarchy_level == $childrenLevel
            && $item->department_id_father == $departmentInfo->department_id_child
        ) {
            $children[$item->department_id_child] = $item;
        }
    }

    return $children;

}

/**
 * Output the tree (includes recursion)
 *
 * @param array $tree Entire tree of departments
 * @param $departmentInfo   Department information as object
 */
function outputTree(array $tree, $departmentInfo)
{

    print '<li>' . $departmentInfo->title_child;

    foreach (getChildren($departmentInfo, $tree) as $childDepartment) {
        print '<ul class="f' . $departmentInfo->department_id_child . '">';
        outputTree($tree, $childDepartment);
        print '</ul>';
    }

    print '</li>';

}


$tree = getHierarchy();
$treeTop = getHeadOfHierarchy($tree);


// Output the tree
echo '<ul>';
outputTree($tree, $treeTop);
echo '</ul>';
