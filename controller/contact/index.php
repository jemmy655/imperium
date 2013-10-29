<?php
/**
	List Contacts
	@todo Implement some sort of Reporting Feature Here?
*/


$char = $_GET['char'];
$this->sort = $_GET['sort'];
$page = intval($_GET['page']);

// Kind Filter
$title[] = 'Contacts';

// switch (strtolower($_GET['kind'])) {
// case 'companies':
//   $title[] = 'Companies';
//   $sql->where('kind = ?','Company');
//   break;
// case 'vendors':
//   $title[] = 'Vendors';
//   $sql->where('kind = ?','Vendor');
//   break;
// case 'contacts':
//   $title[] = 'Contacts';
//   $sql->where('kind = ?','Person');
//   break;
// }
// $sql->where('status != ?','Inactive');

$arg = array();
$sql = 'SELECT * FROM contact ';

// Where
if (strlen($this->char)) {
	$pat = null;
	if ($this->char == '#') {
		$pat = '^[0-9]';
	} elseif (preg_match('/^\w$/',$this->char)) {
		$pat = '^' . $this->char;
	}
	$arg[] = '^' . $pat;
	$arg[] = '^' . $pat;
	$arg[] = '^' . $pat;
	$sql.= 'WHERE contact ~* ? OR company ~* ? OR name ~* ?';
}

// Order
switch ($this->sort) {
case 'name':
	break;
default:
	$sort = $_ENV['contact']['sort'];
}
$sql.= ' ORDER BY ' . $sort;

// Limit
$sql.= ' LIMIT 250 ';

// $p = Zend_Paginator::factory($sql);
// if (count($p) == 0) {
// 	$this->view->title = 'No Contacts';
// 	return(0);
// }
// $p->setCurrentPageNumber($this->view->Page);
// $p->setItemCountPerPage(30);
// $p->setPageRange(10);
// 
// if ($p->count() == 0) {
//   $title[] = 'Contacts';
// } else {
//   $a_id = $p->getItem(1)->name;
//   $z_id = $p->getItem($p->getCurrentItemCount())->name;
// 
//   $title[] = sprintf('%s through %s',$a_id,$z_id);
// }
// $title[] = sprintf('Page %d of %d',$page->getCurrentPageNumber(),$page->count());

$_ENV['title'] = $title;

// $this->view->Page = $p;

/*
$rq = $this->getRequest();
// Automatic Query?
if ($a = $rq->getQuery('a')) {
}

	//$ss->where('kind_id in (100,300)');
	$sql->order(array('contact','company'));
$sql->limitPage($this->view->Paginator->page,$this->view->Paginator->limit);

// View!
	$this->view->ContactList = $db->fetchAll($sql);
	$this->view->title = array(
  'Contacts',
  'Page ' . $this->view->Paginator->page . ' of ' . $this->view->Paginator->pmax,
  );
*/

$this->list = radix_db_sql::fetch_all($sql);
