<?php
function serviceSourceCode($data,$dataTabDetail=null){
	 if(isset($dataTabDetail)) { 
		$tabCounter = count($dataTabDetail);
	}
	if (isset($data) && is_array($data)) {
		$total = count($data);
		for ($i = 0; $i < $total; $i++) {
			if ($data[$i]['Key'] == 'PRI') {
				$data[0]['tableName'] = str_replace('Id', '', $data[0]['columnName']);
			}
		}
		$str .= "<?php namespace Core\\" . ucwords($data[0]['package']) . "\\" . ucwords($data[0]['module']) . "\\" . ucwords($data[0]['tableName']) . "\\Service; \n";
		$str .= "	use Core\\ConfigClass;\n";
		$str .= "	\$x = addslashes(realpath(__FILE__));\n";
		$str .= "	// auto detect if \\ consider come from windows else / from linux\n";

		$str .= "	\$pos = strpos(\$x, \"\\\\\");\n";
		$str .= "	if (\$pos !== false) {\n";
		$str .= "		\$d = explode(\"\\\\\", \$x);\n";
		$str .= "	} else {  \n";
		$str .= "		\$d = explode(\"/\", \$x);\n";
		$str .= "	}\n";
		$str .= "	\$newPath = null;\n";
		$str .= "	for (\$i = 0; \$i < count(\$d); \$i ++) {\n";
		$str .= "		// if find the library or package then stop\n";
		$str .= "		if (\$d[\$i] == 'library' || \$d[\$i] == 'v3') {\n";
		$str .= "			break;\n";
		$str .= "		}\n";
		$str .= "		\$newPath[] .= \$d[\$i] . \"/\";\n";
		$str .= "	}\n";
		$str .= "	\$fakeDocumentRoot = null;\n";
		$str .= "	for (\$z = 0; \$z < count(\$newPath); \$z ++) {\n";
		$str .= "		\$fakeDocumentRoot .= \$newPath[\$z];\n";
		$str .= "	}\n";
		$str .= "	\$newFakeDocumentRoot = str_replace(\"//\", \"/\", \$fakeDocumentRoot); // start\n";


		$str .= "require_once (\$newFakeDocumentRoot.\"library/class/classAbstract.php\"); \n";
		$str .= "require_once (\$newFakeDocumentRoot.\"library/class/classShared.php\"); \n";


		$str .= "/** \n";
		$str .= " * Class " . ucfirst($data [0] ['tableName']) . "Service\n";
		$str .= " * Contain extra processing function / method.\n";
		$str .= " * @name IDCMS \n";
		$str .= " * @version 2 \n";
		$str .= " * @author hafizan \n";
		$str .= " * @package Core\\" . ucwords($data[0]['package']) . "\\" . ucwords($data[0]['module']) . "\\" . ucwords($data[0]['tableName']) . "\\Service\n";
		$str .= " * @subpackage " . ucwords($data[0]['module']) . " \n";
		$str .= " * @link http://www.hafizan.com \n";
		$str .= " * @license http://www.gnu.org/copyleft/lesser.html LGPL \n";
		$str .= " */ \n";
		$str .= "class " . ucfirst($data[0]['tableName']) . "Service extends ConfigClass { \n";

		$str .= "	/** \n";
		$str .= "	 * Connection to the database \n";
		$str .= "	 * @var \\Core\\Database\\Mysql\\Vendor \n";
		$str .= "	 */ \n";
		$str .= "	public \$q; \n";
		$str .= "	/** \n";
		$str .= "	 * Translate Label \n";
		$str .= "	 * @var string \n";
		$str .= "	 */ \n";
		$str .= "	public \$t; \n";
		$str .= "	/** \n";
		$str .= "	 * Constructor \n";
		$str .= "	 */ \n";
		$str .= "   function __construct() { \n";
		$str .= "       parent::__construct(); \n";
		$str .= "       if(\$_SESSION['companyId']){\n";
		$str .= "           \$this->setCompanyId(\$_SESSION['companyId']);\n";
		$str .= "       }else{\n";
		$str .= "           // fall back to default database if anything wrong\n";
		$str .= "           \$this->setCompanyId(1);\n";
		$str .= "       }\n";
		$str .= "   }\n";
		$str .= "	/** \n";
		$str .= "	 * Class Loader \n";
		$str .= "	 */ \n";
		$str .= "	function execute() { \n";
		$str .= "         parent::__construct(); \n";
		$str .= "	} \n";
		$str .= "  \n";
		for ($i = 0; $i < $total; $i++) {
			if ($data[0]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
				if ($data[$i]['columnName'] != 'companyId') {
					// we only can assumed it was the same package and module otherwise manual change
					$str .= "  /**\n";
					$str .= "   * Return " . checkString(str_replace($data[0]['tableName'], "", str_replace("Id", "", $data[$i]['columnName']))) . "\n";
					$str .= "   * @return array|string\n";
					$str .= "   * @throws \Exception\n";
					$str .= "	*/\n";
					$str .= "	public function get" . ucfirst(str_replace("Id", "", $data[$i]['columnName'])) . "() { \n";
					$str .= "     //initialize dummy value.. no content header.pure html  \n";
					$str .= "     \$sql=null; \n";
					$str .= "     \$str=null; \n";
					$str .= "     \$items=array(); \n";
					// for temporarily we only take information from identification and also desc only..
					if ($data[$i]['columnName'] == 'businessPartnerId') {
						$field = str_replace("Id", "", $data[$i]['columnName']) . "Company";
						$oracleField = strtoupper(str_replace("Id", "", $data[$i]['columnName']) . "Company");
					} else if ($data[$i]['columnName'] == 'employeeId') {
						$field = str_replace("Id", "", $data[$i]['columnName']) . "FirstName";
						$oracleField = strtoupper(str_replace("Id", "", $data[$i]['columnName']) . "FirstName");
					} else if ($data[$i]['columnName'] == 'staffId') {
						$field = str_replace("Id", "", $data[$i]['columnName']) . "Name";
						$oracleField = strtoupper(str_replace("Id", "", $data[$i]['columnName']) . "Name");
					} else if ($data[$i]['columnName'] == 'chartOfAccountId') {
						$field = str_replace("Id", "", $data[$i]['columnName']) . "Title";
						$oracleField = strtoupper(str_replace("Id", "", $data[$i]['columnName']) . "Title");
					} else if ($data[$i]['columnName'] == 'assetId') {
						$field = str_replace("Id", "", $data[$i]['columnName']) . "Name";
						$oracleField = strtoupper(str_replace("Id", "", $data[$i]['columnName']) . "Name");
					} else {
						$field = str_replace("Id", "", $data[$i]['columnName']) . "Description";
						$oracleField = strtoupper(str_replace("Id", "", $data[$i]['columnName']) . "Description");
					}
					$str .= "     if(\$this->getVendor()==self::MYSQL) { \n";
					$str .= "         \$sql =\"  \n";
					$str .= "         SELECT      `" . $data[$i]['columnName'] . "`,\n";
					$str .= "                     `" . $field . "`\n";

					$str .= "         FROM        `" . strtolower(str_replace("Id", "", $data[$i]['columnName'])) . "`\n";
					$str .= "         WHERE       `isActive`  =   1\n";
					$str .= "         AND         `companyId` =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         ORDER BY    `isDefault`;\"; \n";

					$str .= "     } else if (\$this->getVendor()==self::MSSQL) { \n";
					$str .= "         \$sql =\" \n";
					$str .= "         SELECT      [" . $data[$i]['columnName'] . "],\n";
					$str .= "                     [" . $field . "]\n";
					$str .= "         FROM        [" . str_replace("Id", "", $data[$i]['columnName']) . "]\n";
					$str .= "         WHERE       [isActive]  =   1\n";
					$str .= "         AND         [companyId] =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         ORDER BY    [isDefault]\"; \n";
					$str .= "     } else if (\$this->getVendor()==self::ORACLE) { \n";
					$str .= "         \$sql =\" \n";
					$str .= "         SELECT      " . strtoupper($data[$i]['columnName']) . " AS \\\"" . $data[$i]['columnName'] . "\\\",\n";
					$str .= "                     " . $oracleField . " AS \\\"" . $field . "\\\"\n";
					$str .= "         FROM        " . strtoupper(str_replace("Id", "", $data[$i]['columnName'])) . "  \n";
					$str .= "         WHERE       ISACTIVE    =   1\n";
					$str .= "         AND         COMPANYID   =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         ORDER BY    ISDEFAULT\"; \n";
					$str .= "     }  else {\n";
					$str .= "         header('Content-Type:application/json; charset=utf-8');\n";
					$str .= "         echo json_encode(array(\"success\" => false, \"message\" => \$this->t['databaseNotFoundMessageLabel']));\n";
					$str .= "         exit();\n";
					$str .= "     }\n";
					$str .= "     try {\n";
					$str .= "       \$result =\$this->q->fast(\$sql);\n";
					$str .= "     } catch (\\Exception \$e) {\n";
					$str .= "       echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
					$str .= "       exit();\n";
					$str .= "    }\n";
					$str .= "     if(\$result) { \n";
					$str .= "		  \$d=1;\n";
					$str .= "         while((\$row = \$this->q->fetchArray(\$result))==TRUE) { \n";
					$str .= "             if(\$this->getServiceOutput()=='option'){\n ";
					$str .= "                 \$str.=\"<option value='\".\$row['" . $data[$i]['columnName'] . "'].\"'>\".\$d.\". \".\$row['" . $field . "'].\"</option>\";\n";
					$str .= "             } else if (\$this->getServiceOutput()=='html')  { \n";
					$str .= "                 \$items[] = \$row; \n";
					$str .= "             }\n";
					$str .= "			  \$d++;\n";
					$str .= "         }\n";
					$str .= "         unset(\$d);\n";
					$str .= "     }\n";
					$str .= "     if(\$this->getServiceOutput()=='option'){\n ";
					$str .= "         if (strlen(\$str) > 0) {\n";
					$str .= "            \$str = \"<option value=''>\".\$this->t['pleaseSelectTextLabel'].\"</option>\" . \$str; \n";
					$str .= "         } else {\n";
					$str .= "             \$str= \"<option value=''>\".\$this->t['notAvailableTextLabel'].\"</option>\";\n";
					$str .= "         }\n";
					$str .= "         header('Content-Type:application/json; charset=utf-8');\n";
					$str .= "         echo json_encode(array(\"success\"=>true,\"message\"=>\"complete\",\"data\"=>\$str));\n";
					$str .= "         exit();\n";
					$str .= "     } else if (\$this->getServiceOutput()=='html')  { \n";
					$str .= "         return \$items; \n ";
					$str .= "     }\n";
					$str .= "         return false; \n ";
					$str .= " }\n";

					$str .= "  /**\n";
					$str .= "   * Return " .  checkString(str_replace($data[0]['tableName'], "", str_replace("Id", "", $data[$i]['columnName']))) ." Default Value\n";
					$str .= "   * @return int\n";
					$str .= "   * @throws \Exception\n";
					$str .= "	*/\n";
					$str .= "	public function get" . ucfirst(str_replace("Id", "", $data[$i]['columnName'])) . "DefaultValue() { \n";
					$str .= "     //initialize dummy value.. no content header.pure html  \n";
					$str .= "     \$sql=null; \n";
					$str .= "	  \$" . $data[$i]['columnName'] . "=null;\n";
					// for temporarily we only take information from identification and also desc only..
					$str .= "     if(\$this->getVendor()==self::MYSQL) { \n";
					$str .= "         \$sql =\"  \n";
					$str .= "         SELECT      `" . $data[$i]['columnName'] . "`\n";
					$str .= "         FROM        	`" . strtolower(str_replace("Id", "", $data[$i]['columnName'])) . "`\n";
					$str .= "         WHERE       `isActive`  =   1\n";
					$str .= "         AND         `companyId` =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         AND    	  `isDefault` =	  1\n";
					$str .= "         LIMIT 1\"; \n";

					$str .= "     } else if (\$this->getVendor()==self::MSSQL) { \n";
					$str .= "         \$sql =\" \n";
					$str .= "         SELECT      TOP 1 [" . $data[$i]['columnName'] . "],\n";
					$str .= "         FROM        [" . str_replace("Id", "", $data[$i]['columnName']) . "]\n";
					$str .= "         WHERE       [isActive]  =   1\n";
					$str .= "         AND         [companyId] =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         AND    	  [isDefault] =   1\"; \n";
					$str .= "     } else if (\$this->getVendor()==self::ORACLE) { \n";
					$str .= "         \$sql =\" \n";
					$str .= "         SELECT      " . strtoupper($data[$i]['columnName']) . " AS \\\"" . $data[$i]['columnName'] . "\\\",\n";
					$str .= "         FROM        " . strtoupper(str_replace("Id", "", $data[$i]['columnName'])) . "  \n";
					$str .= "         WHERE       ISACTIVE    =   1\n";
					$str .= "         AND         COMPANYID   =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         AND    	  ISDEFAULT	  =	   1\n";
					$str .= "         AND 		  ROWNUM	  =	   1\";\n";
					$str .= "     }  else {\n";
					$str .= "         header('Content-Type:application/json; charset=utf-8');\n";
					$str .= "         echo json_encode(array(\"success\" => false, \"message\" => \$this->t['databaseNotFoundMessageLabel']));\n";
					$str .= "         exit();\n";
					$str .= "     }\n";
					$str .= "     try {\n";
					$str .= "       \$result =\$this->q->fast(\$sql);\n";
					$str .= "     } catch (\\Exception \$e) {\n";
					$str .= "       echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
					$str .= "       exit();\n";
					$str .= "    }\n";
					$str .= "     if(\$result) { \n";
					$str .= "         \$row = \$this->q->fetchArray(\$result); \n";
					$str .= "		  \$" . $data[$i]['columnName'] . " = \$row['" . $data[$i]['columnName'] . "'];\n";
					$str .= "	 }\n";
					$str .= "	 return \$" . $data[$i]['columnName'] . ";\n";
					$str .= " }\n";
				}
			}
		}
	if (isset($dataTabDetail) && count($dataTabDetail) > 0) {
		for ($j = 0; $j < $tabCounter; $j++) {
			if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
				$total =  count($dataTabDetail[$j]);


				$str .= "class " . ucfirst($dataTabDetail[$j][0]['tableName']) . "Service extends ConfigClass { \n";

				$str .= "	/** \n";
				$str .= "	 * Connection to the database \n";
				$str .= "	 * @var \\Core\\Database\\Mysql\\Vendor \n";
				$str .= "	 */ \n";
				$str .= "	public \$q; \n";
				$str .= "	/** \n";
				$str .= "	 * Translate Label \n";
				$str .= "	 * @var string \n";
				$str .= "	 */ \n";
				$str .= "	public \$t; \n";
				$str .= "	/** \n";
				$str .= "	 * Model \n";
				$str .= "	 * @var \\Core\\" . ucwords($data [0] ['package']) . "\\" . ucwords($data [0] ['module']) . "\\" . ucwords($data [0] ['tableName']) . "\Model\\" . ucwords($dataTabDetail[$j][0] ['tableName']) . "MultiModel \n";
				$str .= "	 */ \n";
				$str .= "	public \$model; \n";
				$str .= "	/** \n";
				$str .= "	 * Constructor \n";
				$str .= "	 */ \n";
				$str .= "   function __construct() { \n";
				$str .= "       parent::__construct(); \n";
				$str .= "       if(\$_SESSION['companyId']){\n";
				$str .= "           \$this->setCompanyId(\$_SESSION['companyId']);\n";
				$str .= "       }else{\n";
				$str .= "           // fall back to default database if anything wrong\n";
				$str .= "           \$this->setCompanyId(1);\n";
				$str .= "       }\n";
				$str .= "   }\n";
				$str .= "	/** \n";
				$str .= "	 * Class Loader \n";
				$str .= "	 */ \n";
				$str .= "	function execute() { \n";
				$str .= "         parent::__construct(); \n";
				$str .= "	} \n";
				for ($i = 0; $i < $total; $i++) {
			if ($dataTabDetail[$j][$i]['foreignKey'] == 1) {
				if ($dataTabDetail[$j][$i]['columnName'] != 'companyId') {
					// we only can assumed it was the same package and module otherwise manual change
					$str .= "  /**\n";
					$str .= "   * Return " . ucfirst(checkString(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName'])) ). "\n";
					$str .= "   * @return array|string\n";
					$str .= "   * @throws \Exception\n";
					$str .= "	*/\n";
					$str .= "	public function get" . (str_replace($dataTabDetail[$j][0]['tableName'], "", str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']))) . "() { \n";
					$str .= "     \$sql=null; \n";
					$str .= "     \$str=null; \n";
					$str .= "     \$items=array(); \n";
					// for temporarily we only take information from identification and also desc only..
					if ($dataTabDetail[$j][$i]['columnName'] == 'businessPartnerId') {
						$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Company";
						$oracleField = strtoupper(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Company");
					} else if ($dataTabDetail[$j][$i]['columnName'] == 'employeeId') {
						$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "FirstName";
						$oracleField = strtoupper(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "FirstName");
					} else if ($dataTabDetail[$j][$i]['columnName'] == 'staffId') {
						$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name";
						$oracleField = strtoupper(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name");
					} else if ($dataTabDetail[$j][$i]['columnName'] == 'chartOfAccountId') {
						$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Title";
						$oracleField = strtoupper(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Title");
					} else if ($dataTabDetail[$j][$i]['columnName'] == 'assetId') {
						$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name";
						$oracleField = strtoupper(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name");
					} else {
						$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Description";
						$oracleField = strtoupper(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Description");
					}
					$str .= "     if(\$this->getVendor()==self::MYSQL) { \n";
					$str .= "         \$sql =\"  \n";
					$str .= "         SELECT      `" . $dataTabDetail[$j][$i]['columnName'] . "`,\n";
					$str .= "                     `" . $field . "`\n";

					$str .= "         FROM        `" . strtolower(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName'])) . "`\n";
					$str .= "         WHERE       `isActive`  =   1\n";
					$str .= "         AND         `companyId` =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         ORDER BY    `isDefault`;\"; \n";

					$str .= "     } else if (\$this->getVendor()==self::MSSQL) { \n";
					$str .= "         \$sql =\" \n";
					$str .= "         SELECT      [" . $dataTabDetail[$j][$i]['columnName'] . "],\n";
					$str .= "                     [" . $field . "]\n";
					$str .= "         FROM        [" . str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "]\n";
					$str .= "         WHERE       [isActive]  =   1\n";
					$str .= "         AND         [companyId] =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         ORDER BY    [isDefault]\"; \n";
					$str .= "     } else if (\$this->getVendor()==self::ORACLE) { \n";
					$str .= "         \$sql =\" \n";
					$str .= "         SELECT      " . strtoupper($dataTabDetail[$j][$i]['columnName']) . " AS \\\"" . $dataTabDetail[$j][$i]['columnName'] . "\\\",\n";
					$str .= "                     " . $oracleField . " AS \\\"" . $field . "\\\"\n";
					$str .= "         FROM        " . strtoupper(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName'])) . "  \n";
					$str .= "         WHERE       ISACTIVE    =   1\n";
					$str .= "         AND         COMPANYID   =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         ORDER BY    ISDEFAULT\"; \n";
					$str .= "     }  else {\n";
					$str .= "         header('Content-Type:application/json; charset=utf-8');\n";
					$str .= "         echo json_encode(array(\"success\" => false, \"message\" => \$this->t['databaseNotFoundMessageLabel']));\n";
					$str .= "         exit();\n";
					$str .= "     }\n";
					$str .= "     try {\n";
					$str .= "       \$result =\$this->q->fast(\$sql);\n";
					$str .= "     } catch (\\Exception \$e) {\n";
					$str .= "       echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
					$str .= "       exit();\n";
					$str .= "    }\n";
					$str .= "     if(\$result) { \n";
					$str .= "		  \$d=1;\n";
					$str .= "         while((\$row = \$this->q->fetchArray(\$result))==TRUE) { \n";
					$str .= "             if(\$this->getServiceOutput()=='option'){\n ";
					$str .= "                 \$str.=\"<option value='\".\$row['" . $dataTabDetail[$j][$i]['columnName'] . "'].\"'>\".\$d.\". \".\$row['" . $field . "'].\"</option>\";\n";
					$str .= "             } else if (\$this->getServiceOutput()=='html')  { \n";
					$str .= "                 \$items[] = \$row; \n";
					$str .= "             }\n";
					$str .= "			  \$d++;\n";
					$str .= "         }\n";
					$str .= "         unset(\$d);\n";
					$str .= "     }\n";
					$str .= "     if(\$this->getServiceOutput()=='option'){\n ";
					$str .= "         if (strlen(\$str) > 0) {\n";
					$str .= "            \$str = \"<option value=''>\".\$this->t['pleaseSelectTextLabel'].\"</option>\" . \$str; \n";
					$str .= "         } else {\n";
					$str .= "             \$str= \"<option value=''>\".\$this->t['notAvailableTextLabel'].\"</option>\";\n";
					$str .= "         }\n";
					$str .= "         header('Content-Type:application/json; charset=utf-8');\n";
					$str .= "         echo json_encode(array(\"success\"=>true,\"message\"=>\"complete\",\"data\"=>\$str));\n";
					$str .= "         exit();\n";
					$str .= "     } else if (\$this->getServiceOutput()=='html')  { \n";
					$str .= "         return \$items; \n ";
					$str .= "     }\n";
					$str .= "         return false; \n ";
					$str .= " }\n";

					$str .= "  /**\n";
					$str .= "   * Return " . checkString(str_replace($dataTabDetail[$j][0]['tableName'], "", str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']))) . " Default Value\n";
					$str .= "   * @return int\n";
					$str .= "   * @throws \Exception\n";
					$str .= "	*/\n";
					$str .= "	public function get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName'])) . "DefaultValue() { \n";
					$str .= "     //initialize dummy value.. no content header.pure html  \n";
					$str .= "     \$sql=null; \n";
					$str .= "	  \$" . $dataTabDetail[$j][$i]['columnName'] . "=null;\n";
					// for temporarily we only take information from identification and also desc only..
					$str .= "     if(\$this->getVendor()==self::MYSQL) { \n";
					$str .= "         \$sql =\"  \n";
					$str .= "         SELECT      `" . $dataTabDetail[$j][$i]['columnName'] . "`\n";
					$str .= "         FROM        	`" . strtolower(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName'])) . "`\n";
					$str .= "         WHERE       `isActive`  =   1\n";
					$str .= "         AND         `companyId` =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         AND    	  `isDefault` =	  1\n";
					$str .= "         LIMIT 1\"; \n";

					$str .= "     } else if (\$this->getVendor()==self::MSSQL) { \n";
					$str .= "         \$sql =\" \n";
					$str .= "         SELECT      TOP 1 [" . $dataTabDetail[$j][$i]['columnName'] . "],\n";
					$str .= "         FROM        [" . str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "]\n";
					$str .= "         WHERE       [isActive]  =   1\n";
					$str .= "         AND         [companyId] =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         AND    	  [isDefault] =   1\"; \n";
					$str .= "     } else if (\$this->getVendor()==self::ORACLE) { \n";
					$str .= "         \$sql =\" \n";
					$str .= "         SELECT      " . strtoupper($dataTabDetail[$j][$i]['columnName']) . " AS \\\"" . $dataTabDetail[$j][$i]['columnName'] . "\\\",\n";
					$str .= "         FROM        " . strtoupper(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName'])) . "  \n";
					$str .= "         WHERE       ISACTIVE    =   1\n";
					$str .= "         AND         COMPANYID   =   '\".\$this->getCompanyId().\"'\n";
					$str .= "         AND    	  ISDEFAULT	  =	   1\n";
					$str .= "         AND 		  ROWNUM	  =	   1\";\n";
					$str .= "     }  else {\n";
					$str .= "         header('Content-Type:application/json; charset=utf-8');\n";
					$str .= "         echo json_encode(array(\"success\" => false, \"message\" => \$this->t['databaseNotFoundMessageLabel']));\n";
					$str .= "         exit();\n";
					$str .= "     }\n";
					$str .= "     try {\n";
					$str .= "       \$result =\$this->q->fast(\$sql);\n";
					$str .= "     } catch (\\Exception \$e) {\n";
					$str .= "       echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
					$str .= "       exit();\n";
					$str .= "    }\n";
					$str .= "     if(\$result) { \n";
					$str .= "         \$row = \$this->q->fetchArray(\$result); \n";
					$str .= "		  \$" . $dataTabDetail[$j][$i]['columnName'] . " = \$row['" . $dataTabDetail[$j][$i]['columnName'] . "'];\n";
					$str .= "	 }\n";
					$str .= "	 return \$" . $dataTabDetail[$j][$i]['columnName'] . ";\n";
					$str .= " }\n";
				}
			}
		}
				$str .= "  \n";
				$str .= "    /** Create\n";
				$str .= "  * @see config::create()\n";
				$str .= "  *  @return void\n";
				$str .= "  **/\n";
				// sort of depency injection 
				$str .= " public function create() {\n";
				// start
				$str .= " if (\$this->getVendor() == self::MYSQL) {  \n";
				$str .= "  \$sql = \"SET NAMES utf8\";  \n";
				$str .= "  try {\n";
				$str .= "   \$this->q->fast(\$sql);\n";
				$str .= "  } catch (\\Exception \$e) {\n";
				$str .= "   echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
				$str .= "   exit();\n";
				$str .= "  }\n";
				$str .= " } \n";
				$str .= "       \$this->model->create();  \n";
				$str .= "       \$sql=null;\n";
		
				if ($foreignKeyYes == 1) {
					for ($i = 0; $i < $total; $i++) {
						if ($dataTabDetail [$j][$i] ['Key'] == 'MUL' && $dataTabDetail[$j][$i]['columnName'] != 'companyId') {
							$str.="       if(!\$this->model->get" . ucfirst($dataTabDetail [$j][$i]['columnName']) . "()){\n";
							$str.="           \$this->model->set" . ucfirst($dataTabDetail [$j][$i]['columnName']) . "(\$this->get" . ucfirst(str_replace("Id", "", ($dataTabDetail [$j][$i]['columnName']))) . "DefaultValue());\n";
							$str.="       }\n";
						}
					}
				}
						$str .= "       if (\$this->getVendor() == self::MYSQL) {  \n";
							$mysqlInsertStatementAField = null;

							$mysqlInsertStatementInsideValue = null;

							$mysqlInsertStatement = "       \$sql=\"\n            INSERT INTO `" . strtolower($dataTabDetail [$j][0] ['tableName']) . "` \n            (\n";
							for ($i = 0; $i < $total; $i++) {
								if ($i >= 1) {
									$mysqlInsertStatementAField .= "                 `" . $dataTabDetail [$j][$i] ['columnName'] . "`,\n";
								}
							}

							$mysqlInsertStatement .= (substr($mysqlInsertStatementAField, 0, -2));
							$mysqlInsertStatement .= "\n       ) VALUES\n"; 
							for($t=1;$t<=$dataTabDetail[$j][0]['targetMaximumTabRecord'];$t++) { 
								$mysqlInsertStatementInsideValue .= "( \n";								
								for ($i = 0; $i < $total; $i++) {
									if ($i >= 1) {
										if ($dataTabDetail [$j][$i] ['columnName'] == 'executeTime') {
											$mysqlInsertStatementInsideValue .= "                 \".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\",\n";
										} else if ($dataTabDetail[$j][$i]['columnName'] == 'companyId' || $dataTabDetail[$j][$i]['columnName']=='executeBy') {
											$mysqlInsertStatementInsideValue .= "                 '\".\$this->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\"',\n";
										} else if ($dataTabDetail [$j][$i] ['columnName'] != 'isDefault' && $dataTabDetail [$j][$i] ['columnName'] != 'isNew' && $dataTabDetail [$j][$i] ['columnName'] != 'isDraft' && $dataTabDetail [$j][$i] ['columnName'] != 'isUpdate' && $dataTabDetail [$j][$i] ['columnName'] != 'isDelete' && $dataTabDetail [$j][$i] ['columnName'] != 'isActive' && $dataTabDetail [$j][$i] ['columnName'] != 'isApproved' && $dataTabDetail [$j][$i] ['columnName'] != 'isReview' && $dataTabDetail [$j][$i] ['columnName'] != 'isPost' && $dataTabDetail [$j][$i] ['columnName'] != 'isSlice' && $dataTabDetail [$j][$i] ['columnName'] != 'isConsolidation') {
											$mysqlInsertStatementInsideValue .= "                 '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\"',\n";
										} else {
											$mysqlInsertStatementInsideValue .= "                 '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(0, 'single').\"',\n";
										}
									}
								}
								$mysqlInsertStatementInsideValue .="),\n\n";
							}
							
							$mysqlInsertStatement .= (substr($mysqlInsertStatementInsideValue, 0, -2));
							$mysqlInsertStatement .= "\";\n";
						
						$str .= $mysqlInsertStatement;
						$str .= "		 } else if (\$this->getVendor() == self::MSSQL) {  \n";
							$mssqlInsertStatement = null;
							$mssqlInsertStatementAField = null;
							$mssqlInsertStatementField = null;
							$mssqlInsertStatementInsideValue = null;
							$mssqlInsertStatementValue = null;
							$mssqlInsertStatement .= "       \$sql=\"\n            INSERT INTO [" . $dataTabDetail [$j][0] ['tableName'] . "] \n            (\n";
							for ($i = 0; $i < $total; $i++) {
							if ($i >= 0) {
								$mssqlInsertStatementAField .= "                 [" . $dataTabDetail [$j][$i] ['columnName'] . "],\n";
							}
							}
							$mssqlInsertStatementField .= (substr($mssqlInsertStatementAField, 0, -2));
							$mssqlInsertStatement .= $mssqlInsertStatementField;
							$mssqlInsertStatement .= "\n) VALUES\n";
							for($t=1;$t<=$dataTabDetail[$j][0]['targetMaximumTabRecord'];$t++) { 
							
								$mssqlInsertStatementInsideValue .= "(\n";
								
								for ($i = 0; $i < $total; $i++) {
									if ($i >= 1) {
										if ($dataTabDetail [$j][$i] ['columnName'] == 'executeTime') {
											$mssqlInsertStatementInsideValue .= "                 \".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\",\n";
										} elseif ($dataTabDetail[$j][$i]['columnName'] == 'companyId' || $dataTabDetail[$j][$i]['columnName']=='executeBy') {
											$mssqlInsertStatementInsideValue .= "                 '\".\$this->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\"',\n";
										} elseif ($dataTabDetail [$j][$i] ['columnName'] != 'isDefault' && $dataTabDetail [$j][$i] ['columnName'] != 'isNew' && $dataTabDetail [$j][$i] ['columnName'] != 'isDraft' && $dataTabDetail [$j][$i] ['columnName'] != 'isUpdate' && $dataTabDetail [$j][$i] ['columnName'] != 'isDelete' && $dataTabDetail [$j][$i] ['columnName'] != 'isActive' && $dataTabDetail [$j][$i] ['columnName'] != 'isApproved' && $dataTabDetail [$j][$i] ['columnName'] != 'isReview' && $dataTabDetail [$j][$i] ['columnName'] != 'isPost' && $dataTabDetail [$j][$i] ['columnName'] != 'isSlice' && $dataTabDetail [$j][$i] ['columnName'] != 'isConsolidation') {
											$mssqlInsertStatementInsideValue .= "                 '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(".$t.").\"',\n";
										} else {
											$mssqlInsertStatementInsideValue .= "                 '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(0, 'single').\"',\n";
										}
									}
								}
								
								$mssqlInsertStatementInsideValue.= "),\n";
								
							}
							$mssqlInsertStatementValue .= (substr($mssqlInsertStatementInsideValue, 0, -2));
							$mssqlInsertStatement .= $mssqlInsertStatementValue;
							$mssqlInsertStatement .= "\";\n";
							$str .= $mssqlInsertStatement;
						
						$str .= "       } else if (\$this->getVendor() == self::ORACLE) {  \n";
							$oracleInsertStatement = null;
							$oracleInsertStatementAField = null;
							$oracleInsertStatementField = null;
							$oracleInsertStatementInsideValue = null;
							$oracleInsertStatementValue = null;
							$oracleInsertStatement .= "            \$sql=\"\n            INSERT INTO " . strtoupper($dataTabDetail [$j][0] ['tableName']) . " \n            (\n";
							for ($i = 0; $i < $total; $i++) {
							if ($i >= 1) {
								$oracleInsertStatementAField .= "                 " . strtoupper($dataTabDetail [$j][$i] ['columnName']) . ",\n";
							}
							}
							$oracleInsertStatementField .= (substr($oracleInsertStatementAField, 0, -2));
							$oracleInsertStatement .= $oracleInsertStatementField;
							$oracleInsertStatement .= "\n            ) VALUES \n";
							for($t=1;$t<=$dataTabDetail[$j][0]['targetMaximumTabRecord'];$t++) { 
							
								$oracleInsertStatementInsideValue .= "(\n";
								
								for ($i = 0; $i < $total; $i++) {
									if ($i >= 1) {
										if ($dataTabDetail [$j][$i] ['columnName'] == 'executeTime') {
											$oracleInsertStatementInsideValue .= "                 \".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\",\n";
										}else  if ($dataTabDetail[$j][$i]['columnName'] == 'companyId' || $dataTabDetail[$j][$i]['columnName']=='executeBy') {
											$oracleInsertStatementInsideValue .= "                 '\".\$this->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\"',\n";
										} else if ($dataTabDetail [$j][$i] ['columnName'] != 'isDefault' && $dataTabDetail [$j][$i] ['columnName'] != 'isNew' && $dataTabDetail [$j][$i] ['columnName'] != 'isDraft' && $dataTabDetail [$j][$i] ['columnName'] != 'isUpdate' && $dataTabDetail [$j][$i] ['columnName'] != 'isDelete' && $dataTabDetail [$j][$i] ['columnName'] != 'isActive' && $dataTabDetail [$j][$i] ['columnName'] != 'isApproved' && $dataTabDetail [$j][$i] ['columnName'] != 'isReview' && $dataTabDetail [$j][$i] ['columnName'] != 'isPost' && $dataTabDetail [$j][$i] ['columnName'] != 'isSlice' && $dataTabDetail [$j][$i] ['columnName'] != 'isConsolidation') {
											$oracleInsertStatementInsideValue .= "                 '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(".$t.").\"',\n";
										} else {
											$oracleInsertStatementInsideValue .= "                 '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(0, 'single').\"',\n";
										}
									}
								}
								
								$oracleInsertStatementInsideValue .="),";
							}
							
							$oracleInsertStatementValue .= (substr($oracleInsertStatementInsideValue, 0, -2));
							$oracleInsertStatement .= $oracleInsertStatementValue;
							$oracleInsertStatement .= "\";\n";
							$str .= $oracleInsertStatement;
						$str .= "       }  \n";

					$str .= "       try {\n";
					$str .= "           \$this->q->create(\$sql);\n";
					$str .= "       } catch (\\Exception \$e) {\n";
					$str .= "           \$this->q->rollback();\n";
					$str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
					$str .= "           exit();\n";
					$str .= "       }\n";
					// end 
					$str .= " }\n";

				$str .= "    /**\n";
				$str .= "     * Read\n";
				$str .= "     * @see config::read()\n";
				$str .= "     * @return void\n";
				$str .= "     */\n";
				$str .= "     public function read() {\n";
				$str .= "       if (\$this->getVendor() == self::MYSQL) { \n";
				$mysqlReadStatement = null;
				$mysqlReadInsideStatement = null;

				$mysqlReadStatement .= "\n      \$sql = \"\n       SELECT";
				for ($i = 0; $i < $total; $i++) {
				if ($dataTabDetail [$j][$i] ['foreignKey'] == 1 && $dataTabDetail [$j][$i] ['Key'] == 'MUL') {
				//exception for some cases
				if ($dataTabDetail[$j][$i]['columnName'] == 'businessPartnerId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Company";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'employeeId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "FirstName";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'staffId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'chartOfAccountId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Title";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'assetId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name";
				} else {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Description";
				}
				$mysqlReadInsideStatement .= "                    `" . strtolower(str_replace("Id", "", $dataTabDetail [$j][$i] ['columnName'])) . "`.`" . $field . "`,\n";
				$mysqlReadInsideStatement .= "                    `" . strtolower($dataTabDetail [$j][0] ['tableName']) . "`.`" . $dataTabDetail [$j][$i] ['columnName'] . "`,\n";
				} else {
				$mysqlReadInsideStatement .= "                    `" . strtolower($dataTabDetail [$j][0] ['tableName']) . "`.`" . $dataTabDetail [$j][$i] ['columnName'] . "`,\n";
				}
				}
				$mysqlReadStatement .= $mysqlReadInsideStatement;

				$mysqlReadStatement .= "                    `staff`.`staffName`\n";
				$mysqlReadStatement .= "		  FROM      `" . strtolower($dataTabDetail [$j][0] ['tableName']) . "`\n";
				$mysqlReadStatement .= "		  JOIN      `staff`\n";
				$mysqlReadStatement .= "		  ON        `" . strtolower($dataTabDetail [$j][0] ['tableName']) . "`.`executeBy` = `staff`.`staffId`\n";
				$mysqlReadStatement .= "		  WHERE    `companyId`= \" . \$this->companyId().\"' \n";
				$mysqlReadStatement .= "		  AND    `" . str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName']) . "LineNumber` = '\" . \$this->model->get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName'])) . "LineNumber(".$i.") . \"'\"; \n";
				
				$str .= $mysqlReadStatement;


				$str .= " } else if (\$this->getVendor() == self::MSSQL) {  \n";
				$mssqlReadStatement = null;
				$mssqlReadInsideStatement = null;
				$mssqlReadStatement .= "\n		  \$sql = \"\n		  SELECT";

				for ($i = 0; $i < $total; $i++) {
				if ($dataTabDetail [$j][$i] ['foreignKey'] == 1 && $dataTabDetail [$j][$i] ['Key'] == 'MUL') {
				//exception for some cases
				if ($dataTabDetail[$j][$i]['columnName'] == 'businessPartnerId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Company";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'employeeId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "FirstName";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'staffId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'chartOfAccountId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Title";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'assetId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name";
				} else {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Description";
				}
				$mssqlReadInsideStatement .= "                    [" . str_replace("Id", "", $dataTabDetail [$j][$i] ['columnName']) . "].[" . $field . "],\n";
				$mssqlReadInsideStatement .= "                    [" . $dataTabDetail [$j][0] ['tableName'] . "].[" . $dataTabDetail [$j][$i] ['columnName'] . "],\n";
				} else {
				$mssqlReadInsideStatement .= "                    [" . $dataTabDetail [$j][0] ['tableName'] . "].[" . $dataTabDetail [$j][$i] ['columnName'] . "],\n";
				}
				}
				$mssqlReadStatement .= $mssqlReadInsideStatement;
				$mssqlReadStatement .= "                    [staff].[staffName] \n";
				$mssqlReadStatement .= "		  FROM 	[" . $dataTabDetail [$j][0] ['tableName'] . "]\n";
				$mssqlReadStatement .= "		  JOIN	[staff]\n";
				$mssqlReadStatement .= "		  ON	[" . $dataTabDetail [$j][0] ['tableName'] . "].[executeBy] = [staff].[staffId]\n";
				if ($foreignKeyYes == 1) {
				for ($i = 0; $i < $total; $i++) {
				if ($dataTabDetail [$j][$i] ['foreignKey'] == 1 && $dataTabDetail [$j][$i] ['Key'] == 'MUL') {
				// assume in the same package also
				$mssqlReadStatement .= "	JOIN	[" . str_replace("Id", "", $dataTabDetail [$j][$i] ['columnName']) . "]\n";
				$mssqlReadStatement .= "	ON		[" . str_replace("Id", "", $dataTabDetail [$j][$i] ['columnName']) . "].[" . $dataTabDetail [$j][$i] ['columnName'] . "] = [" . $dataTabDetail [$j][0] ['tableName'] . "].[" . $dataTabDetail [$j][$i] ['columnName'] . "]\n";
				}
				}
				}
				$mssqlReadStatement .= "		  WHERE    [companyId]='\".\$this->getCompanyId().\"'  AND [" . str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName']) . "LineNumber] = '\" . \$this->model->get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName'])) . "LineNumber(0, 'single') . \"' \";  \n";
				$str .= $mssqlReadStatement;
				$str .= "       if (\$this->model->get" . ucfirst($dataTabDetail [$j][0] ['primaryKeyName']) . "(0, 'single')) { \n";
				$str .= "           \$sql .= \" AND [" . $dataTabDetail [$j][0] ['tableName'] . "].[\" . \$this->model->getPrimaryKeyName() . \"]		=	'\" . \$this->model->get" . ucfirst($dataTabDetail [$j][0] ['primaryKeyName']) . "(0, 'single') . \"'\"; \n";
				$str .= "       } \n";

				$str .= "		} else if (\$this->getVendor() == self::ORACLE) {  \n";
				$oracleReadStatement = null;
				$oracleReadInsideStatement = null;
				$oracleReadStatement .= "\n		  \$sql = \"\n		  SELECT";

				for ($i = 0; $i < $total; $i++) {
				if ($dataTabDetail [$j][$i] ['foreignKey'] == 1 && $dataTabDetail [$j][$i] ['Key'] == 'MUL') {
				//exception for some cases
				if ($dataTabDetail[$j][$i]['columnName'] == 'businessPartnerId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Company";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'employeeId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "FirstName";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'staffId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'chartOfAccountId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Title";
				} else if ($dataTabDetail[$j][$i]['columnName'] == 'assetId') {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Name";
				} else {
				$field = str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Description";
				}
				$oracleReadInsideStatement .= "                    " . strtoupper(str_replace("Id", "", $dataTabDetail [$j][$i] ['columnName'])) . "." . strtoupper($field) . " AS  \\\"" . $field . "\\\",\n";
				$oracleReadInsideStatement .= "                    " . strtoupper($dataTabDetail [$j][0] ['tableName']) . "." . strtoupper($dataTabDetail [$j][$i] ['columnName']) . " AS \\\"" . ($dataTabDetail [$j][$i] ['columnName']) . "\\\",\n";
				} else {
				$oracleReadInsideStatement .= "                    " . strtoupper($dataTabDetail [$j][0] ['tableName']) . "." . strtoupper($dataTabDetail [$j][$i] ['columnName']) . " AS \\\"" . ($dataTabDetail [$j][$i] ['columnName']) . "\\\",\n";
				}
				}
				$oracleReadStatement .= $oracleReadInsideStatement;

				$oracleReadStatement .= "                    STAFF.STAFFNAME AS \\\"staffName\\\" \n";
				$oracleReadStatement .= "		  FROM 	" . strtoupper($dataTabDetail [$j][0] ['tableName']) . " \n";
				$oracleReadStatement .= "		  JOIN	STAFF \n";
				$oracleReadStatement .= "		  ON	" . strtoupper($dataTabDetail [$j][0] ['tableName']) . ".EXECUTEBY = STAFF.STAFFID \n ";

				$oracleReadStatement .= "         WHERE     COMPANYID='\".\$this->getCompanyId().\"'  AND " . strtoupper(str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName'])) . "LINENUMBER = '\" . \$this->model->get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName'])) . "LineNumber(".$i.") . \"' \";\n";

				$str .= $oracleReadStatement;
				$str .= "		} \n";


				$str .= "           try {\n";
				$str .= "               \$this->q->read(\$sql);\n";
				$str .= "           } catch (\\Exception \$e) {\n";
				$str .= "               echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
				$str .= "               exit();\n";
				$str .= "           }\n";
				$str .= "		\$items = array(); \n";
				$str .= "           \$i = 1; \n";
				$str .= "		while ((\$row = \$this->q->fetchAssoc()) == TRUE) { \n";
				$str .= "               \$items [] = \$row; \n";
				$str .= "               \$i++; \n";
				$str .= "		}  \n";
				$str .= "  		return \$items;\n";
				$str .= "     }\n";

				$str .= "    /**\n";
				$str .= "     * Update\n";
				$str .= "     * @see config::update()\n";
				$str .= "     * @return void\n";
				$str .= "     */ \n";
				$str .= "     public function update() {\n";
				$str .= "       if (\$this->getVendor() == self::MYSQL) { \n";
				$str .= "           \$sql = \"SET NAMES utf8\"; \n";
				$str .= "           try {\n";
				$str .= "               \$this->q->fast(\$sql);\n";
				$str .= "           } catch (\\Exception \$e) {\n";
				$str .= "               echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
				$str .= "               exit();\n";
				$str .= "           }\n";
				$str .= "       } \n";
				$str .= "       \$this->q->start(); \n";
				$str .= "       \$this->model->update(); \n";
				$str .= "       // before updating check the id exist or not . if exist continue to update else warning the user \n";
				$str .= "       \$sql=null;\n";
				if ($dataTabDetail[$j][0]['foreignKeyYes'] == 1) {
				for ($i = 0; $i < $total; $i++) {
				if ($dataTabDetail [$j][$i] ['Key'] == 'MUL' && $dataTabDetail[$j][$i]['columnName'] != 'companyId') {
				$str.="       if(!\$this->model->get" . ucfirst($dataTabDetail[$j][$i]['columnName']) . "()){\n";
				$str.="           \$this->model->set" . ucfirst($dataTabDetail[$j][$i]['columnName']) . "(\$this->service->get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName'])) . "DefaultValue());\n";
				$str.="       }\n";
				}
				}
				}
				
				for($t=1;$t<=$dataTabDetail[$j][0]['targetMaximumTabRecord'];$t++) { 
					$str .= "           if (\$this->getVendor() == self::MYSQL) { \n";
					$mysqlUpdateStatementInsideValue = null;
					$mysqlUpdateStatementValue = null;
					$mysqlUpdateStatement = "               \$sql=\"\n";
					$mysqlUpdateStatement .= "               UPDATE `" . strtolower($dataTabDetail [$j][0] ['tableName']) . "`\n";
					$mysqlUpdateStatement .= "               SET ";
					for ($i = 0; $i < $total; $i++) {
						if ($i >= 1) {
							if($dataTabDetail[$j][$i]['columnName']  != $data[0]['primaryKeyName']) { 
							if ($dataTabDetail[$j][$i]['columnName'] == 'companyId') {
								//  $mysqlUpdateStatementInsideValue .= "                       `" . $dataTabDetail [$j][$i] ['columnName'] . "` = \".\$_SESSION['companyId'].\",\n";
							} else if ($dataTabDetail[$j][$i]['columnName'] == 'executeBy') {
								$mysqlUpdateStatementInsideValue .= "                       `" . $dataTabDetail [$j][$i] ['columnName'] . "` = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\"',\n";
							} else if ($dataTabDetail [$j][$i] ['columnName'] != 'isDefault' && $dataTabDetail [$j][$i] ['columnName'] != 'isNew' && $dataTabDetail [$j][$i] ['columnName'] != 'isDraft' && $dataTabDetail [$j][$i] ['columnName'] != 'isUpdate' && $dataTabDetail [$j][$i] ['columnName'] != 'isDelete' && $dataTabDetail [$j][$i] ['columnName'] != 'isActive' && $dataTabDetail [$j][$i] ['columnName'] != 'isApproved' && $dataTabDetail [$j][$i] ['columnName'] != 'isReview' && $dataTabDetail [$j][$i] ['columnName'] != 'isPost' && $dataTabDetail [$j][$i] ['columnName'] != 'isSlice' && $dataTabDetail [$j][$i] ['columnName'] != 'isConsolidation' && $dataTabDetail [$j][$i] ['columnName'] != 'isReconciled' && $dataTabDetail [$j][$i] ['columnName'] != 'executeBy' && $dataTabDetail [$j][$i] ['columnName'] != 'executeTime') {
								$mysqlUpdateStatementInsideValue .= "                       `" . $dataTabDetail [$j][$i] ['columnName'] . "` = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(".$t.").\"',\n";
							} else if ($dataTabDetail [$j][$i] ['columnName'] == 'executeTime') {
								$mysqlUpdateStatementInsideValue .= "                       `" . $dataTabDetail [$j][$i] ['columnName'] . "` = \".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\",\n";
							} else {
								$mysqlUpdateStatementInsideValue .= "                       `" . $dataTabDetail [$j][$i] ['columnName'] . "` = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "('0','single').\"',\n";
							}
							}
						}
					}
					$mysqlUpdateStatementValue .= (substr($mysqlUpdateStatementInsideValue, 0, -2));
					$mysqlUpdateStatement .= $mysqlUpdateStatementValue;
					$mysqlUpdateStatement .= "\n               WHERE    `companyId` ='\".\$this->getCompanyId().\"'\n";
					$mysqlUpdateStatement .= "AND 	   `" . str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName']) . "LineNumber` = '\" . \$this->model->get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName'])) . "LineNumber(".$t.") . \"' \";\n";
					$str .= $mysqlUpdateStatement;

					$str .= "           } else if (\$this->getVendor() == self::MSSQL) {  \n";

					$mssqlUpdateStatementInsideValue = null;
					$mssqlUpdateStatementValue = null;
					$mssqlUpdateStatement = "                \$sql=\"\n";
					$mssqlUpdateStatement .= "                UPDATE [" . $dataTabDetail [$j][0] ['tableName'] . "] SET \n";

					for ($i = 0; $i < $total; $i++) {

					if ($i >= 1) {
					if ($dataTabDetail[$j][$i]['columnName'] == 'companyId') {
					//   $mssqlUpdateStatementInsideValue .= "                       [" . $dataTabDetail [$j][$i] ['columnName'] . "] = \".\$_SESSION['companyId'].\",\n";
					} else if ($dataTabDetail[$j][$i]['columnName'] == 'executeBy') {
						$mssqlUpdateStatementInsideValue .= "                       [" . $dataTabDetail [$j][$i] ['columnName'] . "] = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\"',\n";
					} else if ($dataTabDetail [$j][$i] ['columnName'] != 'isDefault' && $dataTabDetail [$j][$i] ['columnName'] != 'isNew' && $dataTabDetail [$j][$i] ['columnName'] != 'isDraft' && $dataTabDetail [$j][$i] ['columnName'] != 'isUpdate' && $dataTabDetail [$j][$i] ['columnName'] != 'isDelete' && $dataTabDetail [$j][$i] ['columnName'] != 'isActive' && $dataTabDetail [$j][$i] ['columnName'] != 'isApproved' && $dataTabDetail [$j][$i] ['columnName'] != 'isReview' && $dataTabDetail [$j][$i] ['columnName'] != 'isPost' && $dataTabDetail [$j][$i] ['columnName'] != 'isSlice' && $dataTabDetail [$j][$i] ['columnName'] != 'isConsolidation' && $dataTabDetail [$j][$i] ['columnName'] != 'isReconciled' && $dataTabDetail [$j][$i] ['columnName'] != 'executeBy' && $dataTabDetail [$j][$i] ['columnName'] != 'executeTime') {
					$mssqlUpdateStatementInsideValue .= "                       [" . $dataTabDetail [$j][$i] ['columnName'] . "] = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(".$t.").\"',\n";
					} else if ($dataTabDetail [$j][$i] ['columnName'] == 'executeTime') {
					$mssqlUpdateStatementInsideValue .= "                       [" . $dataTabDetail [$j][$i] ['columnName'] . "] = \".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\",\n";
					} else {
					$mssqlUpdateStatementInsideValue .= "                       [" . $dataTabDetail [$j][$i] ['columnName'] . "] = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(0, 'single').\"',\n";
					}
					}
					}
					$mssqlUpdateStatementValue .= (substr($mssqlUpdateStatementInsideValue, 0, -2));
					$mssqlUpdateStatement .= $mssqlUpdateStatementValue;
					$mssqlUpdateStatement .= "\n                WHERE  [companyId]='\".\$this->getCompanyId().\"'  AND [" . str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName']) . "LineNumber] = '\" . \$this->model->get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName'])) . "LineNumber(".$t.") . \"' \"; \n";
					$str .= $mssqlUpdateStatement;
					$str .= "           } else if (\$this->getVendor() == self::ORACLE) {  \n";
					$oracleUpdateStatementInsideValue = null;
					$oracleUpdateStatementValue = null;
					$oracleUpdateStatement = "                \$sql=\"\n";
					$oracleUpdateStatement .= "                UPDATE " . strtoupper($dataTabDetail [$j][0] ['tableName']) . " SET\n ";
					for ($i = 0; $i < $total; $i++) {

					if ($i >= 1) {
					if ($dataTabDetail[$j][$i]['columnName'] == 'companyId') {
					//       $oracleUpdateStatementInsideValue .= "                       " . strtoupper($dataTabDetail [$j][$i] ['columnName']) . " = '\".\$_SESSION['companyId'].\"',\n";
					} else if ($dataTabDetail[$j][$i]['columnName'] == 'executeBy') {
						$oracleUpdateStatementInsideValue .= "                       " . strtoupper($dataTabDetail [$j][$i] ['columnName']) . " = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\"',\n";
					} else if ($dataTabDetail [$j][$i] ['columnName'] != 'isDefault' && $dataTabDetail [$j][$i] ['columnName'] != 'isNew' && $dataTabDetail [$j][$i] ['columnName'] != 'isDraft' && $dataTabDetail [$j][$i] ['columnName'] != 'isUpdate' && $dataTabDetail [$j][$i] ['columnName'] != 'isDelete' && $dataTabDetail [$j][$i] ['columnName'] != 'isActive' && $dataTabDetail [$j][$i] ['columnName'] != 'isApproved' && $dataTabDetail [$j][$i] ['columnName'] != 'isReview' && $dataTabDetail [$j][$i] ['columnName'] != 'isPost' && $dataTabDetail [$j][$i] ['columnName'] != 'isSlice' && $dataTabDetail [$j][$i] ['columnName'] != 'isConsolidation' && $dataTabDetail [$j][$i] ['columnName'] != 'isReconciled' && $dataTabDetail [$j][$i] ['columnName'] != 'executeBy' && $dataTabDetail [$j][$i] ['columnName'] != 'executeTime') {
					$oracleUpdateStatementInsideValue .= "                       " . strtoupper($dataTabDetail [$j][$i] ['columnName']) . " = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(".$t.").\"',\n";
					} else if ($dataTabDetail [$j][$i] ['columnName'] == 'executeTime') {
					$oracleUpdateStatementInsideValue .= "                       " . strtoupper($dataTabDetail [$j][$i] ['columnName']) . " = \".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "().\",\n";
					} else {
					$oracleUpdateStatementInsideValue .= "                       " . strtoupper($dataTabDetail [$j][$i] ['columnName']) . " = '\".\$this->model->get" . ucFirst($dataTabDetail [$j][$i] ['columnName']) . "(0, 'single').\"',\n";
					}
					}
					}
					$oracleUpdateStatementValue .= (substr($oracleUpdateStatementInsideValue, 0, -2));
					$oracleUpdateStatement .= $oracleUpdateStatementValue;
					$oracleUpdateStatement .= "\n              WHERE COMPANYID='\".\$this->getCompanyId().\"'  AND " . strtoupper(str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName'])) . "LINENUMBER = '\" . \$this->model->get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][0]['primaryKeyName'])) . "LineNumber(".$t.") . \"' \"; \n";

					$str .= $oracleUpdateStatement;
					$str .= "           } \n";

					$str .= "           try {\n";
					$str .= "               \$this->q->update(\$sql);\n";
					$str .= "           } catch (\\Exception \$e) {\n";
					$str .= "               \$this->q->rollback();\n";
					$str .= "               echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
					$str .= "               exit();\n";
					$str .= "           }\n";
				}
				$str .= "     }\n";
				
			

				$str .= "    /**\n";
				$str .= "     * Delete\n";
				$str .= "     * @see config::delete()\n";
				$str .= "     * @return void\n";
				$str .= "     */\n";
				$str .= "     public function delete() {\n";
				$str .= "     }\n";

				$str .= "    /**\n";
				$str .= "     * Reporting\n";
				$str .= "     * @see config::excel()\n";
				$str .= "     * @return void\n";
				$str .= "     */\n";
				$str .= "     public function excel() {\n";
				$str .= "     }\n";
$str .= " } \n";
			

				}
			
			}
		}
	}
		$str .= "?>";
	return $str;
}
function checkString($str) {
        $str{0} = strtolower($str{0});
        $strArray = str_split($str);
        $totalStr = count($strArray);
        $i = 0;
        $stop = array();
        if (!is_array($strArray)) {
            return false;
        }
        foreach ($strArray as $alpha) {
            if (strtoupper($alpha) === $alpha) {
				$string.= " ".$alpha;
            } else {
				$string.= $alpha;
        }
    }
	return ucwords($string);
}
?>
