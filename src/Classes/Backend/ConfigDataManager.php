<?php

namespace Slashworks\ContaoTrackingManagerBundle\Classes\Backend;

use Contao\BackendModule;
use Contao\Database;
use Slashworks\ContaoTrackingManagerBundle\Model\TrackingmanagerSettingsModel;
use Symfony\Component\VarDumper\VarDumper;

class ConfigDataManager extends BackendModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_configdata';

    /**
     * Generate the module
     *
     * Add statistics with Hook like this
     *
     * $GLOBALS['TL_HOOKS']['generateTimeConfig'] =
     * array('myRowTitle' => array(
     *                  'start' => new \DateTime('01.01.1970'),
     *                  'end' => new \DateTime(),
     *                  'status' => 1
     *                )
     *       );
     *
     *  language for template
     *  $GLOBALS['TL_LANG']['tl_tmConfig']['myRowTitle'] = 'My language variable';
     *
     * @throws \Exception
     */
    protected function compile()
    {
        $combiner = new \Combiner();
        $combiner->add('/bundles/contaotrackingmanager/css/backend.scss');
        $GLOBALS['TL_CSS'][] = $combiner->getCombinedFile();

        $this->getCookieCollection();

        $arrTimeConfig = array(
            'complete' => array(
                'start' => new \DateTime('01.01.1970'),
                'end' => new \DateTime(),
                'status' => 1
            ),
            'thisMonth' => array(
                'start' => new \DateTime('first day of this month'),
                'end' => new \DateTime('Now'),
                'status' => 1
            ),
            'lastMonth' => array(
                'start' => new \DateTime('first day of last month'),
                'end' => new \DateTime('last day of last month'),
                'status' => 1
            )
        );

        // Merge hook variables
        if(is_array($GLOBALS['TL_HOOKS']['generateTimeConfig'])){
            $arrTimeConfig = array_merge($arrTimeConfig,$GLOBALS['TL_HOOKS']['generateTimeConfig']);
        }

        foreach ($arrTimeConfig as $name=>$block){
            $dataBlock[$name] =  $this->generateDataInTime($block['start'],$block['end'],$block['status']);
        }

        $this->Template->dataBlock = $dataBlock;
    }


    /**
     *
     */
    protected function getCookieCollection()
    {
        $this->objCookies = TrackingmanagerSettingsModel::findAll();
        $this->Template->cookieCollection = $this->objCookies;
    }


    /**
     * @param $start
     * @param $end
     * @return mixed
     */
    protected function generateDataInTime(\DateTime $start, \DateTime $end, int $status)
    {
        $db = Database::getInstance();
        $where = "tstamp > ".$start->format('U')." and tstamp < ".$end->format('U') ." and status = ".$status;

        $totalCounts = 'SELECT * FROM tl_tmConfig WHERE '.$where.' GROUP by tstamp';
        $totalUser = 'SELECT * FROM tl_tmConfig WHERE '.$where.' GROUP by pid ';

        foreach ($this->objCookies as $key => $cookie) {
            $cookieCount = "SELECT * FROM tl_tmConfig WHERE title = '" . $cookie->name . "' and ".$where;
            $arrCookkies[$cookie->name] = $db->query($cookieCount)->numRows;
        }

        $return['total'] = $db->query($totalCounts)->numRows;
        $return['user'] = $db->query($totalUser)->numRows;
        $return['cookies'] = $arrCookkies;

        return $return;
    }



}
