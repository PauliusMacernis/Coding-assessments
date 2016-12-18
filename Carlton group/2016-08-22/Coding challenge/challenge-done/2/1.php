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

}

/**
 * Output the tree (includes recursion)
 *
 * @param array $tree Entire tree of departments
 * @param $departmentInfo   Department information as object
 */
function outputTree(array $tree, $departmentInfo)
{

    print $departmentInfo->title_child;

    foreach (getChildren($departmentInfo, $tree) as $childDepartment) {
        print $departmentInfo->department_id_child;
        outputTree($tree, $childDepartment);
    }

}


$tree = getHierarchy();
$treeTop = getHeadOfHierarchy($tree);

// Output the tree
outputTree($tree, $treeTop);
