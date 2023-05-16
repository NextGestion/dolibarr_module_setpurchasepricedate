<?php

require_once DOL_DOCUMENT_ROOT.'/core/triggers/dolibarrtriggers.class.php';
require_once DOL_DOCUMENT_ROOT.'/user/class/user.class.php';


/**
 *  Class of triggers 
 */
class Interfacesetpurchasepricedatetrigger extends DolibarrTriggers
{

    /**
     * Constructor
     *
     *  @param      DoliDB      $db     Database handler
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->name = preg_replace('/^Interface/i', '', get_class($this));
        $this->family = "NextGestion";
        $this->description = "Triggers of this module are empty functions.";
        $this->version   = 'development';
        $this->picto = 'product';
    }

    /**
     * Function called when a Dolibarrr security audit event is done.
     * All functions "runTrigger" are triggered if file is inside directory htdocs/core/triggers or htdocs/module/code/triggers (and declared)
     *
     * @param string        $action     Event action code
     * @param Object        $object     Object
     * @param User          $user       Object user
     * @param Translate     $langs      Object langs
     * @param conf          $conf       Object conf
     * @return int                      <0 if KO, 0 if no triggered ran, >0 if OK
     */
    public function runTrigger($action, $object, User $user, Translate $langs, Conf $conf)
    {
        global $conf;

        if($action == 'SUPPLIER_PRODUCT_BUYPRICE_MODIFY'){
            $newdatecpricefourn = dol_mktime(GETPOST('newdatecpricefournhour', 'int'), GETPOST('newdatecpricefournmin', 'int'), 0, GETPOST('newdatecpricefournmonth', 'int'), GETPOST('newdatecpricefournday', 'int'), GETPOST('newdatecpricefournyear', 'int'));
            if($newdatecpricefourn){
                $sql = "UPDATE ".MAIN_DB_PREFIX.'product_fournisseur_price SET datec="'.$this->db->idate($newdatecpricefourn).'" WHERE rowid='.$object->product_fourn_price_id;
                $res = $this->db->query($sql);
            }

        }
        
        return 1;
            
    }

}
