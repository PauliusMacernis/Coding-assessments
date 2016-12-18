<?php

namespace CorporateBond\Challenge;

use Aura\Cli\CliFactory;

class Calculator
{
    /**
     * Main method to calculate Yield spread
     *
     * @param   array $data
     * @return  array
     */
    public function calculateYieldSpread(array $data)
    {

        $data = $this->separateDataByType($data);

        if (empty($data['corporate'])) {
            return array();
        }

        $results = array();

        foreach ($data['corporate'] as $dataCorporateRow) {
            $results[$dataCorporateRow['bond']] = $this->calculateYieldSpreadOne($dataCorporateRow, $data['government']);
        }

        return $results;

    }

    /**
     * Separates data by type found in CSV
     *
     * @param array $data
     * @return array
     */
    private function separateDataByType(array $data = array())
    {
        if (empty($data)) {
            return array();
        }

        $result = array();

        foreach ($data as $row) {
            if (!isset($result[$row['type']])) {
                $result[$row['type']] = array();
            }
            $result[$row['type']][] = $row;
        }

        return $result;

    }

    /**
     * Counts yield spread of the corporate X
     *
     * @param array $dataCorporateRow Associated array (name as in CSV => value)
     * @param array $dataGovernment
     * @return array
     */
    private function calculateYieldSpreadOne($dataCorporateRow, array $dataGovernment)
    {

        $indexYearsDiffAbs = '_yearsDiffAbs';
        $indexSpreadToBenchmark = 'spread_to_benchmark';

        $bestCandidateRows = $this->getBestGovCandidateRows($dataCorporateRow, $dataGovernment, $indexYearsDiffAbs);

        foreach ($bestCandidateRows as &$row) {
            $row[$indexSpreadToBenchmark] = $dataCorporateRow['yield'] - $row['yield'];
        }
        unset($row);
        reset($bestCandidateRows);

        return $bestCandidateRows;

    }

    // Usually one row returned, but if equal rows exists then multiple rows will be returned
    /**
     * Gets best government candidates for particular corporate
     *
     * @param array $corBondRow
     * @param array $govBondRows
     * @param $indexForLowestValue
     * @return array
     */
    private function getBestGovCandidateRows(array $corBondRow = array(), array $govBondRows = array(), $indexForLowestValue)
    {

        $lowestDiffAbs = array(); // array, because there could be situation we will have the same years

        // Get term diffs for all (WARNING! we treat all terms as equal meaning, for example - all terms are in years only)
        foreach ($govBondRows as $govBondKey => $govBondRow) {
            $this->mergeLowestDiffs(
                $lowestDiffAbs,
                $govBondKey,
                $govBondRow,
                abs($corBondRow['term'] - $govBondRow['term']),
                $indexForLowestValue
            );
            reset($lowestDiffAbs);
        }

        return $lowestDiffAbs;
    }

    /**
     * Get term diff
     *
     * @param $lowestDiffAbs
     * @param $govBondKey
     * @param $govBondRow
     * @param $currentDiffAbs
     * @param $index
     */
    private function mergeLowestDiffs(&$lowestDiffAbs, $govBondKey, $govBondRow, $currentDiffAbs, $index)
    {

        // First time
        if (empty($lowestDiffAbs)) {
            $lowestDiffAbs[$govBondKey] = $govBondRow;
            $lowestDiffAbs[$govBondKey][$index] = $currentDiffAbs;
            return;
        }

        // Not first time
        $_lowestDiffAbs = reset($lowestDiffAbs);     // take any row, because they all have the same diff value
        if ($_lowestDiffAbs[$index] > $currentDiffAbs) {
            $lowestDiffAbs = array();               // new values found, replace all existing
            $lowestDiffAbs[$govBondKey] = $govBondRow;
            $lowestDiffAbs[$govBondKey][$index] = $currentDiffAbs;
            return;
        }

        if ($_lowestDiffAbs[$index] == $currentDiffAbs) {
            $lowestDiffAbs[$govBondKey] = $govBondRow;         // add extra item as it has the same term diff
            $lowestDiffAbs[$govBondKey][$index] = $currentDiffAbs;
            return;
        }

    }

    /**
     * Outputs data
     *
     * @param array $results Results to output line by line
     * @param CliFactory $cli_factory
     */
    public function outputYieldSpread($results, CliFactory $cli_factory)
    {

        $stdio = $cli_factory->newStdio();
        $stdio->outln('bond,benchmark,spread_to_benchmark');

        foreach ($results as $cBondName => $cBondData) {
            foreach ($cBondData as $gData) {
                $stdio->outln(
                    (string)$cBondName . ','
                    . (string)$gData['bond'] . ','
                    . number_format($gData['spread_to_benchmark'], 2) . '%'
                );
            }
        }
    }

