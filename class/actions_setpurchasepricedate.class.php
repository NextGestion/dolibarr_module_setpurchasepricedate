<?php

/**
 * Class Actionssetpurchasepricedate
 */
class Actionssetpurchasepricedate
{
	/**
	 * @var array Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * @var array Errors
	 */
	public $errors = array();

	/**
	 * Constructor
	 */

	public function __construct($db){
		$this->db = $db;
	}

	function doActions($parameters, &$object, &$action, $hookmanager){
		global $conf, $langs, $user, $confirm, $db;

		$id = GETPOST('rowid');

		if($parameters['currentcontext'] == 'pricesuppliercard' && $object->element == 'product' && $id>0){
			$datecpricefourn = dol_mktime(GETPOST('datecpricefournhour', 'int'), GETPOST('datecpricefournmin', 'int'), 0, GETPOST('datecpricefournmonth', 'int'), GETPOST('datecpricefournday', 'int'), GETPOST('datecpricefournyear', 'int'));

			if($action == 'save_price' && $datecpricefourn>0){
				$sql = "UPDATE ".MAIN_DB_PREFIX.'product_fournisseur_price SET datec="'.$this->db->idate($datecpricefourn).'" WHERE rowid='.$id;
				$res = $this->db->query($sql);
			}
		}
	}

	public function formObjectOptions($parameters, &$object, &$action, $hookmanager)
	{
		global $langs, $conf;

		require_once DOL_DOCUMENT_ROOT.'/core/class/html.form.class.php';
			
		if($parameters['currentcontext'] == 'pricesuppliercard' && $object->element == 'product'){
			$form = new Form($this->db);

			$id_fourn = $parameters['id_fourn'];

			if($action == 'update_price'){

				$datecpricefourn = dol_mktime(GETPOST('datecpricefournhour', 'int'), GETPOST('datecpricefournmin', 'int'), 0, GETPOST('datecpricefournmonth', 'int'), GETPOST('datecpricefournday', 'int'), GETPOST('datecpricefournyear', 'int'));

				$html = '<tr><td>'.$langs->trans('AppliedPricesFrom').'</td><td>'.$form->selectDate(($datecpricefourn ? $datecpricefourn : $object->date_creation), 'datecpricefourn', 1, 1, 0, '', 1, 1).'</td></tr>';

			}elseif ($action == 'add_price') {

				$newdatecpricefourn = dol_mktime(GETPOST('newdatecpricefournhour', 'int'), GETPOST('newdatecpricefournmin', 'int'), 0, GETPOST('newdatecpricefournmonth', 'int'), GETPOST('newdatecpricefournday', 'int'), GETPOST('newdatecpricefournyear', 'int'));

				$html = '<tr><td>'.$langs->trans('AppliedPricesFrom').'</td><td>'.$form->selectDate(($newdatecpricefourn ? $newdatecpricefourn : ''), 'newdatecpricefourn', 1, 1, 0, '', 1, 1).'</td></tr>';
			}
			$this->resprints = $html;
		}
			
	}

}
