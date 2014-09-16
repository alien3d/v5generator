<?php

function controller($data, $dataTabDetail = null) {
    $total = 0;
    if (!is_array($data)) {
        $data = array();
    }
    if (isset($dataTabDetail) && count($dataTabDetail) > 0) {
        $total = count($dataTabDetail);
        for ($i = 0; $i < $total; $i++) {
            if ($dataTabDetail[$i]['Key'] == 'PRI') {
                $dataTabDetail[0]['tableName'] = str_replace('Id', '', $dataTabDetail[0]['columnName']);
            }
        }
    } else {
        $dataTabDetail = array();
    }
    $service = 0;
    if (isset($data) && is_array($data)) {
        // echo $data[0][primaryKeyName];
        $total = count($data);
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['Key'] == 'PRI') {
                $data[0]['tableName'] = str_replace('Id', '', $data[0]['columnName']);
            }
        }
        $foreignKeyYes = null;

        for ($i = 0; $i < $total; $i++) {
            if ($data [$i] ['foreignKey'] == 1 && $data [$i] ['Key'] == 'MUL') {
                $foreignKeyYes = 1;
                break;
            }
        }
        $str .= "<?php namespace Core\\" . ucwords($data [0] ['package']) . "\\" . ucwords($data [0] ['module']) . "\\" . ucwords($data [0] ['tableName']) . "\\Controller; \n";
        $str .= "use Core\\ConfigClass;\n";
        $str .= "use Core\\" . ucwords($data [0] ['package']) . "\\" . ucwords($data [0] ['module']) . "\\" . ucwords($data [0] ['tableName']) . "\\Model\\" . ucwords($data [0] ['tableName']) . "Model;\n";
        if ($foreignKeyYes == 1) {
            $str .= "use Core\\" . ucwords($data [0] ['package']) . "\\" . ucwords($data [0] ['module']) . "\\" . ucwords($data [0] ['tableName']) . "\\Service\\" . ucwords($data [0] ['tableName']) . "Service;\n";
        }
        $str .= "use Core\\Document\\Trail\\DocumentTrailClass;\n";
        $str .= "use Core\\RecordSet\\RecordSet;\n";
        $str .= "use Core\\shared\\SharedClass;\n";
        $str .= "if (!isset(\$_SESSION)) { \n";
        $str .= "    session_start(); \n";
        $str .= "} \n";
        $str .= "\$x = addslashes(realpath(__FILE__));\n";
        $str .= "// auto detect if \\ consider come from windows else / from linux\n";

        $str .= "\$pos = strpos(\$x, \"\\\\\");\n";
        $str .= "if (\$pos !== false) {\n";
        $str .= "    \$d = explode(\"\\\\\", \$x);\n";
        $str .= "} else {  \n";
        $str .= "    \$d = explode(\"/\", \$x);\n";
        $str .= "}\n";
        $str .= "\$newPath = null;\n";
        $str .= "for (\$i = 0; \$i < count(\$d); \$i ++) {\n";
        $str .= "    // if find the library or package then stop\n";
        $str .= "    if (\$d[\$i] == 'library' || \$d[\$i] == 'v3') {\n";
        $str .= "        break;\n";
        $str .= "    }\n";
        $str .= "    \$newPath[] .= \$d[\$i] . \"/\";\n";
        $str .= "}\n";
        $str .= "\$fakeDocumentRoot = null;\n";
        $str .= "for (\$z = 0; \$z < count(\$newPath); \$z ++) {\n";
        $str .= "    \$fakeDocumentRoot .= \$newPath[\$z];\n";
        $str .= "}\n";
        $str .= "\$newFakeDocumentRoot = str_replace(\"//\", \"/\", \$fakeDocumentRoot); // start\n";

        $str .= "require_once (\$newFakeDocumentRoot.\"library/class/classAbstract.php\"); \n";
        $str .= "require_once (\$newFakeDocumentRoot.\"library/class/classRecordSet.php\"); \n";
        $str .= "require_once (\$newFakeDocumentRoot.\"library/class/classDate.php\"); \n";
        $str .= "require_once (\$newFakeDocumentRoot.\"library/class/classDocumentTrail.php\"); \n";
        $str .= "require_once (\$newFakeDocumentRoot.\"library/class/classShared.php\"); \n";
        $str .= "require_once (\$newFakeDocumentRoot.\"v3/system/document/model/documentModel.php\"); \n";
        $str .= "require_once (\$newFakeDocumentRoot.\"v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/model/" . $data [0] ['tableName'] . "Model.php\"); \n";

        if ($foreignKeyYes == 1) {
            $str .= "require_once (\$newFakeDocumentRoot.\"v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/service/" . $data [0] ['tableName'] . "Service.php\"); \n";
        }
        $str .= "/** \n";
        $str .= " * Class " . ucfirst($data [0] ['tableName']) . "\n";
        $str .= " * this is " . $data [0] ['tableName'] . " controller files. \n";
        $str .= " * @name IDCMS \n";
        $str .= " * @version 2 \n";
        $str .= " * @author hafizan \n";
        $str .= " * @package  Core\\" . ucwords($data [0] ['package']) . "\\" . ucwords($data [0] ['module']) . "\\" . ucwords($data [0] ['tableName']) . "\\Controller \n";
        $str .= " * @subpackage " . ucwords($data [0] ['module']) . " \n";
        $str .= " * @link http://www.hafizan.com \n";
        $str .= " * @license http://www.gnu.org/copyleft/lesser.html LGPL \n";
        $str .= " */ \n";
        $str .= "class " . ucfirst($data [0] ['tableName']) . "Class extends ConfigClass { \n";
        // start object
        $str .= "	/** \n";
        $str .= "	 * Connection to the database \n";
        $str .= "	 * @var \\Core\\Database\\Oracle\\Vendor \n";
        $str .= "	 */ \n";
        $str .= "	public \$q; \n";

        $str .= "	/** \n";
        $str .= "	 * Php Excel Generate Microsoft Excel 2007 Output.Format : xlsx/pdf \n";
        $str .= "	 * @var \\PHPExcel \n";
        $str .= "	 */ \n";
        $str .= "	private \$excel; \n";

        $str .= "	/** \n";
        $str .= "	 * Record Pagination \n";
        $str .= "	 * @var \\Core\\RecordSet\\RecordSet \n";
        $str .= "	 */ \n";
        $str .= "	private \$recordSet; \n";

        $str .= "	/** \n";
        $str .= "	 * Document Trail Audit. \n";
        $str .= "	 * @var \\Core\\Document\\Trail\\DocumentTrailClass \n";
        $str .= "	 */ \n";
        $str .= "	private \$documentTrail; \n";

        $str .= "	/** \n";
        $str .= "	 * Model \n";
        $str .= "	 * @var \\Core\\" . ucwords($data [0] ['package']) . "\\" . ucwords($data [0] ['module']) . "\\" . ucwords($data [0] ['tableName']) . "\Model\\" . ucwords($data [0] ['tableName']) . "Model \n";
        $str .= "	 */ \n";
        $str .= "	public \$model; \n";

        if ($foreignKeyYes == 1) {
            $str .= "	/** \n";
            $str .= "	 * Service-Business Application Process or other ajax request \n";
            $str .= "	 * @var \\Core\\" . ucwords($data [0] ['package']) . "\\" . ucwords($data [0] ['module']) . "\\" . ucwords($data [0] ['tableName']) . "\Service\\" . ucwords($data [0] ['tableName']) . "Service \n";
            $str .= "	 */ \n";
            $str .= "	public \$service; \n";
        }

        $str .= "	/** \n";
        $str .= "	 * System Format \n";
        $str .= "	 * @var \\Core\\shared\\SharedClass\n";
        $str .= "	 */ \n";
        $str .= "	public \$systemFormat; \n";
        // end object


        $str .= "	/** \n";
        $str .= "	 * Translation Array \n";
        $str .= "	 * @var mixed \n";
        $str .= "	 */ \n";
        $str .= "	public \$translate; \n";


        $str .= "	/** \n";
        $str .= "	 * Leaf Access  \n";
        $str .= "	 * @var mixed \n";
        $str .= "	 */ \n";
        $str .= "	public \$leafAccess; \n";

        $str .= "	/** \n";
        $str .= "	 * Translate Label \n";
        $str .= "	 * @var array\n";
        $str .= "	 */ \n";
        $str .= "	public \$t; \n";

        $str .= "	/** \n";
        $str .= "	 * System Format \n";
        $str .= "	 * @var array\n";
        $str .= "	 */ \n";
        $str .= "	public \$systemFormatArray; \n";
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
        $str .= "       \$this->translate=array();\n";
        $str .= "       \$this->t=array();\n";
        $str .= "       \$this->leafAccess=array();\n";
        $str .= "       \$this->systemFormat=array();\n";
        $str .= "       \$this->setViewPath(\"./v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/view/" . $data [0] ['tableName'] . ".php\"); \n";
        $str .= "       \$this->setControllerPath(\"./v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/controller/" . $data [0] ['tableName'] . "Controller.php\");\n";
        if ($foreignKeyYes == 1) {
            $str .= "       \$this->setServicePath(\"./v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/service/" . $data [0] ['tableName'] . "Service.php\"); \n";
        }
        $str .= "   } \n";
        $str .= "	/** \n";
        $str .= "	 * Class Loader \n";
        $str .= "	 */ \n";
        $str .= "	function execute() { \n";
        $str .= "       parent::__construct(); \n";
        $str .= "       \$this->setAudit(1); \n";
        $str .= "       \$this->setLog(1); \n";

        $str .= "       \$this->model  = new " . ucfirst($data [0] ['tableName']) . "Model(); \n";
        $str .= "       \$this->model->setVendor(\$this->getVendor()); \n";
        $str .= "       \$this->model->execute(); \n";


        $str .= "           \$this->q = new \\Core\\Database\\Oracle\\Vendor(); \n";
        $str .= "       \$this->setVendor(\$this->getVendor()); \n";
        $str .= "       \$this->q->setRequestDatabase(\$this->q->getCoreDatabase()); \n";

        $str .= "       // \$this->q->setApplicationId(\$this->getApplicationId()); \n";
        $str .= "       // \$this->q->setModuleId(\$this->getModuleId()); \n";
        $str .= "       // \$this->q->setFolderId(\$this->getFolderId()); \n";
        $str .= "       \$this->q->setLeafId(\$this->getLeafId()); \n";
        $str .= "       \$this->q->setLog(\$this->getLog()); \n";
        $str .= "       \$this->q->setAudit(\$this->getAudit()); \n";
        $str .= "       \$this->q->connect(\$this->getConnection(), \$this->getUsername(), \$this->getDatabase(), \$this->getPassword()); \n\n";
        $str .= "       \$data = \$this->q->getLeafLogData();\n";
        $str .= "       if (is_array(\$data) && count(\$data)>0 ) {\n";
        $str .= "           \$this->q->getLog(\$data['isLog']);\n";
        $str .= "           \$this->q->setAudit(\$data['isAudit']);\n";
        $str .= "       }\n";
        $str .= "       if(\$this->getAudit()==1){\n";
        $str .= "           \$this->q->setAudit(\$this->getAudit());\n";
        $str .= "           \$this->q->setTableName(\$this->model->getTableName());\n";
        $str .= "           \$this->q->setPrimaryKeyName(\$this->model->getPrimaryKeyName());\n";
        $str .= "       }\n";
        $str .= "       \$translator = new SharedClass();   \n";
        $str .= "       \$translator->setCurrentTable(\$this->model->getTableName()); \n";
        $str .= "       \$translator->setLeafId(\$this->getLeafId()); \n";
        $str .= "       \$translator->execute();\n\n";
        $str .= "       \$this->translate   = \$translator->getLeafTranslation(); // short because code too long  \n";
        $str .= "       \$this->t           = \$translator->getDefaultTranslation(); // short because code too long  \n\n";

        // print title of report
        $str .= "       \$arrayInfo         =   \$translator->getFileInfo(); \n";


        $str .= "       \$applicationNative =   \$arrayInfo['applicationNative']; \n";
        $str .= "       \$folderNative      =   \$arrayInfo['folderNative']; \n";
        $str .= "       \$moduleNative      =   \$arrayInfo['moduleNative']; \n";
        $str .= "       \$leafNative        =   \$arrayInfo['leafNative']; \n";

        $str .= "       \$this->setApplicationId(\$arrayInfo['applicationId']); \n";
        $str .= "       \$this->setModuleId(\$arrayInfo['moduleId']); \n";
        $str .= "       \$this->setFolderId(\$arrayInfo['folderId']); \n";
        $str .= "       \$this->setLeafId(\$arrayInfo['leafId']); \n";

        $str .= "       \$this->setReportTitle(\$applicationNative.\" :: \".\$moduleNative.\" :: \".\$folderNative.\" :: \".\$leafNative); \n\n";

        if ($foreignKeyYes == 1) {
            $str .= "       \$this->service  = new " . ucfirst($data [0] ['tableName']) . "Service(); \n";
            $str .= "       \$this->service->q = \$this->q; \n";
            $str .= "       \$this->service->t = \$this->t; \n";
            $str .= "       \$this->service->setVendor(\$this->getVendor()); \n";
            $str .= "       \$this->service->setServiceOutput(\$this->getServiceOutput()); \n";
            $str .= "       \$this->service->execute(); \n\n";
        }


        // record set for paging
        $str .= "       \$this->recordSet = new RecordSet(); \n";
        $str .= "       \$this->recordSet->q = \$this->q; \n";
        $str .= "       \$this->recordSet->setCurrentTable(\$this->model->getTableName()); \n";
        $str .= "       \$this->recordSet->setPrimaryKeyName(\$this->model->getPrimaryKeyName()); \n";
        $str .= "       \$this->recordSet->execute(); \n\n";

        // document trail.. backup all file to here.. path only
        $str .= "       \$this->documentTrail = new DocumentTrailClass(); \n";
        $str .= "       \$this->documentTrail->q = \$this->q; \n";
        $str .= "       \$this->documentTrail->setVendor(\$this->getVendor()); \n";
        $str .= "       \$this->documentTrail->setStaffId(\$this->getStaffId()); \n";
        $str .= "       \$this->documentTrail->setLanguageId(\$this->getLanguageId()); \n";

        $str .= "       \$this->documentTrail->setApplicationId(\$this->getApplicationId());\n";
        $str .= "       \$this->documentTrail->setModuleId(\$this->getModuleId());\n";
        $str .= "       \$this->documentTrail->setFolderId(\$this->getFolderId());\n";
        $str .= "       \$this->documentTrail->setLeafId(\$this->getLeafId());\n";

        $str .= "       \$this->documentTrail->execute(); \n\n";

        $str .= "       \$this->systemFormat = new SharedClass();  \n";
        $str .= "       \$this->systemFormat->q = \$this->q;  \n";
        $str .= "       \$this->systemFormat->setCurrentTable(\$this->model->getTableName());  \n";
        $str .= "       \$this->systemFormat->execute();  \n\n";
        $str .= "       \$this->systemFormatArray  =   \$this->systemFormat->getSystemFormat();  \n\n";

        // initialize php microsoft object
        // $str.=" \\ \$this->word = new PHPWord (); \n";
        $str .= "       \$this->excel = new \\PHPExcel (); \n";
        // $str.=" \\\$this->powerPoint = new PHPPowerPoint (); \n";
        $str .= "   } \n";
        $str .= "  \n";
        $str .= "	/**  \n";
        $str .= "	 * Create\n";
        $str .= "	 * @see config::create()  \n";
        $str .= "	 */  \n";

        $str .= "	public function create() {  \n";
        $str .= "       header('Content-Type:application/json; charset=utf-8');  \n";
        $str .= "       \$start = microtime(true);  \n";

        $str .= "       \$this->q->start();  \n";
        $str .= "       \$this->model->create();  \n";
        $str .= "       \$sql=null;\n";
        if ($foreignKeyYes == 1) {
            for ($i = 0; $i < $total; $i++) {
                if ($data [$i] ['Key'] == 'MUL' && $data[$i]['columnName'] != 'companyId') {
                    $str.="       if(!\$this->model->get" . ucfirst($data[$i]['columnName']) . "()){\n";
                    $str.="           \$this->model->set" . ucfirst($data[$i]['columnName']) . "(\$this->service->get" . ucfirst(str_replace("Id", "", $data[$i]['columnName'])) . "DefaultValue());\n";
                    $str.="       }\n";
                }
            }
        }

        $oracleInsertStatement = null;
        $oracleInsertStatementAField = null;
        $oracleInsertStatementField = null;
        $oracleInsertStatementInsideValue = null;
        $oracleInsertStatementValue = null;
        $oracleInsertStatement .= "            \$sql=\"\n            INSERT INTO " . strtoupper($data [0] ['tableName']) . " \n            (\n";
        for ($i = 0; $i < $total; $i++) {
            if ($i >= 1) {
                $oracleInsertStatementAField .= "                 " . strtoupper($data [$i] ['columnName']) . ",\n";
            }
        }
        $oracleInsertStatementField .= (substr($oracleInsertStatementAField, 0, -2));
        $oracleInsertStatement .= $oracleInsertStatementField;
        $oracleInsertStatement .= "\n            ) VALUES ( \n";
        for ($i = 0; $i < $total; $i++) {
            if ($i >= 1) {
                if ($data [$i] ['columnName'] == 'executeTime') {
                    $oracleInsertStatementInsideValue .= "                 \".\$this->model->get" . ucFirst($data [$i] ['columnName']) . "().\",\n";
                } else if ($data[$i]['columnName'] == 'companyId') {
                    $oracleInsertStatementInsideValue .= "                 '\".\$this->getCompanyId().\"',\n";
                } else if ($data [$i] ['columnName'] != 'isDefault' && $data [$i] ['columnName'] != 'isNew' && $data [$i] ['columnName'] != 'isDraft' && $data [$i] ['columnName'] != 'isUpdate' && $data [$i] ['columnName'] != 'isDelete' && $data [$i] ['columnName'] != 'isActive' && $data [$i] ['columnName'] != 'isApproved' && $data [$i] ['columnName'] != 'isReview' && $data [$i] ['columnName'] != 'isPost' && $data [$i] ['columnName'] != 'isSlice' && $data [$i] ['columnName'] != 'isConsolidation') {
                    $oracleInsertStatementInsideValue .= "                 '\".\$this->model->get" . ucFirst($data [$i] ['columnName']) . "().\"',\n";
                } else {
                    $oracleInsertStatementInsideValue .= "                 '\".\$this->model->get" . ucFirst($data [$i] ['columnName']) . "(0, 'single').\"',\n";
                }
            }
        }
        $oracleInsertStatementValue .= (substr($oracleInsertStatementInsideValue, 0, -2));
        $oracleInsertStatement .= $oracleInsertStatementValue;
        $oracleInsertStatement .= "\n            );\";\n";
        $str .= $oracleInsertStatement;

        $str .= "       try {\n";
        $str .= "           \$this->q->create(\$sql);\n";
        $str .= "       } catch (\\Exception \$e) {\n";
        $str .= "           \$this->q->rollback();\n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "           exit();\n";
        $str .= "       }\n";
        $str .= "       \$" . $data [0] ['primaryKeyName'] . " = \$this->q->lastInsertId(); \n";

        $str .= "       \$this->q->commit(); \n";
        $str .= "       \$end = microtime(true); \n";
        $str .= "       \$time = \$end - \$start; \n";
        $str .= "       echo json_encode( \n";
        $str .= "           array(	\"success\" => true, \n";
        $str .= "                   \"message\" => \$this->t['newRecordTextLabel'],  \n";
        $str .= "                   \"staffName\" => \$_SESSION['staffName'],  \n";
        $str .= "                   \"executeTime\" =>date('d-m-Y H:i:s'),  \n";
        $str .= "                   \"totalRecord\"=>\$this->getTotalRecord(),\n";
        $str .= "                   \"" . $data [0] ['primaryKeyName'] . "\" => \$" . $data [0] ['primaryKeyName'] . ",\n";
        $str .= "                   \"time\"=>\$time)); \n";
        $str .= "       exit(); \n";
        $str .= "	} \n";

        $str .= "	/** \n";
        $str .= "    * Read\n";
        $str .= "	 * @see config::read() \n";
        $str .= "	 */ \n";
        $str .= "	public function read() { \n";
        $str .= "       if (\$this->getPageOutput() == 'json' ||  \$this->getPageOutput() =='table') { \n";
        $str .= "           header('Content-Type:application/json; charset=utf-8'); \n";
        $str .= "       } \n";
        $str .= "       \$start = microtime(true); \n";
        $str .= "       if(isset(\$_SESSION['isAdmin'])) { \n";
        // here we can arrange if request wanted to filter by user key in only
        $str .= "           if (\$_SESSION['isAdmin'] == 0) { \n";
        $str .= "                   \$this->setAuditFilter(\" " . strtoupper($data [0] ['tableName']) . ".ISACTIVE = 1  AND " . strtoupper($data [0] ['tableName']) . ".COMPANYID='\".\$this->getCompanyId().\"'\"); \n";
        $str .= "           } else if (\$_SESSION['isAdmin'] == 1) { \n";

        $str .= "                   \$this->setAuditFilter(\" " . strtoupper($data [0] ['tableName']) . ".COMPANYID='\".\$this->getCompanyId().\"' \"); \n";
        $str .= "           } \n";
        $str .= "       } \n";


        $oracleReadStatement = "\n		  \$sql = \"\n		  SELECT";

        for ($i = 0; $i < $total; $i++) {
            if ($data [$i] ['foreignKey'] == 1 && $data [$i] ['Key'] == 'MUL') {
                //exception for some cases
                if ($data[$i]['columnName'] == 'businessPartnerId') {
                    $field = str_replace("Id", "", $data[$i]['columnName']) . "Company";
                } else if ($data[$i]['columnName'] == 'employeeId') {
                    $field = str_replace("Id", "", $data[$i]['columnName']) . "FirstName";
                } else if ($data[$i]['columnName'] == 'staffId') {
                    $field = str_replace("Id", "", $data[$i]['columnName']) . "Name";
                } else if ($data[$i]['columnName'] == 'chartOfAccountId') {
                    $field = str_replace("Id", "", $data[$i]['columnName']) . "Title";
                } else if ($data[$i]['columnName'] == 'assetId') {
                    $field = str_replace("Id", "", $data[$i]['columnName']) . "Name";
                } else {
                    $field = str_replace("Id", "", $data[$i]['columnName']) . "Description";
                }
                $oracleReadInsideStatement .= "                    " . strtoupper(str_replace("Id", "", $data [$i] ['columnName'])) . "." . strtoupper($field) . " AS  \\\"" . $field . "\\\",\n";
                $oracleReadInsideStatement .= "                    " . strtoupper($data [0] ['tableName']) . "." . strtoupper($data [$i] ['columnName']) . " AS \\\"" . ($data [$i] ['columnName']) . "\\\",\n";
            } else {
                $oracleReadInsideStatement .= "                    " . strtoupper($data [0] ['tableName']) . "." . strtoupper($data [$i] ['columnName']) . " AS \\\"" . ($data [$i] ['columnName']) . "\\\",\n";
            }
        }
        $oracleReadStatement .= $oracleReadInsideStatement;

        $oracleReadStatement .= "                    STAFF.STAFFNAME AS \\\"staffName\\\" \n";
        $oracleReadStatement .= "		  FROM 	" . strtoupper($data [0] ['tableName']) . " \n";
        $oracleReadStatement .= "		  JOIN	STAFF \n";
        $oracleReadStatement .= "		  ON	" . strtoupper($data [0] ['tableName']) . ".EXECUTEBY = STAFF.STAFFID \n ";
        if ($foreignKeyYes == 1) {
            for ($i = 0; $i < $total; $i++) {
                if ($data [$i] ['foreignKey'] == 1 && $data [$i] ['Key'] == 'MUL') {
                    // assume in the same package also

                    $oracleReadStatement .= "	JOIN	" . strtoupper(str_replace("Id", "", $data [$i] ['columnName'])) . "\n";
                    $oracleReadStatement .= "	ON		" . strtoupper(str_replace("Id", "", $data [$i] ['columnName'])) . "." . strtoupper($data [$i] ['columnName']) . " = " . strtoupper($data [0] ['tableName']) . "." . strtoupper($data [$i] ['columnName']) . "\n";
                }
            }
        }
        $oracleReadStatement .= "         WHERE     \" . \$this->getAuditFilter(); \n";

        $str .= $oracleReadStatement;
        $str .= "           if (\$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single'))  {\n";
        $str .= "               \$sql .= \" AND " . strtoupper($data [0] ['tableName']) . ". \".strtoupper(\$this->model->getPrimaryKeyName()) . \"='\" . \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single') . \"'\"; \n";
        $str .= "           } \n";
        // there was a chance to filter  foreign key value
        if ($foreignKeyYes == 1) {
            for ($i = 0; $i < $total; $i++) {
                if ($data [$i] ['foreignKey'] == 1 && $data [$i] ['Key'] == 'MUL') {
                    if ($data[$i]['columnName'] != 'companyId') {
                        $str .= "       if (\$this->model->get" . ucfirst($data [$i] ['columnName']) . "()) { \n";
                        $str .= "           \$sql .= \" AND " . strtoupper($data [0] ['tableName']) . "." . strtoupper($data [$i] ['columnName']) . "='\".\$this->model->get" . ucfirst($data [$i] ['columnName']) . "().\"'\";  \n";
                        $str .= "       }\n";
                    }
                }
            }
        }

        $str .= "		/** \n";
        $str .= "		 * filter column based on first character \n";
        $str .= "		 */ \n";
        $str .= "		if(\$this->getCharacterQuery()){ \n";
        $str .= "                   \$sql.=\" AND Initcap(" . strtoupper($data [0] ['tableName']) . ".\".strtoupper(\$this->model->getFilterCharacter()).\") LIKE Initcap('\".\$this->getCharacterQuery().\"%')\"; \n";
        $str .= "		} \n";
        $str .= "		/** \n";
        $str .= "		 * filter column based on Range Of Date \n";
        $str .= "		 * Example Day,Week,Month,Year \n";
        $str .= "		 */ \n";
        $str .= "		if(\$this->getDateRangeStartQuery()){ \n";
        $str .= "                   \$sql.=\$this->q->dateFilter('" . strtoupper($data [0] ['tableName']) . "',\$this->model->getFilterDate(),\$this->getDateRangeStartQuery(),\$this->getDateRangeEndQuery(),\$this->getDateRangeTypeQuery(),\$this->getDateRangeExtraTypeQuery()); \n";
        $str .= "           } \n";
        $str .= "		/** \n";
        $str .= "		 * filter column don't want to filter.Example may contain  sensitive information or unwanted to be search. \n";
        $str .= "		 * E.g  \$filterArray=array('`leaf`.`leafId`'); \n";
        $str .= "		 * @variables \$filterArray; \n";
        $str .= "		 */  \n";
        $str .= "        \$filterArray =null;";
        $str .= "		    \$filterArray = array(\"" . strtoupper($data [0] ['tableName']) . "." . strtoupper($data [0] ['primaryKeyName']) . "\",\"STAFF.STAFFPASSWORD\"); \n";

        $str .= "		\$tableArray = null; \n";
        // list all foreign table and link ir up... yeah..
        $listTableForeignKey = null;
        for ($i = 0; $i < $total; $i++) {
            if ($data [$i] ['foreignKey'] == 1 && $data [$i] ['Key'] == 'MUL') {
                $listTableForeignKey .= "'" . str_replace("Id", "", $data[$i]['columnName']) . "',";
            }
        }

        $listForeignKeyTable = "," . substr($listTableForeignKey, 0, -1);

        $str .= "			\$tableArray = array('STAFF','" . strtoupper($data [0] ['tableName']) . "'" . strtoupper($listForeignKeyTable) . "); \n";
        $str .= "       \$tempSql=null;\n";
        $str .= "		if (\$this->getFieldQuery()) { \n";
        $str .= "                   \$tempSql = \$this->q->quickSearch(\$tableArray, \$filterArray); \n";
        $str .= "                   \$sql .= \$tempSql; \n";
        $str .= "		} \n";
        $str .= "       \$tempSql2=null;\n";
        $str .= "		if (\$this->getGridQuery()) { \n";
        $str .= "               \$this->q->setGridQuery(\$this->getGridQuery()); \n";

        $str .= "                   \$tempSql2 = \$this->q->searching(); \n";
        $str .= "                   \$sql .= \$tempSql2; \n";
        $str .= "		} \n";

        $str .= "       try {\n";
        $str .= "           \$this->q->read(\$sql);\n";
        $str .= "       } catch (\\Exception \$e) {\n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "           exit();\n";
        $str .= "       }\n";
        $str .= "		\$total = intval(\$this->q->numberRows()); \n";
        $str .= "		if ( \$this->getSortField()) { \n";

        $str .= "                   \$sql .= \"	ORDER BY \" . strtoupper(\$this->getSortField()) . \" \" . strtoupper(\$this->getOrder()) . \" \"; \n";
        $str .= "		} else {\n";

        $str .= "    }\n";
        $str .= "		\$_SESSION ['sql'] = \$sql; // push to session so can make report via excel and pdf \n";
        $str .= "		\$_SESSION ['start'] = \$this->getStart(); \n";
        $str .= "		\$_SESSION ['limit'] = \$this->getLimit(); \n";
        $str .= "       \$sqlDerived = null;\n";
        $str .= "		if ( \$this->getLimit()) { \n";
        $str .= "				/** \n";
        $str .= "				 * Oracle using derived table also \n";
        $str .= "				 **/ \n";
        $oracleReadPagingStatement = null;
        $oracleReadInsideStatement = null;
        $oracleReadPagingStatement .= "
						\$sqlDerived = \"\n
						SELECT *\n
						FROM 	(\n 	
									SELECT	a.*,\n
											rownum r\n
									FROM ( \".\$sql.\"\n 
								) a\n
						WHERE 	rownum <= '\" . (\$this->getStart() + \$this->getLimit()) . \"' )
						WHERE 	r >=  '\" . (\$this->getStart() + 1) . \"'\";\n";
        $str .= $oracleReadPagingStatement;


        $str .= "		/* \n";
        $str .= "		 *  Only Execute One Query \n";
        $str .= "		 */ \n";
        $str .= "		if (!(\$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single'))) { \n";
        $str .= "           try {\n";
        $str .= "               \$this->q->read(\$sqlDerived);\n";
        $str .= "           } catch (\\Exception \$e) {\n";
        $str .= "               echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "               exit();\n";
        $str .= "           }\n";
        $str .= "		} \n";
        $str .= "		\$items = array(); \n";
        $str .= "           \$i = 1; \n";
        $str .= "		while ((\$row = \$this->q->fetchAssoc()) == TRUE) { \n";
        $str .= "               \$row['total'] = \$total; // small override \n";
        $str .= "               \$row['counter'] = \$this->getStart() + $i; \n";
        $str .= "               if (\$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single')) { \n";
        $str .= "                   \$row['firstRecord'] = \$this->firstRecord('value'); \n";
        $str .= "                   \$row['previousRecord'] = \$this->previousRecord('value', \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single')); \n";
        $str .= "                   \$row['nextRecord'] = \$this->nextRecord('value', \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single')); \n";
        $str .= "                   \$row['lastRecord'] = \$this->lastRecord('value'); \n";
        $str .= "               }  \n";
        $str .= "               \$items [] = \$row; \n";
        $str .= "               \$i++; \n";
        $str .= "		}  \n";

        $str .= "		if (\$this->getPageOutput() == 'html') { \n";
        $str .= "               return \$items; \n";
        // this is for detail table if

        $str .= "           } else if (\$this->getPageOutput() == 'json') { \n";
        $str .= "           if (\$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single')) { \n";
        $str .= "               \$end = microtime(true); \n";
        $str .= "               \$time = \$end - \$start; \n";
        $str .= "               echo str_replace(array(\"[\",\"]\"),\"\",json_encode(array( \n";
        $str .= "                   'success' => true,  \n";
        $str .= "                   'total' => \$total,  \n";
        $str .= "                   'message' => \$this->t['viewRecordMessageLabel'],  \n";
        $str .= "                   'time' => \$time,  \n";
        $str .= "                   'firstRecord' => \$this->firstRecord('value'),  \n";
        $str .= "                   'previousRecord' => \$this->previousRecord('value', \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single')),  \n";
        $str .= "                   'nextRecord' => \$this->nextRecord('value', \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single')),  \n";
        $str .= "                   'lastRecord' => \$this->lastRecord('value'), \n";
        $str .= "                   'data' => \$items))); \n";
        $str .= "               exit(); \n";
        $str .= "           } else { \n";
        $str .= "               if (count(\$items) == 0) { \n";
        $str .= "                   \$items = ''; \n";
        $str .= "               } \n";
        $str .= "               \$end = microtime(true); \n";
        $str .= "               \$time = \$end - \$start; \n";
        $str .= "               echo json_encode(array( \n";
        $str .= "                   'success' =>true,  \n";
        $str .= "                   'total' => \$total,  \n";
        $str .= "                   'message' => \$this->t['viewRecordMessageLabel'], \n";
        $str .= "                   'time' => \$time,  \n";
        $str .= "                   'firstRecord' => \$this->recordSet->firstRecord('value'),  \n";
        $str .= "                   'previousRecord' => \$this->recordSet->previousRecord('value', \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single')),  \n";
        $str .= "                   'nextRecord' => \$this->recordSet->nextRecord('value', \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single')),  \n";
        $str .= "                   'lastRecord' => \$this->recordSet->lastRecord('value'), \n";
        $str .= "                   'data' => \$items)); \n";
        $str .= "               exit();  \n";
        $str .= "           } \n";
        $str .= "       }	 \n";
        $str .= "       return false;\n";
        $str .= "   } \n";

        $str .= "	/**\n";
        $str .= "    * Update\n";
        $str .= "	 * @see config::update() \n";
        $str .= "	 */ \n";
        $str .= "   function update() { \n";
        $str .= "       header('Content-Type:application/json; charset=utf-8'); \n";
        $str .= "       \$start = microtime(true); \n";

        $str .= "       \$this->q->start(); \n";
        $str .= "       \$this->model->update(); \n";
        $str .= "       // before updating check the id exist or not . if exist continue to update else warning the user \n";
        $str .= "       \$sql=null;\n";
        if ($foreignKeyYes == 1) {
            for ($i = 0; $i < $total; $i++) {
                if ($data [$i] ['Key'] == 'MUL' && $data[$i]['columnName'] != 'companyId') {
                    $str.="       if(!\$this->model->get" . ucfirst($data[$i]['columnName']) . "()){\n";
                    $str.="           \$this->model->set" . ucfirst($data[$i]['columnName']) . "(\$this->service->get" . ucfirst(str_replace("Id", "", $data[$i]['columnName'])) . "DefaultValue());\n";
                    $str.="       }\n";
                }
            }
        }


        $str .= "           \$sql = \" \n";
        $str .= "           SELECT	\" . strtoupper(\$this->model->getPrimaryKeyName()) . \" \n";
        $str .= "           FROM 	" . strtoupper($data [0] ['tableName']) . " \n";
        if ($dataTabDetail === false) {
            $str .= "           WHERE  COMPANYID='\".\$this->getCompanyId.\"' ";
            $str .= "           AND  	   \" . strtoupper(\$this->model->getPrimaryKeyName()) . \" = '\" . \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single') . \"' \"; \n";
        } else {

            $str .= "           WHERE  COMPANYID='\".\$this->getCompanyId.\"'";
            $str .= "           AND 	   " . strtoupper(str_replace("Id", "", $data[0]['primaryKeyName'])) . "LINENUMBER = '\" . \$this->model->get" . ucfirst(str_replace("Id", "", $data[0]['primaryKeyName'])) . "LineNumber(0, 'single') . \"' \"; \n";
        }

        $str .= "       \$result = \$this->q->fast(\$sql); \n";
        $str .= "       \$total = \$this->q->numberRows(\$result, \$sql); \n";
        $str .= "       if (\$total == 0) { \n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$this->t['recordNotFoundMessageLabel'])); \n";
        $str .= "           exit(); \n";
        $str .= "       } else { \n";

        $oracleUpdateStatementInsideValue = null;
        $oracleUpdateStatementValue = null;
        $oracleUpdateStatement = "                \$sql=\"\n";
        $oracleUpdateStatement .= "                UPDATE " . strtoupper($data [0] ['tableName']) . " SET\n ";
        $i = 0;
        for ($i = 0; $i < $total; $i++) {

            if ($i >= 1) {
                if ($data[$i]['columnName'] == 'companyId') {
                    //       $oracleUpdateStatementInsideValue .= "                       " . strtoupper($data [$i] ['columnName']) . " = '\".\$_SESSION['companyId'].\"',\n";
                } else if ($data [$i] ['columnName'] != 'isDefault' && $data [$i] ['columnName'] != 'isNew' && $data [$i] ['columnName'] != 'isDraft' && $data [$i] ['columnName'] != 'isUpdate' && $data [$i] ['columnName'] != 'isDelete' && $data [$i] ['columnName'] != 'isActive' && $data [$i] ['columnName'] != 'isApproved' && $data [$i] ['columnName'] != 'isReview' && $data [$i] ['columnName'] != 'isPost' && $data [$i] ['columnName'] != 'isSlice' && $data [$i] ['columnName'] != 'isConsolidation' && $data [$i] ['columnName'] != 'isReconciled' && $data [$i] ['columnName'] != 'executeBy' && $data [$i] ['columnName'] != 'executeTime') {
                    $oracleUpdateStatementInsideValue .= "                       " . strtoupper($data [$i] ['columnName']) . " = '\".\$this->model->get" . ucFirst($data [$i] ['columnName']) . "().\"',\n";
                } else if ($data [$i] ['columnName'] == 'executeTime') {
                    $oracleUpdateStatementInsideValue .= "                       " . strtoupper($data [$i] ['columnName']) . " = \".\$this->model->get" . ucFirst($data [$i] ['columnName']) . "().\",\n";
                } else {
                    $oracleUpdateStatementInsideValue .= "                       " . strtoupper($data [$i] ['columnName']) . " = '\".\$this->model->get" . ucFirst($data [$i] ['columnName']) . "(0, 'single').\"',\n";
                }
            }
        }
        $oracleUpdateStatementValue .= (substr($oracleUpdateStatementInsideValue, 0, -2));
        $oracleUpdateStatement .= $oracleUpdateStatementValue;
        $oracleUpdateStatement .= "\n                WHERE  " . strtoupper($data [0] ['primaryKeyName']) . "='\".\$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "('0','single').\"'\";\n\n";

        $str .= $oracleUpdateStatement;

        $str .= "           try {\n";
        $str .= "               \$this->q->update(\$sql);\n";
        $str .= "           } catch (\\Exception \$e) {\n";
        $str .= "               \$this->q->rollback();\n";
        $str .= "               echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "               exit();\n";
        $str .= "           }\n";
        $str .= "       } \n";
        $str .= "       \$this->q->commit(); \n";
        $str .= "       \$end = microtime(true); \n";
        $str .= "       \$time = \$end - \$start; \n";
        $str .= "       echo json_encode( \n";
        $str .= "           array(  \"success\" =>true, \n";
        $str .= "               \"message\" => \$this->t['updateRecordTextLabel'], \n";
        $str .= "               \"time\"=>\$time)); \n";
        $str .= "               exit(); \n";
        $str .= "   } \n";

        $str .= "	/** \n";
        $str .= "    * Delete\n";
        $str .= "	 * @see config::delete() \n";
        $str .= "	 */ \n";
        $str .= "   function delete() { \n";
        $str .= "       header('Content-Type:application/json; charset=utf-8'); \n";
        $str .= "       \$start = microtime(true); \n";
        $str .= "       \$this->q->start(); \n";
        $str .= "       \$this->model->delete(); \n";
        $str .= "       // before updating check the id exist or not . if exist continue to update else warning the user \n";
        $str .= "       \$sql=null;\n";

        $str .= "           \$sql = \" \n";
        $str .= "           SELECT	\" . strtoupper(\$this->model->getPrimaryKeyName()) . \" \n";
        $str .= "           FROM 	" . strtoupper($data [0] ['tableName']) . " \n";
        $str .= "           WHERE  	\" . strtoupper(\$this->model->getPrimaryKeyName()) . \" = '\" . \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single') . \"' \"; \n";
        $str .= "       try {\n";
        $str .= "           \$result    =   \$this->q->fast(\$sql);\n";
        $str .= "       } catch (\\Exception \$e) {\n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "           exit();\n";
        $str .= "       }\n";
        $str .= "       \$total = \$this->q->numberRows(\$result, \$sql); \n";
        $str .= "       if (\$total == 0) { \n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$this->t['recordNotFoundMessageLabel'])); \n";
        $str .= "           exit(); \n";
        $str .= "       } else { \n";

        $str .= "               \$sql=\"\n";
        $str .= "               UPDATE  " . strtoupper($data [0] ['tableName']) . " \n";
        $str .= "               SET     ISDEFAULT       =   '\" . \$this->model->getIsDefault(0, 'single') . \"',\n";
        $str .= "                       ISNEW           =   '\" . \$this->model->getIsNew(0, 'single') . \"',\n";
        $str .= "                       ISDRAFT         =   '\" . \$this->model->getIsDraft(0, 'single') .\"',\n";
        $str .= "                       ISUPDATE        =   '\" . \$this->model->getIsUpdate(0, 'single') . \"',\n";
        $str .= "                       ISDELETE        =   '\" . \$this->model->getIsDelete(0, 'single') . \"',\n";
        $str .= "                       ISACTIVE        =   '\" . \$this->model->getIsActive(0, 'single') . \"',\n";
        $str .= "                       ISAPPROVED      =   '\" . \$this->model->getIsApproved(0, 'single') .\"',\n";
        $str .= "                       ISREVIEW        =   '\" .\$this->model->getIsReview(0, 'single') . \"',\n";
        $str .= "                       ISPOST          =   '\" . \$this->model->getIsPost(0, 'single') .\"',\n";
        $str .= "                       EXECUTEBY       =   '\" . \$this->model->getExecuteBy() .\"',\n";
        $str .= "                       EXECUTETIME     =   \" . \$this->model->getExecuteTime() . \"\n";
        $str .= "               WHERE   " . strtoupper($data [0] ['primaryKeyName']) . "	=  '\" . \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(0, 'single') . \"'\";\n";
        $str .= "           try {\n";
        $str .= "               \$this->q->update(\$sql);\n";
        $str .= "           } catch (\\Exception \$e) {\n";
        $str .= "               \$this->q->rollback();\n";
        $str .= "               echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "               exit();\n";
        $str .= "           }\n";
        $str .= "       } \n";
        $str .= "       \$this->q->commit(); \n";
        $str .= "       \$end = microtime(true); \n";
        $str .= "       \$time = \$end - \$start; \n";
        $str .= "       echo json_encode( \n";
        $str .= "           array(  \"success\" => true, \n";
        $str .= "                   \"message\" => \$this->t['deleteRecordTextLabel'], \n";
        $str .= "                   \"time\"=>\$time)); \n";
        $str .= "       exit(); \n";
        $str .= "	} \n";

        $str .= "     /** \n";
        $str .= "     * To Update flag Status \n";
        $str .= "     */ \n";
        $str .= "     function updateStatus() { \n";
        $str .= "           header('Content-Type:application/json; charset=utf-8'); \n";
        $str .= "		\$start = microtime(true); \n";
        $str .= "           \$sqlLooping=null;\n";

        $str .= "		\$this->q->start(); \n";
        $str .= "		\$loop = intval(\$this->model->getTotal()); \n";
        $str .= "       \$sql=null;\n";

        $str .= "               \$sql = \" \n";
        $str .= "               UPDATE " . strtoupper($data [0] ['tableName']) . " \n";
        $str .= "               SET	   EXECUTEBY		=	'\".\$this->model->getExecuteBy().\"',\n";
        $str .= "					   EXECUTETIME		=	\".\$this->model->getExecuteTime().\",\";\n";

        // starting updating the flag
        $str .= "       if(\$_SESSION) { \n";
        $str .= "           if(\$_SESSION['isAdmin']==1) { \n";
        $systemFlag = array(
            'isDefault',
            'isDraft',
            'isNew',
            'isActive',
            'isUpdate',
            'isDelete',
            'isReview',
            'isPost',
            'isApproved'
        );
        foreach ($systemFlag as $systemCheck) {
            $str .= "                 if (\$this->model->get" . ucfirst($systemCheck) . "Total() > 0) {\n";

            $str .= "                         \$sqlLooping .= \" " . strtoupper($systemCheck) . " = CASE " . strtoupper($data [0] ['tableName']) . ".\".strtoupper(\$this->model->getPrimaryKeyName()) . \" \"; \n";

            $str .= "                     for (\$i = 0; \$i < \$loop; \$i++) {\n";
            $str .= "                         \$sqlLooping .= \"\n";
            $str .= "                         WHEN \" . \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(\$i, 'array') . \"\n";
            $str .= "                         THEN \" . \$this->model->get" . ucfirst($systemCheck) . "(\$i, 'array') . \"\";\n";
            $str .= "                     }\n";
            $str .= "                         \$sqlLooping .= \" ELSE " . strtoupper($systemCheck) . " END,\";\n";
            $str .= "			} \n";
        }
        $str .= "             } else { \n";
        $str .= "                 if (\$this->model->getIsDeleteTotal() > 0) {\n";
        $str .= "                         \$sqlLooping .= \" ISDELETE = CASE " . strtoupper($data [0] ['tableName']) . ".\".strtoupper(\$this->model->getPrimaryKeyName()) . \" \"; \n";

        $str .= "                     for (\$i = 0; \$i < \$loop; \$i++) {\n";
        $str .= "                         \$sqlLooping .= \"\n";
        $str .= "                         WHEN \" . \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(\$i, 'array') . \"\n";
        $str .= "                         THEN \" . \$this->model->getIsDelete(\$i, 'array') . \" \";\n";
        $str .= "                     }\n";

        $str .= "                         \$sqlLooping .= \" ELSE ISDELETE END,\";\n";


        $str .= "                         \$sqlLooping .= \" ISACTIVE = CASE " . strtoupper($data [0] ['tableName']) . ".\".strtoupper(\$this->model->getPrimaryKeyName()) . \" \"; \n";

        $str .= "                     for (\$i = 0; \$i < \$loop; \$i++) {\n";
        $str .= "                         if(\$this->model->getIsDelete(\$i, 'array') ==0 || \$this->model->getIsDelete(\$i, 'array')==false) {\n";
        $str .= "                         	\$isActive=1;\n";
        $str .= "                         } else {\n";
        $str .= "                         	\$isActive=0;\n";
        $str .= "                         } \n";
        $str .= "                         \$sqlLooping .= \"\n";
        $str .= "                         WHEN \" . \$this->model->get" . ucfirst($data [0] ['primaryKeyName']) . "(\$i, 'array') . \"\n";
        $str .= "                         THEN \" . \$isActive . \" \";\n";
        $str .= "                     }\n";

        $str .= "                         \$sqlLooping .= \" ELSE ISACTIVE END,\";\n";

        $str .= "				} \n";
        $str .= "               }\n";
        $str .= "           }\n";
        $str .= "           \$sql .= substr(\$sqlLooping, 0, - 1);\n";

        $str .= "               \$sql .= \" \n";
        $str .= "               WHERE \" . strtoupper(\$this->model->getPrimaryKeyName()) . \"  IN (\" . \$this->model->getPrimaryKeyAll() . \")\"; \n";
        $
                $str .= "       \$this->q->setPrimaryKeyAll(\$this->model->getPrimaryKeyAll());\n";
        $str .= "       \$this->q->setMultiId(1);\n";
        $str .= "       try {\n";
        $str .= "           \$this->q->update(\$sql);\n";
        $str .= "       } catch (\\Exception \$e) {\n";
        $str .= "           \$this->q->rollback();\n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "           exit();\n";
        $str .= "       }\n";
        $str .= "		\$this->q->commit(); \n";
        $str .= "		if (\$this->getIsAdmin()) { \n";
        $str .= "               \$message = \$this->t['updateRecordTextLabel']; \n";
        $str .= "		} else {\n";
        $str .= "               \$message = \$this->t['deleteRecordTextLabel']; \n";
        $str .= "		} \n";
        $str .= "		\$end = microtime(true); \n";
        $str .= "		\$time = \$end - \$start; \n";
        $str .= "		echo json_encode( \n";
        $str .= "               array(  \"success\" =>  true, \n";
        $str .= "                       \"message\" =>  \$message, \n";
        $str .= "                       \"time\"    =>  \$time) \n";
        $str .= "           ); \n";
        $str .= "       exit(); \n";
        $str .= "	} \n";

        $str .= "	/** \n";
        $str .= "	 * To check if a key duplicate or not \n";
        $str .= "	 */ \n";
        $str .= "	function duplicate() {\n";
        $str .= "       header('Content-Type:application/json; charset=utf-8'); \n";
        $str .= "       \$start = microtime(true);\n";

        $str .= "           \$sql = \" \n";
        $str .= "               SELECT  " . strtoupper($data [0] ['tableName'] . "Code") . " as \\\"" . $data [0] ['tableName'] . "Code\\\" \n";
        $str .= "               FROM    " . strtoupper($data [0] ['tableName']) . " \n";
        $str .= "               WHERE   " . strtoupper($data [0] ['tableName']) . "CODE	= 	'\" . \$this->model->get" . ucfirst($data [0] ['tableName']) . "Code() . \"' \n";
        $str .= "               AND     ISACTIVE    =   1 \n";
        $str .= "               AND     COMPANYID   =   '\".\$this->getCompanyId().\"'\"; \n";
        $str .= "       try {\n";
        $str .= "           \$this->q->read(\$sql);\n";
        $str .= "       } catch (\\Exception \$e) {\n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "           exit();\n";
        $str .= "       }\n";
        $str .= "       \$total = intval(\$this->q->numberRows()); \n";

        $str .= "       if (\$total > 0) { \n";
        $str .= "           \$row = \$this->q->fetchArray(); \n";
        $str .= "           \$end = microtime(true); \n";
        $str .= "           \$time = \$end - \$start; \n";
        $str .= "           echo json_encode(\n";
        $str .= "               array(  \"success\" =>true, \n";
        $str .= "                       \"total\" => \$total, \n";
        $str .= "                       \"message\" => \$this->t['duplicateMessageLabel'],  \n";
        $str .= "                       \"" . strtoupper($data [0] ['tableName']) . "Code\" => \$row ['" . strtoupper($data [0] ['tableName']) . "Code'], \n";
        $str .= "                       \"time\"=>\$time)); \n";
        $str .= "           exit(); \n";
        $str .= "       } else { \n";
        $str .= "           \$end = microtime(true); \n";
        $str .= "           \$time = \$end - \$start; \n";
        $str .= "           echo json_encode( \n";
        $str .= "               array(  \"success\" => true, \n";
        $str .= "                       \"total\" => \$total,  \n";
        $str .= "                       \"message\" => \$this->t['duplicateNotMessageLabel'], \n";
        $str .= "                       \"time\"=>\$time)); \n";
        $str .= "           exit(); \n";
        $str .= "       } \n";
        $str .= "	} \n";

        $str .= "   /**\n";
        $str .= "   * First Record\n";
        $str .= "   * @param string \$value . This return data type. When call by normal read.Value=='value'.When requested by ajax request button Value=='json'\n";
        $str .= "   * @return int\n";
        $str .= "   * @throws \Exception\n";
        $str .= "   */\n";
        $str .= "   function firstRecord(\$value) {\n";
        $str .= "       return \$this->recordSet->firstRecord(\$value);\n";
        $str .= "   }\n";

        $str .= "   /**\n";
        $str .= "   * Next Record\n";
        $str .= "   * @param string \$value . This return data type. When call by normal read.Value=='value'.When requested by ajax request button Value=='json'\n";
        $str .= "   * @param int \$primaryKeyValue Current  Primary Key Value\n";
        $str .= "   * @return int\n";
        $str .= "   * @throws \Exception\n";
        $str .= "   */\n";
        $str .= "   function nextRecord(\$value, \$primaryKeyValue) {\n";
        $str .= "       return \$this->recordSet->nextRecord(\$value, \$primaryKeyValue);\n";
        $str .= "   }\n";
        $str .= "   /**\n";

        $str .= "   * Previous Record\n";
        $str .= "   * @param string \$value . This return data type. When call by normal read.Value=='value'.When requested by ajax request button Value=='json'\n";
        $str .= "   * @param int \$primaryKeyValue\n";
        $str .= "   * @return int\n";
        $str .= "   * @throws \Exception\n";
        $str .= "   */\n";
        $str .= "   function previousRecord(\$value, \$primaryKeyValue) {\n";
        $str .= "       return \$this->recordSet->previousRecord(\$value, \$primaryKeyValue);\n";
        $str .= "   }\n";

        $str .= "   /**\n";
        $str .= "   * Last Record\n";
        $str .= "   * @param string \$value . This return data type. When call by normal read.Value=='value'.When requested by ajax request button Value=='json'\n";
        $str .= "   * @return int\n";
        $str .= "   * @throws \Exception\n";
        $str .= "   */\n";
        $str .= "   function lastRecord(\$value) {\n";
        $str .= "       return \$this->recordSet->lastRecord(\$value);\n";
        $str .= "   }\n";
        // reset service
        for ($i = 0; $i < $total; $i++) {
            if ($data [$i] ['foreignKey'] == 1 && $data [$i] ['Key'] == 'MUL') {
                if ($data[$i]['columnName'] != 'companyId') {
                    $service = 1;
                    break;
                }
            }
        }
        if ($service == 1) {
            $str .= "  /**\n";
            $str .= "   * Set Service\n";
            $str .= "   * @param string \$service . Reset service either option,html,table\n";
            $str .= "   * @return mixed\n";
            $str .= "   */\n";
            $str .= "   function setService(\$service) {\n";
            $str .= "       return \$this->service->setServiceOutput(\$service);\n";
            $str .= "   }\n";
        }
        for ($i = 0; $i < $total; $i++) {
            if ($data [$i] ['foreignKey'] == 1 && $data [$i] ['Key'] == 'MUL') {
                if ($data[$i]['columnName'] != 'companyId') {

                    // we only can assumed it was the same package and module otherwise
                    // manual change
                    $str .= "	/** \n";
                    $str .= "	 * Return  " . ucfirst(str_replace("Id", "", $data [$i] ['columnName'])) . " \n";
                    $str .= "    * @return null|string\n";
                    $str .= "	 */\n";
                    $str .= "	public function get" . ucfirst(str_replace("Id", "", $data [$i] ['columnName'])) . "() { \n";
                    $str .= "       \$this->service->setServiceOutput(\$this->getServiceOutput());\n";
                    $str .= "		return \$this->service->get" . ucfirst(str_replace("Id", "", $data [$i] ['columnName'])) . "();  \n";
                    $str .= "	}\n";
                }
            }
        }

        $str .= "  /**\n";
        $str .= "   * Return Total Record Of The  \n";
        $str .= "   * return int Total Record\n";
        $str .= "   */\n";
        $str .= " private function  getTotalRecord() {\n";
        $str .= "   \$sql=null;\n";
        $str .= "   \$total=0;\n";

        $str .= "         \$sql=\"\n";
        $str .= "         SELECT    COUNT(*)    AS  \\\"total\\\" \n";
        $str .= "         FROM      " . strtoupper($data[0]['tableName']) . "\n";
        $str .= "         WHERE     ISACTIVE    =   1\n";
        $str .= "         AND       COMPANYID   =   \" . \$this->getCompanyId() . \" \";\n";
        if (isset($dataTabDetail) && count($dataTabDetail) > 0) {
            $str .= " \$sql.=\"AND     " . strtoupper($dataTabDetail[0]['primaryKeyName']) . " = \".\$this->model->get" . ucfirst($dataTabDetail[0]['primaryKeyName']) . "().\" \"; \n";
        }
        $str .= "       try {\n";
        $str .= "           \$result= \$this->q->fast(\$sql);\n";
        $str .= "       } catch (\\Exception \$e) {\n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "           exit();\n";
        $str .= "       }\n";
        $str .= "         if(\$result) {\n";
        $str .= "             if(\$this->q->numberRows(\$result) > 0 ) {\n";
        $str .= "             \$row = \$this->q->fetchArray(\$result); \n";
        $str .= "                 \$total =\$row['total'];\n";
        $str .= "             }\n";
        $str .= "         } ";
        $str .= "         return \$total;\n";
        $str .= "   }\n";
        $str .= "	/** \n";
        $str .= "	 * Reporting\n";
        $str .= "	 * @see config::excel() \n";
        $str .= "	 */\n";
        $str .= "	function excel() { \n";
        $str .= "       header('Content-Type:application/json; charset=utf-8'); \n";
        $str .= "       \$start = microtime(true); \n";
        $str .= "       if (\$_SESSION ['start'] == 0) { \n";
        $str .= "           \$sql = str_replace(\$_SESSION ['start'] . \",\" . \$_SESSION ['limit'], \"\", str_replace(\"LIMIT\", \"\", \$_SESSION ['sql'])); \n";
        $str .= "       } else { \n";
        $str .= "           \$sql = \$_SESSION ['sql']; \n";
        $str .= "       } \n";
        $str .= "       try {\n";
        $str .= "           \$this->q->read(\$sql);\n";
        $str .= "       } catch (\\Exception \$e) {\n";
        $str .= "           echo json_encode(array(\"success\" => false, \"message\" => \$e->getMessage()));\n";
        $str .= "           exit();\n";
        $str .= "       }\n";
        // basic properties of the report
        // initialize dummy value...
        $str .= "       \$username =null; \n";
        $str .= "       if(isset(\$_SESSION['username'])) { \n";
        $str .= "           \$username=\$_SESSION['username']; \n";
        $str .= "       } else {  \n";
        $str .= "           \$username='Who the fuck are you'; \n";
        $str .= "       } \n";
        // this optional also
        // $str .= "\$locale = null;\n";
        // $str .= "\$locale = 'ru';\n";
        // $str .= "\$validLocale = \\PHPExcel_Settings::setLocale(\$locale);\n";
        // $str .= "if (!\$validLocale) { \n";
        // $str .= "	echo \"Unable to set locale to \".\$locale.\" - reverting to en_us<br />\n\"; \n";
        //  $str .= "}\n";

        $str .= "       \$this->excel->getProperties() \n";
        $str .= "                   ->setCreator(\$username) \n";
        $str .= "                   ->setLastModifiedBy(\$username) \n";
        $str .= "                   ->setTitle(\$this->getReportTitle()) \n";
        $str .= "                   ->setSubject('" . $data [0] ['tableName'] . "')\n";
        $str .= "                   ->setDescription('Generated by PhpExcel an Idcms Generator') \n";
        $str .= "                   ->setKeywords('office 2007 openxml php') \n";
        $str .= "                   ->setCategory('" . $data [0] ['package'] . "/" . $data [0] ['module'] . "'); \n";

        $str .= "        \$this->excel->setActiveSheetIndex(0); \n";
        $str .= "       // check file exist or not and return response \n";
        $str .= "       \$styleThinBlackBorderOutline = array('borders' => array('inside' => array('style' => \\PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000')), 'outline' => array('style' => \\PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '000000')))); \n";
        $str .= "       // header all using  3 line  starting b \n";
        // set range
        // first need to knew what is the last character.
        // initialize dummy value
        $characterArray = array();
        foreach (range('A', 'Z') as $character) {
            $characterArray [] = $character;
        }

        $c = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= 1) {
                if ($data [$i] ['columnName'] != 'isDefault' && $data [$i] ['columnName'] != 'isNew' && $data [$i] ['columnName'] != 'isDraft' && $data [$i] ['columnName'] != 'isUpdate' && $data [$i] ['columnName'] != 'isDelete' && $data [$i] ['columnName'] != 'isActive' && $data [$i] ['columnName'] != 'isApproved' && $data [$i] ['columnName'] != 'isReview' && $data [$i] ['columnName'] != 'isPost' && $data [$i] ['columnName'] != 'isSlice' && $data [$i] ['columnName'] != 'isConsolidation' && $data [$i] ['columnName'] != 'isReconciled') {
                    $c++;
                }
            }
        }

        // echo "last character is ".$lastCharacter."\n";

        $characterStart = 'B';
        $characterEnd = $characterArray [$c];
        foreach (range($characterStart, $characterEnd) as $character) {
            $str .= "        \$this->excel->getActiveSheet()->getColumnDimension('" . $character . "')->setAutoSize(TRUE); \n";
        }
        $str .= "        \$this->excel->getActiveSheet()->setCellValue('B2',\$this->getReportTitle()); \n";
        $str .= "        \$this->excel->getActiveSheet()->setCellValue('" . $characterEnd . "2', ''); \n";
        $str .= "        \$this->excel->getActiveSheet()->mergeCells('B2:" . $characterEnd . "2'); \n";
        // looping field
        $str .= "        \$this->excel->getActiveSheet()->setCellValue('B3', 'No.'); \n";
        $n = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($i >= 1) {
                if ($data [$i] ['columnName'] != 'companyId' && $data [$i] ['columnName'] != 'isDefault' && $data [$i] ['columnName'] != 'isNew' && $data [$i] ['columnName'] != 'isDraft' && $data [$i] ['columnName'] != 'isUpdate' && $data [$i] ['columnName'] != 'isDelete' && $data [$i] ['columnName'] != 'isActive' && $data [$i] ['columnName'] != 'isApproved' && $data [$i] ['columnName'] != 'isReview' && $data [$i] ['columnName'] != 'isPost' && $data [$i] ['columnName'] != 'isSlice' && $data [$i] ['columnName'] != 'isConsolidation' && $data [$i] ['columnName'] != 'isReconciled') {
                    $n++;
                    $str .= "        \$this->excel->getActiveSheet()->setCellValue('" . $characterArray [$n + 1] . "3', \$this->translate['" . $data[$i]['columnName'] . "Label']); \n";
                }
            }
        }

        $str .= "		// \n";
        $str .= "        \$loopRow = 4; \n";
        $str .= "        \$i = 0; \n";
        $str .= "        \\PHPExcel_Cell::setValueBinder( new \\PHPExcel_Cell_AdvancedValueBinder() );\n";
        $str .= "        \$lastRow=null;\n";
        $str .= "        while ((\$row = \$this->q->fetchAssoc()) == TRUE) { \n";
        $str .= "           //	echo print_r(\$row); \n";
        $str .= "           \$this->excel->getActiveSheet()->setCellValue('B' . \$loopRow, ++\$i); \n";
        // looping field
        $z = 0;

        for ($i = 0; $i < $total; $i++) {
            if ($i > 1) {
                if ($data [$i] ['columnName'] == 'executeBy') {
                    $z++;
                    $str .= "           \$this->excel->getActiveSheet()->setCellValue('" . $characterArray [$z + 1] . "' . \$loopRow,  strip_tags( \$row ['staffName'])); \n";
                } else if ($data [$i] ['columnName'] == 'executeTime') {
                    $z++;

                    $str .= "           \$this->excel->getActiveSheet()->setCellValue('" . $characterArray [$z + 1] . "' . \$loopRow,   strip_tags(\$row ['" . $data [$i] ['columnName'] . "'])); \n";

                    $str .= "           \$this->excel->getActiveSheet()->getStyle()->getNumberFormat('" . $characterArray [$z + 1] . "' . \$loopRow)->setFormatCode(\\PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);  \n";
                } else if ($data [$i] ['columnName'] != 'isDefault' && $data [$i] ['columnName'] != 'isNew' && $data [$i] ['columnName'] != 'isDraft' && $data [$i] ['columnName'] != 'isUpdate' && $data [$i] ['columnName'] != 'isDelete' && $data [$i] ['columnName'] != 'isActive' && $data [$i] ['columnName'] != 'isApproved' && $data [$i] ['columnName'] != 'isReview' && $data [$i] ['columnName'] != 'isPost' && $data [$i] ['columnName'] != 'isSlice' && $data [$i] ['columnName'] != 'isConsolidation' && $data [$i] ['columnName'] != 'isReconciled') {
                    $z++;
                    switch ($data [$i] ['field']) {
                        case 'date' :
                        case 'datetime' :
                            $str .= "           \$this->excel->getActiveSheet()->getStyle()->getNumberFormat('" . $characterArray [$z + 1] . "' . \$loopRow)->setFormatCode(\\PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);  \n";
                            $str .= "           \$this->excel->getActiveSheet()->setCellValue('" . $characterArray [$z + 1] . "' . \$loopRow,   strip_tags(\$row ['" . $data [$i] ['columnName'] . "'])); \n";
                            break;
                        case 'int' :
                            if ($data[$i]['Key'] == 'MUL') {
                                if ($data[$i]['columnName'] != 'companyId') {
                                    //exception for some cases
                                    if ($data[$i]['columnName'] == 'businessPartnerId') {
                                        $field = str_replace("Id", "", $data[$i]['columnName']) . "Company";
                                    } else if ($data[$i]['columnName'] == 'employeeId') {
                                        $field = str_replace("Id", "", $data[$i]['columnName']) . "FirstName";
                                    } else if ($data[$i]['columnName'] == 'staffId') {
                                        $field = str_replace("Id", "", $data[$i]['columnName']) . "Name";
                                    } else if ($data[$i]['columnName'] == 'chartOfAccountId') {
                                        $field = str_replace("Id", "", $data[$i]['columnName']) . "Title";
                                    } else if ($data[$i]['columnName'] == 'assetId') {
                                        $field = str_replace("Id", "", $data[$i]['columnName']) . "Name";
                                    } else {
                                        $field = str_replace("Id", "", $data[$i]['columnName']) . "Description";
                                    }
                                    $str .= "           \$this->excel->getActiveSheet()->setCellValue('" . $characterArray [$z + 1] . "' . \$loopRow,   strip_tags(\$row ['" . $field . "'])); \n";
                                }
                            } else {
                                $str .= "           \$this->excel->getActiveSheet()->getStyle()->getNumberFormat('" . $characterArray [$z + 1] . "' . \$loopRow)->setFormatCode(\\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);  \n";
                                $str .= "           \$this->excel->getActiveSheet()->setCellValue('" . $characterArray [$z + 1] . "' . \$loopRow,   strip_tags(\$row ['" . $data [$i] ['columnName'] . "'])); \n";
                            }
                            break;
                        case 'double' :
                        case 'float' :
                            $str .= "           \$this->excel->getActiveSheet()->getStyle()->getNumberFormat('" . $characterArray [$z + 1] . "' . \$loopRow)->setFormatCode(\\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);  \n";
                            $str .= "           \$this->excel->getActiveSheet()->setCellValue('" . $characterArray [$z + 1] . "' . \$loopRow,   strip_tags(\$row ['" . $data [$i] ['columnName'] . "'])); \n";
                            break;
                        default :
                            $str .= "           \$this->excel->getActiveSheet()->setCellValue('" . $characterArray [$z + 1] . "' . \$loopRow,   strip_tags(\$row ['" . $data [$i] ['columnName'] . "'])); \n";
                    }
                }
            }
        }
        $str .= "           \$loopRow++; \n";
        $str .= "           \$lastRow = '" . $characterEnd . "' . \$loopRow;\n";
        $str .= "        } \n";
        $str .= "        \$from = 'B2'; \n";
        $str .= "        \$to = \$lastRow; \n";
        $str .= "        \$formula = \$from . \":\" . \$to;\n";
        $str .= "        \$this->excel->getActiveSheet()->getStyle(\$formula)->applyFromArray(\$styleThinBlackBorderOutline);\n";
        $str .= "        \$extension=null; ";
        $str .= "        \$folder=null; ";
        $str .= "        switch(\$this->getReportMode()) { \n";

        $str .= "           case 'excel':\n";
        $str .= "               //	\$objWriter = \\PHPExcel_IOFactory::createWriter(\$this->excel, 'Excel2007');\n";
        $str .= "               //optional lock.on request only\n";
        $str .= "               // \$objPHPExcel->getSecurity()->setLockWindows(true);\n";
        $str .= "               // \$objPHPExcel->getSecurity()->setLockStructure(true);\n";
        $str .= "               // \$objPHPExcel->getSecurity()->setWorkbookPassword('PHPExcel');\n";
        $str .= "               \$objWriter = new \\PHPExcel_Writer_Excel2007(\$this->excel); \n";
        $str .= "               \$extension='.xlsx';\n";
        $str .= "               \$folder='excel';\n";
        $str .= "               \$filename = \"" . $data [0] ['tableName'] . "\" . rand(0, 10000000) . \$extension;\n";
        $str .= "               \$path = \$this->getFakeDocumentRoot() . \"v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/document/\".\$folder.\"/\" . \$filename;\n";
        $str .= "               \$this->documentTrail->createTrail(\$this->getLeafId(), \$path,\$filename);\n";
        $str .= "               \$objWriter->save(\$path);\n";
        $str .= "               \$file = fopen(\$path, 'r');\n";
        $str .= "               if (\$file) { \n";
        $str .= "                   \$end = microtime(true);\n";
        $str .= "                   \$time = \$end - \$start;\n";
        $str .= "                   echo json_encode(\n";
        $str .= "                       array(  \"success\" => true, \n";
        $str .= "                               \"message\" => \$this->t['fileGenerateMessageLabel'], \n";
        $str .= "                               \"filename\" => \$filename,\n";
        $str .= "                               \"folder\" => \$folder,\n";
        $str .= "                               \"time\"=>\$time));\n";
        $str .= "			            exit(); \n";
        $str .= "               } else { \n";
        $str .= "                   \$end = microtime(true);\n";
        $str .= "                   \$time = \$end - \$start;\n";
        $str .= "                   echo json_encode(\n";
        $str .= "                   array(	\"success\" => false,\n";
        $str .= "                           \"message\" => \$this->t['fileNotGenerateMessageLabel'],\n";
        $str .= "                           \"time\"=>\$time));\n";
        $str .= "			        exit(); \n";
        $str .= "               } \n";
        $str .= "           break;\n";

        $str .= "           case 'excel5':\n";
        $str .= "               \$objWriter = new \\PHPExcel_Writer_Excel5(\$this->excel); \n";
        $str .= "               \$extension='.xls';\n";
        $str .= "               \$folder='excel';\n";
        $str .= "               \$filename = \"" . $data [0] ['tableName'] . "\" . rand(0, 10000000) . \$extension;\n";
        $str .= "               \$path = \$this->getFakeDocumentRoot() . \"v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/document/\".\$folder.\"/\" . \$filename;\n";
        $str .= "               \$this->documentTrail->createTrail(\$this->getLeafId(), \$path,\$filename);\n";
        $str .= "               \$objWriter->save(\$path);\n";
        $str .= "               \$file = fopen(\$path, 'r');\n";
        $str .= "               if (\$file) { \n";
        $str .= "                   \$end = microtime(true);\n";
        $str .= "                   \$time = \$end - \$start;\n";
        $str .= "                   echo json_encode(\n";
        $str .= "                       array(  \"success\" => true, \n";
        $str .= "                               \"message\" => \$this->t['fileGenerateMessageLabel'], \n";
        $str .= "                               \"filename\" => \$filename,\n";
        $str .= "                               \"folder\" => \$folder,\n";
        $str .= "                               \"time\"=>\$time));\n";
        $str .= "			        exit(); \n";
        $str .= "               } else { \n";
        $str .= "                   \$end = microtime(true);\n";
        $str .= "                   \$time = \$end - \$start;\n";
        $str .= "                   echo json_encode(\n";
        $str .= "                       array(	\"success\" => false,\n";
        $str .= "                               \"message\" => \$this->t['fileNotGenerateMessageLabel'],\n";
        $str .= "                               \"time\"=>\$time));\n";
        $str .= "			            exit(); \n";
        $str .= "               } \n";
        $str .= "           break;\n";

        $str .= "           case 'pdf':\n";
        // denied as inconsistent driver
        /*
          $str .= "               \$objWriter = new \\PHPExcel_Writer_PDF(\$this->excel); \n";
          $str .= "               \$objWriter->writeAllSheets();\n"; // write all sheet
          $str .= "               \$extension='.pdf';\n";
          // optional one page \$objWriter->setSheetIndex(0);
          $str .= "               \$folder='pdf';\n";
          $str .= "               \$filename = \"" . $data [0] ['tableName'] . "\" . rand(0, 10000000) . \$extension;\n";
          $str .= "               \$path = \$this->getFakeDocumentRoot() . \"v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/document/\".\$folder.\"/\" . \$filename;\n";
          // $str.=" \$this->documentTrail->create_trail(\$this->leafId, \$path,
          // \$filename);\n";
          $str .= "               \$objWriter->save(\$path);\n";
          $str .= "               \$file = fopen(\$path, 'r');\n";
          $str .= "               if (\$file) { \n";
          $str .= "                   \$end = microtime(true);\n";
          $str .= "                   \$time = \$end - \$start;\n";
          $str .= "                   echo json_encode(\n";
          $str .= "                       array(  \"success\" => true, \n";
          $str .= "                               \"message\" => \$this->t['fileGenerateMessageLabel'], \n";
          $str .= "                               \"filename\" => \$filename,\n";
          $str .= "                               \"folder\" => \$folder,\n";
          $str .= "                               \"time\"=>\$time));\n";
          $str .= "			        exit(); \n";
          $str .= "               } else { \n";
          $str .= "                   \$end = microtime(true);\n";
          $str .= "                   \$time = \$end - \$start;\n";
          $str .= "                   echo json_encode(\n";
          $str .= "                       array(	\"success\" => false,\n";
          $str .= "                               \"message\" => \$this->t['fileNotGenerateMessageLabel'],\n";
          $str .= "                                \"time\"=>\$time));\n";
          $str .= "			            exit(); \n";
          $str .= "               } \n";
         */
        $str .= "           break;\n";

        $str .= "           case 'html':\n";
        $str .= "               \$objWriter = new \\PHPExcel_Writer_HTML(\$this->excel); \n";
        $str .= "               // \$objWriter->setUseBOM(true); \n";
        $str .= "               \$extension='.html';\n";
        // if requre calculation put below
        $str .= "               //\$objWriter->setPreCalculateFormulas(false); //calculation off \n";
        $str .= "               \$folder='html';\n";
        $str .= "               \$filename = \"" . $data [0] ['tableName'] . "\" . rand(0, 10000000) . \$extension;\n";
        $str .= "               \$path = \$this->getFakeDocumentRoot() . \"v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/document/\".\$folder.\"/\" . \$filename;\n";
        $str .= "               \$this->documentTrail->createTrail(\$this->getLeafId(), \$path,\$filename);\n";
        $str .= "               \$objWriter->save(\$path);\n";
        $str .= "               \$file = fopen(\$path, 'r');\n";
        $str .= "               if (\$file) { \n";
        $str .= "                   \$end = microtime(true);\n";
        $str .= "                   \$time = \$end - \$start;\n";
        $str .= "                   echo json_encode(\n";
        $str .= "                    array( \"success\" => true, \n";
        $str .= "                            \"message\" => \$this->t['fileGenerateMessageLabel'], \n";
        $str .= "                           \"filename\" => \$filename,\n";
        $str .= "                           \"folder\" => \$folder,\n";
        $str .= "                           \"time\"=>\$time));\n";
        $str .= "			        exit(); \n";
        $str .= "               } else { \n";
        $str .= "                   \$end = microtime(true);\n";
        $str .= "                   \$time = \$end - \$start;\n";
        $str .= "                   echo json_encode(\n";
        $str .= "                       array(	\"success\" => false,\n";
        $str .= "                               \"message\" => \$this->t['fileNotGenerateMessageLabel'],\n";
        $str .= "                               \"time\"=>\$time));\n";
        $str .= "			            exit(); \n";
        $str .= "               } \n";
        $str .= "           break;\n";

        $str .= "           case 'csv': \n";
        $str .= "               \$objWriter = new \\PHPExcel_Writer_CSV(\$this->excel); \n";
        $str .= "               // \$objWriter->setUseBOM(true); \n";
        $str .= "               // \$objWriter->setPreCalculateFormulas(false); //calculation off \n";
        $str .= "               \$extension='.csv';\n";
        $str .= "               \$folder='excel';\n";
        $str .= "               \$filename = \"" . $data [0] ['tableName'] . "\" . rand(0, 10000000) . \$extension;\n";
        $str .= "               \$path = \$this->getFakeDocumentRoot() . \"v3/" . $data [0] ['package'] . "/" . $data [0] ['module'] . "/document/\".\$folder.\"/\" . \$filename;\n";
        $str .= "               \$this->documentTrail->createTrail(\$this->getLeafId(), \$path,\$filename);\n";
        $str .= "               \$objWriter->save(\$path);\n";
        $str .= "               \$file = fopen(\$path, 'r');\n";
        $str .= "               if (\$file) { \n";
        $str .= "                   \$end = microtime(true);\n";
        $str .= "                   \$time = \$end - \$start;\n";
        $str .= "                   echo json_encode(\n";
        $str .= "                       array(  \"success\" => true, \n";
        $str .= "                               \"message\" => \$this->t['fileGenerateMessageLabel'], \n";
        $str .= "                               \"filename\" => \$filename,\n";
        $str .= "                               \"folder\" => \$folder,\n";
        $str .= "                               \"time\"=>\$time));\n";
        $str .= "			        exit(); \n";
        $str .= "               } else { \n";
        $str .= "                   \$end = microtime(true);\n";
        $str .= "                   \$time = \$end - \$start;\n";
        $str .= "                   echo json_encode(\n";
        $str .= "                       array(	\"success\" => false,\n";
        $str .= "                               \"message\" => \$this->t['fileNotGenerateMessageLabel'],\n";
        $str .= "                               \"time\"=>\$time));\n";
        $str .= "			                exit(); \n";
        $str .= "               } \n";
        $str .= "           break;\n";

        $str .= "       } \n";


        $str .= "     } \n";
        $str .= "} \n";


        $str .= "if (isset(\$_POST ['method'])) { \n";
        $str .= "    if(isset(\$_POST['output'])) {  \n";
        $str .= "   \$" . $data [0] ['tableName'] . "Object = new " . ucfirst($data [0] ['tableName']) . "Class (); \n";
        $str .= "	if(\$_POST['securityToken'] != \$" . $data [0] ['tableName'] . "Object->getSecurityToken()) {\n";
        $str .= "		header('Content-Type:application/json; charset=utf-8');\n";
        $str .= "		echo json_encode(array(\"success\"=>false,\"message\"=>\"Something wrong with the system.Hola hackers\"));\n";
        $str .= "		exit();\n";
        $str .= "	}\n";
        $str .= "	/* \n";
        $str .= "	 *  Load the dynamic value \n";
        $str .= "	 */ \n";
        $str .= "	if (isset(\$_POST ['leafId'])) {\n";
        $str .= "		\$" . $data [0] ['tableName'] . "Object->setLeafId(\$_POST ['leafId']); \n";
        $str .= "	} \n";
        $str .= "	if (isset(\$_POST ['offset'])) {\n";
        $str .= "		\$" . $data [0] ['tableName'] . "Object->setStart(\$_POST ['offset']); \n";
        $str .= "	} \n";
        $str .= "	if (isset(\$_POST ['limit'])) {\n";
        $str .= "		\$" . $data [0] ['tableName'] . "Object->setLimit(\$_POST ['limit']); \n";
        $str .= "	} \n";

        $str .= "	\$" . $data [0] ['tableName'] . "Object ->setPageOutput(\$_POST['output']);  \n";
        $str .= "	\$" . $data [0] ['tableName'] . "Object->execute(); \n";
        $str .= "	/* \n";
        $str .= "	 *  Crud Operation (Create Read Update Delete/Destroy) \n";
        $str .= "	 */ \n";
        $str .= "	if (\$_POST ['method'] == 'create') { \n";
        $str .= "		\$" . $data [0] ['tableName'] . "Object->create(); \n";
        $str .= "	} \n";
        $str .= "	if (\$_POST ['method'] == 'save') { \n";
        $str .= "		\$" . $data [0] ['tableName'] . "Object->update(); \n";
        $str .= "	} \n";
        $str .= "	if (\$_POST ['method'] == 'read') { \n";
        $str .= "		\$" . $data [0] ['tableName'] . "Object->read(); \n";
        $str .= "	} \n";
        $str .= "	if (\$_POST ['method'] == 'delete') { \n";
        $str .= "		\$" . $data [0] ['tableName'] . "Object->delete(); \n";
        $str .= "	} \n";
        $str .= "	if (\$_POST ['method'] == 'posting') { \n";
        $str .= "	//	\$" . $data [0] ['tableName'] . "Object->posting(); \n";
        $str .= "	} \n";
        $str .= "	if (\$_POST ['method'] == 'reverse') { \n";
        $str .= "	//	\$" . $data [0] ['tableName'] . "Object->delete(); \n";
        $str .= "	} \n";
        $str .= "} } \n";
        $str .= "if (isset(\$_GET ['method'])) {\n";
        $str .= "   \$" . $data [0] ['tableName'] . "Object = new " . ucfirst($data [0] ['tableName']) . "Class (); \n";
        $str .= "	if(\$_GET['securityToken'] != \$" . $data [0] ['tableName'] . "Object->getSecurityToken()) {\n";
        $str .= "		header('Content-Type:application/json; charset=utf-8');\n";
        $str .= "		echo json_encode(array(\"success\"=>false,\"message\"=>\"Something wrong with the system.Hola hackers\"));\n";
        $str .= "		exit();\n";
        $str .= "	}\n";
        $str .= "	/* \n";
        $str .= "	 *  initialize Value before load in the loader\n";
        $str .= "	 */ \n";
        $str .= "	if (isset(\$_GET ['leafId'])) {\n";
        $str .= "       \$" . $data [0] ['tableName'] . "Object->setLeafId(\$_GET ['leafId']); \n";
        $str .= "	} \n";

        $str .= "	/*\n";
        $str .= "	 *  Load the dynamic value\n";
        $str .= "	 */ \n";
        $str .= "	\$" . $data [0] ['tableName'] . "Object->execute(); \n";
        $str .= "	/*\n";
        $str .= "	 * Update Status of The Table. Admin Level Only \n";
        $str .= "	 */\n";
        $str .= "	if (\$_GET ['method'] == 'updateStatus') { \n";
        $str .= "       \$" . $data [0] ['tableName'] . "Object->updateStatus(); \n";
        $str .= "	} \n";
        $str .= "	/* \n";
        $str .= "	 *  Checking Any Duplication  Key \n";
        $str .= "	 */ \n";
        $str .= "	if (\$_GET['method'] == 'duplicate') { \n";
        $str .= "   	\$" . $data [0] ['tableName'] . "Object->duplicate(); \n";
        $str .= "	} \n";
        $str .= "	if (\$_GET ['method'] == 'dataNavigationRequest') { \n";
        $str .= "       if (\$_GET ['dataNavigation'] == 'firstRecord') { \n";
        $str .= "           \$" . $data [0] ['tableName'] . "Object->firstRecord('json'); \n";
        $str .= "       } \n";
        $str .= "       if (\$_GET ['dataNavigation'] == 'previousRecord') { \n";
        $str .= "           \$" . $data [0] ['tableName'] . "Object->previousRecord('json', 0); \n";
        $str .= "       } \n";
        $str .= "       if (\$_GET ['dataNavigation'] == 'nextRecord') {\n";
        $str .= "           \$" . $data [0] ['tableName'] . "Object->nextRecord('json', 0); \n";
        $str .= "       } \n";
        $str .= "       if (\$_GET ['dataNavigation'] == 'lastRecord') {\n";
        $str .= "           \$" . $data [0] ['tableName'] . "Object->lastRecord('json'); \n";
        $str .= "       } \n";
        $str .= "	} \n";
        $str .= "	/* \n";
        $str .= "	 * Excel Reporting  \n";
        $str .= "	 */ \n";
        $str .= "	if (isset(\$_GET ['mode'])) { \n";
        $str .= "       \$" . $data [0] ['tableName'] . "Object->setReportMode(\$_GET['mode']); \n";
        $str .= "       if (\$_GET ['mode'] == 'excel'
            ||  \$_GET ['mode'] == 'pdf'
			||  \$_GET['mode']=='csv'
			||  \$_GET['mode']=='html'
			||	\$_GET['mode']=='excel5'
			||  \$_GET['mode']=='xml') { \n";
        $str .= "			\$" . $data [0] ['tableName'] . "Object->excel(); \n";
        $str .= "		} \n";
        $str .= "	} \n";
        // foreign key
        if ($foreignKeyYes == 1) {
            $str .= "	if (isset(\$_GET ['filter'])) { \n";
            $str .= "       \$" . $data [0] ['tableName'] . "Object->setServiceOutput('option');\n";
            for ($i = 0; $i < $total; $i++) {
                if ($data [$i] ['foreignKey'] == 1 && $data [$i] ['Key'] == 'MUL') {
                    // we only can assumed it was the same package and module otherwise
                    // manual change
                    if ($data [$i] ['columnName'] != 'companyId') {

                        $str .= "       if((\$_GET['filter']=='" . (str_replace("Id", "", $data [$i] ['columnName'])) . "')) { \n";
                        $str .= "           \$" . $data [0] ['tableName'] . "Object->get" . ucfirst(str_replace("Id", "", $data [$i] ['columnName'])) . "(); \n";
                        $str .= "       }\n";
                    }
                }
            }
            $str .= "   }\n";
        }
        $str .= "} \n";
        $str .= "?>\n";
    }
}

?>