    /**
     * Main method to calculate spread to curve
     *
     * @param $data
     * @return array|mixed
     */
    public function calculateSpreadToCurve($data)
    {
        $dataOrderedByTerm = $this->getDataOrderedBy('term', $data);
        $dataOrderedByTermCopy = $dataOrderedByTerm;

        $gTypeKey = 'government';
        $cSpreadToCurveKey = 'spread_to_curve';
        foreach ($dataOrderedByTerm as $dataKey => $dataRow) {
            if ($dataRow['type'] == $gTypeKey) {
                $g1 = $dataRow;
                continue; // continue until corporate
            } else {
                $g2 = $this->getG2($gTypeKey, $dataKey, $dataRow, $dataOrderedByTermCopy); // if corporate already found then we have g1 already so get g2 now
            }

            // $c1 = $dataRow

            $dataOrderedByTerm[$dataKey][$cSpreadToCurveKey] = $this->getSpreadToCurve($dataRow, $g1, $g2, 'yield');

        }

        // Filter government data
        $dataOrderedByTerm = array_filter($dataOrderedByTerm, function ($row) {
            return ($row['type'] == 'government') ? 0 : 1;
        });

        return $dataOrderedByTerm;

    }

    /**
     * Order data array by key
     *
     * @param $key
     * @param array $data
     * @return array
     */
    private function getDataOrderedBy($key, $data)
    {

        uasort($data, function ($a, $b) use ($key) {
            if ($a[$key] == $b[$key]) {
                return 0;
            }
            return ($a[$key] < $b[$key]) ? -1 : 1;
        });

        return $data;

    }

    /**
     * Gets G2 (see https://gist.github.com/apotapov/3118c573df2a4ac7a93f00cf39ea620a )
     *
     * @param $gTypeKey
     * @param $dataKey
     * @param $dataRow
     * @param $dataOrderedByTerm
     * @return array
     */
    private function getG2($gTypeKey, $dataKey, $dataRow, $dataOrderedByTerm)
    {
        if (!isset($dataKey) || empty($dataRow) || empty($dataOrderedByTerm)) {
            return array();
        }

        // @todo: Optimize this to not iterate the copy. Much faster and much less memory consuming would be iterating the same array back and forward
        $currentKeyFound = false;
        foreach ($dataOrderedByTerm as $key => $value) {
            // Just roll over until "current" pointer will be found
            if (!$currentKeyFound && ($key !== $dataKey)) {
                continue;
            } else {
                $currentKeyFound = true;
            }

            // "current" pointer is found, let's check for government data we need!
            if ($value['type'] != $gTypeKey) { // ignore corporate data, we need government
                continue;
            }

            // government is found, return it - this is g2
            return $value;
        }

    }


    // @todo: probably would skip using these params: "$yieldKey", "$gTypeKey" and other "$...Key" variables..
    /**
     * Gets spread to curve for one data row
     *
     * @param $dataRow
     * @param $g1
     * @param $g2
     * @param $yieldKey
     * @return mixed
     */
    private function getSpreadToCurve($dataRow, $g1, $g2, $yieldKey)
    {
        $a = $dataRow[$yieldKey];
        $b = $this->getSpreadToCurveBValue($dataRow, $g1, $g2);

        $spreadToCurve = $a - $b;

        return $spreadToCurve;
    }

    /**
     * Gets B value. More info: https://gist.github.com/apotapov/3118c573df2a4ac7a93f00cf39ea620a
     *
     * @param $c1
     * @param $g1
     * @param $g2
     * @return mixed
     */
    private function getSpreadToCurveBValue($c1, $g1, $g2)
    {

        // y = y1 + ((y2 - y1) / (x2 - x1)) * (x - x1)

        $x = $c1['term'];
        $x1 = $g1['term'];
        $x2 = $g2['term'];
        $y1 = $g1['yield'];
        $y2 = $g2['yield'];

        return $y1 + (($y2 - $y1) / ($x2 - $x1)) * ($x - $x1);

    }

    /**
     * Outputs data
     *
     * @param array $cResults
     * @param CliFactory $cli_factory
     */
    public function outputSpreadToCurve(array $cResults, CliFactory $cli_factory)
    {
        $stdio = $cli_factory->newStdio();
        $stdio->outln('bond,spread_to_curve');

        foreach ($cResults as $cData) {
            $stdio->outln(
                (string)$cData['bond'] . ','
                . number_format($cData['spread_to_curve'], 2) . '%'
            );
        }
    }

}