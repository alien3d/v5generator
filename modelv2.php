<?php
function modelSourceCode($data) {
if (isset($data) && is_array($data)) {
    // think this more accurate
    $total = 0;
    $total = count($data);
    for ($i = 0; $i < $total; $i++) {
        if ($data[$i]['Key'] == 'PRI') {
            $data[0]['tableName'] = str_replace('Id', '', $data[0]['columnName']);
        }
    }
    $str .= "<?php  namespace Core\\" . ucwords($data[0]['package']) . "\\" . ucwords($data[0]['module']) . "\\" . ucwords($data[0]['tableName']) . "\\Model;\n";
    $str .= " use Core\\Validation\\ValidationClass;\n";
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
    $str .= "require_once (\$newFakeDocumentRoot.\"library/class/classValidation.php\"); \n";

    $str .= "/** \n";
    $str .= " * Class " . ucfirst($data[0]['tableName']) . "\n";
    $str .= " * This is " . ($data[0]['tableName']) . " model file.This is to ensure strict setting enable for all variable enter to database \n";
    $str .= " * \n";
    $str .= " * @name IDCMS.\n";
    $str .= " * @version 2\n";
    $str .= " * @author hafizan\n";
    $str .= " * @package Core\\" . ucwords($data[0]['package']) . "\\" . ucwords($data[0]['module']) . "\\" . ucwords($data[0]['tableName']) . "\\Model;\n";
    $str .= " * @subpackage " . (ucwords($data[0]['module'])) . " \n";
    $str .= " * @link http://www.hafizan.com\n";
    $str .= " * @license http://www.gnu.org/copyleft/lesser.html LGPL\n";
    $str .= " */\n";
    $str .= "class " . ucfirst($data[0]['tableName']) . "Model extends ValidationClass { \n";


    for ($i = 0; $i < $total; $i++) {

        if ($data[$i]['columnName'] != 'isDefault' &&
                $data[$i]['columnName'] != 'isNew' &&
                $data[$i]['columnName'] != 'isDraft' &&
                $data[$i]['columnName'] != 'isUpdate' &&
                $data[$i]['columnName'] != 'isDelete' &&
                $data[$i]['columnName'] != 'isActive' &&
                $data[$i]['columnName'] != 'isApproved' &&
                $data[$i]['columnName'] != 'isReview' &&
                $data[$i]['columnName'] != 'isPost' &&
                $data[$i]['columnName'] != 'executeBy' &&
                $data[$i]['columnName'] != 'executeTime'
        ) {
            $x = str_replace($data[0]['tableName'], '', $data[$i]['columnName']);
            if ($x == 'Desc') {
                $x = "Description";
            } else if ($x == 'Id') {
                $x = "Primary Key";
            } else {
                $findMe = 'Id';
                $pos = strpos($x, $findMe);
                // mostly it was a foreign key
                if ($pos !== false) {
                    $x = ucfirst(str_replace("Id", "", $x));
                } else {
                    
                }
            }
            $str .= " /**\n";
            $str .= "  * " . checkString($x) . "\n";
            $str .= "  * @var " . $data[$i]['field'] . " \n";
            $str .= "  */\n";
            $str .= "  private \$" . $data[$i]['columnName'] . "; \n";
        }
    }
    $str .= " /**\n";
    $str .= "  * Class Loader\n";
    $str .= "  * @see ValidationClass::execute()\n";
    $str .= "  */\n";
    $str .= " public function execute() {\n";
    $str .= "     /**\n";
    $str .= "     *  Basic Information Table\n";
    $str .= "     **/\n";

    $str .= "     \$this->setTableName('" . $data[0]['tableName'] . "');\n";
    for ($i = 0; $i < $total; $i++) {
        if ($data[$i]['Key'] == 'PRI') {
            $str .= "     \$this->setPrimaryKeyName('" . $data[$i]['columnName'] . "');\n";
            $str .= "     \$this->setMasterForeignKeyName('" . $data[$i]['columnName'] . "');\n";
        }
    }
    $str .= "     \$this->setFilterCharacter('" . $data[0]['tableName'] . "Description');\n";
    $str .= "     //\$this->setFilterCharacter('" . $data[0]['tableName'] . "Note');\n";
    $str .= "     \$this->setFilterDate('executeTime');\n";
    $str .= "     /**\n";
    $str .= "     * All the \$_POST Environment\n";
    $str .= "     */ \n";
    for ($i = 0; $i < $total; $i++) {

        if ($data[$i]['columnName'] != 'isDefault' &&
                $data[$i]['columnName'] != 'isNew' &&
                $data[$i]['columnName'] != 'isDraft' &&
                $data[$i]['columnName'] != 'isUpdate' &&
                $data[$i]['columnName'] != 'isDelete' &&
                $data[$i]['columnName'] != 'isActive' &&
                $data[$i]['columnName'] != 'isApproved' &&
                $data[$i]['columnName'] != 'isReview' &&
                $data[$i]['columnName'] != 'isPost' &&
                $data[$i]['columnName'] != 'executeBy' &&
                $data[$i]['columnName'] != 'executeTime'
        ) {
            if ($data[$i]['Key'] == 'PRI') {
                $str .= "     if (isset(\$_POST ['" . $data[$i]['columnName'] . "'])) { \n ";
                $str .= "         \$this->set" . ucfirst($data[$i]['columnName']) . "(\$this->strict(\$_POST ['" . $data[$i]['columnName'] . "'], '" . $data[$i]['field'] . "'), 0, 'single'); \n ";
                $str .= "     } \n ";
            } else {
                $str .= "     if (isset(\$_POST ['" . $data[$i]['columnName'] . "'])) { \n ";
                $str .= "         \$this->set" . ucfirst($data[$i]['columnName']) . "(\$this->strict(\$_POST ['" . $data[$i]['columnName'] . "'], '" . $data[$i]['field'] . "')); \n ";
                $str .= "     } \n ";
            }
        }
    }


    $str .= "     /**\n";
    $str .= "     * All the \$_GET Environment\n";
    $str .= "     */\n";
    for ($i = 0; $i < $total; $i++) {

        if ($data[$i]['columnName'] != 'isDefault' &&
                $data[$i]['columnName'] != 'isNew' &&
                $data[$i]['columnName'] != 'isDraft' &&
                $data[$i]['columnName'] != 'isUpdate' &&
                $data[$i]['columnName'] != 'isDelete' &&
                $data[$i]['columnName'] != 'isActive' &&
                $data[$i]['columnName'] != 'isApproved' &&
                $data[$i]['columnName'] != 'isReview' &&
                $data[$i]['columnName'] != 'isPost' &&
                $data[$i]['columnName'] != 'executeBy' &&
                $data[$i]['columnName'] != 'executeTime'
        ) {
            if ($data[$i]['Key'] == 'PRI') {
                $str .= "     if (isset(\$_GET ['" . $data[$i]['columnName'] . "'])) { \n ";
                $str .= "         \$this->set" . ucfirst($data[$i]['columnName']) . "(\$this->strict(\$_GET ['" . $data[$i]['columnName'] . "'], '" . $data[$i]['field'] . "'), 0, 'single'); \n ";
                $str .= "     } \n ";
            } else {
                $str .= "     if (isset(\$_GET ['" . $data[$i]['columnName'] . "'])) { \n ";
                $str .= "         \$this->set" . ucfirst($data[$i]['columnName']) . "(\$this->strict(\$_GET ['" . $data[$i]['columnName'] . "'], '" . $data[$i]['field'] . "')); \n ";
                $str .= "     } \n ";
            }
        }
    }
    for ($i = 0; $i < $total; $i++) {
    
            $str .= "     if (isset(\$_GET ['" . $data[$i]['columnName'] . "'])) {\n";
			    if ($data[$i]['Key'] == 'PRI') {
            $str .= "         \$this->setTotal(count(\$_GET ['" . $data[$i]['columnName'] . "']));\n";
			}
            $str .= "         if (is_array(\$_GET ['" . $data[$i]['columnName'] . "'])) {\n";
            $str .= "             \$this->" . $data[$i]['columnName'] . " = array();\n";
            $str .= "         }\n";
            $str .= "	}\n";
        
    }

    $str .= "	if (isset(\$_GET ['isDefault'])) {\n";
    $str .= "         \$this->setIsDefaultTotal(count(\$_GET['isDefault']));\n";
    $str .= "         if (is_array(\$_GET ['isDefault'])) {\n";
    $str .= "             \$this->isDefault = array();\n";
    $str .= "         }\n";
    $str .= "     }\n";
    $str .= "     if (isset(\$_GET ['isNew'])) {\n";
    $str .= "         \$this->setIsNewTotal(count(\$_GET['isNew']));\n";
    $str .= "         if (is_array(\$_GET ['isNew'])) {\n";
    $str .= "             \$this->isNew = array();\n";
    $str .= "         }\n";
    $str .= "	}\n";
    $str .= "	if (isset(\$_GET ['isDraft'])) {\n";
    $str .= "         \$this->setIsDraftTotal(count(\$_GET['isDraft']));\n";
    $str .= "         if (is_array(\$_GET ['isDraft'])) {\n";
    $str .= "             \$this->isDraft = array();\n";
    $str .= "         }\n";
    $str .= "	}\n";
    $str .= "	if (isset(\$_GET ['isUpdate'])) {\n";
    $str .= "         \$this->setIsUpdateTotal(count(\$_GET['isUpdate']));\n";
    $str .= "         if (is_array(\$_GET ['isUpdate'])) {\n";
    $str .= "             \$this->isUpdate = array();\n";
    $str .= "         }\n";
    $str .= "	}\n";
    $str .= "	if (isset(\$_GET ['isDelete'])) {\n";
    $str .= "         \$this->setIsDeleteTotal(count(\$_GET['isDelete']));\n";
    $str .= "         if (is_array(\$_GET ['isDelete'])) {\n";
    $str .= "             \$this->isDelete = array();\n";
    $str .= "         }\n";
    $str .= "	}\n";
    $str .= "	if (isset(\$_GET ['isActive'])) {\n";
    $str .= "         \$this->setIsActiveTotal(count(\$_GET['isActive']));\n";
    $str .= "         if (is_array(\$_GET ['isActive'])) {\n";
    $str .= "             \$this->isActive = array();\n";
    $str .= "         }\n";
    $str .= "	}\n";
    $str .= "	if (isset(\$_GET ['isApproved'])) {\n";
    $str .= "         \$this->setIsApprovedTotal(count(\$_GET['isApproved']));\n";
    $str .= "         if (is_array(\$_GET ['isApproved'])) {\n";
    $str .= "             \$this->isApproved = array();\n";
    $str .= "         }\n";
    $str .= "	}\n";
    $str .= "	if (isset(\$_GET ['isReview'])) {\n";
    $str .= "         \$this->setIsReviewTotal(count(\$_GET['isReview']));\n";
    $str .= "         if (is_array(\$_GET ['isReview'])) {\n";
    $str .= "             \$this->isReview = array();\n";
    $str .= "         }\n";
    $str .= "	}\n";
    $str .= "	if (isset(\$_GET ['isPost'])) {\n";
    $str .= "         \$this->setIsPostTotal(count(\$_GET['isPost']));\n";
    $str .= "         if (is_array(\$_GET ['isPost'])) {\n";
    $str .= "             \$this->isPost = array();\n";
    $str .= "         }\n";
    $str .= "	}\n";
    $str .= "	\$primaryKeyAll = '';\n";
    $str .= "	for (\$i = 0; \$i < \$this->getTotal(); \$i++) {\n";
    $str .= "         if (isset(\$_GET ['" . $data[0]['primaryKeyName'] . "'])) {\n";
    $str .= "             \$this->set" . ucfirst($data[0]['primaryKeyName']) . "(\$this->strict(\$_GET ['" . $data[0]['primaryKeyName'] . "'] [\$i], 'numeric'), \$i, 'array');\n";
    $str .= "         }\n";

    $str .= "         if (isset(\$_GET ['isDefault'])) {\n";
    $str .= "             if (\$_GET ['isDefault'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsDefault(1, \$i, 'array');\n";
    $str .= "             } else if (\$_GET ['isDefault'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsDefault(0, \$i, 'array');\n";
    $str .= "		}\n";
    $str .= "         }\n";
    $str .= "         if (isset(\$_GET ['isNew'])) {\n";
    $str .= "             if (\$_GET ['isNew'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsNew(1, \$i, 'array');\n";
    $str .= "		} else if (\$_GET ['isNew'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsNew(0, \$i, 'array');\n";
    $str .= "             }\n";
    $str .= "         }\n";
    $str .= "         if (isset(\$_GET ['isDraft'])) {\n";
    $str .= "             if (\$_GET ['isDraft'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsDraft(1, \$i, 'array');\n";
    $str .= "             } else if (\$_GET ['isDraft'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsDraft(0, \$i, 'array');\n";
    $str .= "             }\n";
    $str .= "         }\n";
    $str .= "         if (isset(\$_GET ['isUpdate'])) {\n";
    $str .= "             if (\$_GET ['isUpdate'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsUpdate(1, \$i, 'array');\n";
    $str .= "             } if (\$_GET ['isUpdate'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsUpdate(0, \$i, 'array');\n";
    $str .= "             }\n";
    $str .= "         }\n";
    $str .= "         if (isset(\$_GET ['isDelete'])) {\n";
    $str .= "             if (\$_GET ['isDelete'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsDelete(1, \$i, 'array');\n";
    $str .= "             } else if (\$_GET ['isDelete'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsDelete(0, \$i, 'array');\n";
    $str .= "             }\n";
    $str .= "         }\n";
    $str .= "         if (isset(\$_GET ['isActive'])) {\n";
    $str .= "             if (\$_GET ['isActive'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsActive(1, \$i, 'array');\n";
    $str .= "             } else if (\$_GET ['isActive'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsActive(0, \$i, 'array');\n";
    $str .= "             }\n";
    $str .= "         }\n";
    $str .= "         if (isset(\$_GET ['isApproved'])) {\n";
    $str .= "             if (\$_GET ['isApproved'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsApproved(1, \$i, 'array');\n";
    $str .= "             } else if (\$_GET ['isApproved'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsApproved(0, \$i, 'array');\n";
    $str .= "             } \n";
    $str .= "         } \n";
    $str .= "         if (isset(\$_GET ['isReview'])) {\n";
    $str .= "             if (\$_GET ['isReview'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsReview(1, \$i, 'array');\n";
    $str .= "             } else if (\$_GET ['isReview'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsReview(0, \$i, 'array');\n";
    $str .= "             }\n";
    $str .= "         }\n";
    $str .= "         if (isset(\$_GET ['isPost'])) {\n";
    $str .= "             if (\$_GET ['isPost'] [\$i] == 'true') {\n";
    $str .= "                 \$this->setIsPost(1, \$i, 'array');\n";
    $str .= "             } else if (\$_GET ['isPost'] [\$i] == 'false') {\n";
    $str .= "                 \$this->setIsPost(0, \$i, 'array');\n";
    $str .= "             }\n";
    $str .= "         }\n";
    $str .= "         \$primaryKeyAll .= \$this->get" . ucfirst($data[0]['primaryKeyName']) . "(\$i, 'array') . \",\";\n";
    $str .= "     }\n";
    $str .= "     \$this->setPrimaryKeyAll((substr(\$primaryKeyAll, 0, - 1)));\n";
    $str .= "    /**\n";
    $str .= "     * All the \$_SESSION Environment\n";
    $str .= "     */\n";
    $str .= "     if (isset(\$_SESSION ['staffId'])) {\n";
    $str .= "         \$this->setExecuteBy(\$_SESSION ['staffId']);\n";
    $str .= "     }\n";
    $str .= "    /**\n";
    $str .= "     * TimeStamp Value.\n";
    $str .= "     */\n";
    $str .= "     if (\$this->getVendor() == self::MYSQL) {\n";
    $str .= "         \$this->setExecuteTime(\"'\" . date(\"Y-m-d H:i:s\") . \"'\");\n";
    $str .= "     } else if (\$this->getVendor() == self::MSSQL) {\n";
    $str .= "         \$this->setExecuteTime(\"'\" . date(\"Y-m-d H:i:s.u\") . \"'\");\n";
    $str .= "     } else if (\$this->getVendor() == self::ORACLE) {\n";
    $str .= "         \$this->setExecuteTime(\"to_date('\" . date(\"Y-m-d H:i:s\") . \"','YYYY-MM-DD HH24:MI:SS')\");\n";
    $str .= "     }\n";
    $str .= " }\n";


    $str .= "    /**\n";
    $str .= "     * Create\n";
    $str .= "     * @see ValidationClass::create()\n";
    $str .= "     * @return void\n";
    $str .= "     */ \n";

    $str .= "     public function create() {\n";
    $str .= "         \$this->setIsDefault(0, 0, 'single');\n";
    $str .= "         \$this->setIsNew(1, 0, 'single');\n";
    $str .= "         \$this->setIsDraft(0, 0, 'single');\n";
    $str .= "         \$this->setIsUpdate(0, 0, 'single');\n";
    $str .= "         \$this->setIsActive(1, 0, 'single');\n";
    $str .= "         \$this->setIsDelete(0, 0, 'single');\n";
    $str .= "         \$this->setIsApproved(0, 0, 'single');\n";
    $str .= "         \$this->setIsReview(0, 0, 'single');\n";
    $str .= "         \$this->setIsPost(0, 0, 'single');\n";
    $str .= "	} \n";

    $str .= "    /**\n";
    $str .= "     * Update\n";
    $str .= "     * @see ValidationClass::update()\n";
    $str .= "     * @return void\n";
    $str .= "     */\n";

    $str .= "     public function update() {\n";
    $str .= "         \$this->setIsDefault(0, 0, 'single');\n";
    $str .= "         \$this->setIsNew(0, 0, 'single');\n";
    $str .= "         \$this->setIsDraft(0, 0, 'single');\n";
    $str .= "         \$this->setIsUpdate(1, '', 'single');\n";
    $str .= "         \$this->setIsActive(1, 0, 'single');\n";
    $str .= "         \$this->setIsDelete(0, 0, 'single');\n";
    $str .= "         \$this->setIsApproved(0, 0, 'single');\n";
    $str .= "         \$this->setIsReview(0, 0, 'single');\n";
    $str .= "         \$this->setIsPost(0, 0, 'single');\n";
    $str .= "	}\n";

    $str .= "    /** \n";
    $str .= "     * Delete\n";
    $str .= "     * @see ValidationClass::delete()\n";
    $str .= "     * @return void\n";
    $str .= "     */\n";

    $str .= "	public function delete() {\n";
    $str .= "         \$this->setIsDefault(0, 0, 'single');\n";
    $str .= "         \$this->setIsNew(0, 0, 'single');\n";
    $str .= "         \$this->setIsDraft(0, 0, 'single');\n";
    $str .= "         \$this->setIsUpdate(0, 0, 'single');\n";
    $str .= "         \$this->setIsActive(0, '', 'single');\n";
    $str .= "         \$this->setIsDelete(1, '', 'single');\n";
    $str .= "         \$this->setIsApproved(0, 0, 'single');\n";
    $str .= "         \$this->setIsReview(0, 0, 'single');\n";
    $str .= "         \$this->setIsPost(0, 0, 'single');\n";
    $str .= "	} \n";

    $str .= "    /**\n";
    $str .= "     * Draft\n";
    $str .= "     * @see ValidationClass::draft()\n";
    $str .= "     * @return void\n";
    $str .= "     */\n";

    $str .= "	public function draft() {\n";
    $str .= "		\$this->setIsDefault(0, 0, 'single');\n";
    $str .= "		\$this->setIsNew(1, 0, 'single');\n";
    $str .= "		\$this->setIsDraft(1, 0, 'single');\n";
    $str .= "		\$this->setIsUpdate(0, 0, 'single');\n";
    $str .= "		\$this->setIsActive(0, 0, 'single');\n";
    $str .= "		\$this->setIsDelete(0, 0, 'single');\n";
    $str .= "		\$this->setIsApproved(0, 0, 'single');\n";
    $str .= "		\$this->setIsReview(0, 0, 'single');\n";
    $str .= "		\$this->setIsPost(0, 0, 'single');\n";
    $str .= "	}\n";

    $str .= "    /**\n";
    $str .= "     * Approved\n";
    $str .= "     * @see ValidationClass::approved()\n";
    $str .= "     * @return void\n";
    $str .= "     */\n";

    $str .= "	public function approved() {\n";
    $str .= "         \$this->setIsDefault(0, 0, 'single');\n";
    $str .= "         \$this->setIsNew(1, 0, 'single');\n";
    $str .= "         \$this->setIsDraft(0, 0, 'single');\n";
    $str .= "         \$this->setIsUpdate(0, 0, 'single');\n";
    $str .= "         \$this->setIsActive(0, 0, 'single');\n";
    $str .= "         \$this->setIsDelete(0, 0, 'single');\n";
    $str .= "         \$this->setIsApproved(1, 0, 'single');\n";
    $str .= "         \$this->setIsReview(0, 0, 'single');\n";
    $str .= "         \$this->setIsPost(0, 0, 'single');\n";
    $str .= "	}\n";

    $str .= "    /**\n";
    $str .= "     * Review\n";
    $str .= "     * @see ValidationClass::review()\n";
    $str .= "     * @return void\n";
    $str .= "     */\n";

    $str .= "     public function review() { \n";
    $str .= "         \$this->setIsDefault(0, 0, 'single');\n";
    $str .= "         \$this->setIsNew(1, 0, 'single');\n";
    $str .= "         \$this->setIsDraft(0, 0, 'single');\n";
    $str .= "         \$this->setIsUpdate(0, 0, 'single');\n";
    $str .= "         \$this->setIsActive(0, 0, 'single');\n";
    $str .= "         \$this->setIsDelete(0, 0, 'single');\n";
    $str .= "         \$this->setIsApproved(0, 0, 'single');\n";
    $str .= "         \$this->setIsReview(1, 0, 'single');\n";
    $str .= "         \$this->setIsPost(0, 0, 'single');\n";
    $str .= "	} \n";

    $str .= "    /**\n";
    $str .= "     * Post\n";
    $str .= "     * @see ValidationClass::post()\n";
    $str .= "     * @return void\n";
    $str .= "     */\n";

    $str .= "     public function post() {\n";
    $str .= "         \$this->setIsDefault(0, 0, 'single');\n";
    $str .= "         \$this->setIsNew(1, 0, 'single');\n";
    $str .= "         \$this->setIsDraft(0, 0, 'single');\n";
    $str .= "         \$this->setIsUpdate(0, 0, 'single');\n";
    $str .= "         \$this->setIsActive(0, 0, 'single');\n";
    $str .= "         \$this->setIsDelete(0, 0, 'single');\n";
    $str .= "         \$this->setIsApproved(1, 0, 'single');\n";
    $str .= "         \$this->setIsReview(0, 0, 'single');\n";
    $str .= "         \$this->setIsPost(1, 0, 'single');\n";
    $str .= "	}\n";

    for ($i = 0; $i < $total; $i++) {
        if ($data[$i]['Key'] == 'PRI') {
            $str .= "     /** \n";
            $str .= "     * Set Primary Key Value \n";
            $str .= "     * @param int|array \$value \n";
            $str .= "     * @param array[int]int \$key List Of Primary Key. \n";
            $str .= "     * @param array[int]string \$type  List Of Type.0 As 'single' 1 As 'array' \n";
            $str .= "     * @return \\Core\\" . ucwords($data[0]['package']) . "\\" . ucwords($data[0]['module']) . "\\" . ucfirst($data[0]['tableName']) . "\\Model\\" . ucfirst($data[0]['tableName']) . "Model\n";
            $str .= "     */ \n";
            $str .= "     public function set" . ucfirst($data[$i]['columnName']) . "(\$value, \$key, \$type) { \n";
            $str .= "        if (\$type == 'single') { \n";
            $str .= "           \$this->" . $data[$i]['columnName'] . " = \$value;\n";
            $str .= "           return \$this;\n";
            $str .= "        } else if (\$type == 'array') {\n";
            $str .= "            \$this->" . $data[$i]['columnName'] . "[\$key] = \$value;\n";
            $str .= "           return \$this;\n";
            $str .= "        } else {\n";
            $str .= "            echo json_encode(array(\"success\" => false, \"message\" => \"Cannot Identify Type String Or Array:set" . ucfirst($data[$i]['columnName']) . "?\"));\n";
            $str .= "            exit(); \n";
            $str .= "        }\n";
            $str .= "    }\n";

            $str .= "    /**\n";
            $str .= "     * Return Primary Key Value\n";
            $str .= "     * @param array[int]int \$key List Of Primary Key.\n";
            $str .= "     * @param array[int]string \$type  List Of Type.0 As 'single' 1 As 'array'\n";
            $str .= "     * @return bool|array|string\n";
            $str .= "     */\n";
            $str .= "    public function get" . ucfirst($data[$i]['columnName']) . "(\$key, \$type) {\n";
            $str .= "        if (\$type == 'single') {\n";
            $str .= "            return \$this->" . $data[$i]['columnName'] . ";\n";
            $str .= "        } else if (\$type == 'array') {\n";
            $str .= "            return \$this->" . $data[$i]['columnName'] . " [\$key];\n";
            $str .= "        } else {\n";
            $str .= "            echo json_encode(array(\"success\" => false, \"message\" => \"Cannot Identify Type String Or Array:get" . ucfirst($data[$i]['columnName']) . " ?\"));\n";
            $str .= "            exit();\n";
            $str .= "        }\n";
            $str .= "	}\n";
        } else if ($data[$i]['columnName'] != 'isDefault' &&
                $data[$i]['columnName'] != 'isNew' &&
                $data[$i]['columnName'] != 'isDraft' &&
                $data[$i]['columnName'] != 'isUpdate' &&
                $data[$i]['columnName'] != 'isDelete' &&
                $data[$i]['columnName'] != 'isActive' &&
                $data[$i]['columnName'] != 'isApproved' &&
                $data[$i]['columnName'] != 'isReview' &&
                $data[$i]['columnName'] != 'isPost' &&
                $data[$i]['columnName'] != 'executeBy' &&
                $data[$i]['columnName'] != 'executeTime' &&
                $data[$i]['columnName'] != $data[0]['primaryKeyName']
        ) {
            $y = str_replace($data[0]['tableName'], '', $data[$i]['columnName']);
            $findMe = 'Id';
            $pos = strpos($y, $findMe);
            // mostly it was a foreign key
            if ($pos !== false) {
                $y = ucfirst(str_replace("Id", "", $y));
            }
            if ($y == 'Desc') {
                $y = 'Description';
            }
            // $y = $this->checkString($y);
            $str .= "	/**\n";
            $str .= "	 * To Return " . checkString(str_replace($data[0]['tableName'], "", str_replace("Id", "", $data[$i]['columnName']))) . " \n";
            $str .= "	 * @return " . $data[$i]['field'] . " \$" . $data[$i]['columnName'] . "\n";
            $str .= "	 */ \n";
            $str .= "	public function get" . ucfirst($data[$i]['columnName']) . "()\n";
            $str .= "	{\n";
            $str .= "	    return \$this->" . $data[$i]['columnName'] . ";\n";
            $str .= "	}\n";

            $str .= "	/**\n";
            $str .= "	 * To Set " . checkString(str_replace($data[0]['tableName'], "", str_replace("Id", "", $data[$i]['columnName']))) . " \n";
            $str .= "	 * @param " . $data[$i]['field'] . " \$" . $data[$i]['columnName'] . " " . checkString(str_replace($data[0]['tableName'], "", str_replace("Id", "", $data[$i]['columnName']))) . " \n";
            $str .= "	 * @return \\Core\\" . ucwords($data[0]['package']) . "\\" . ucwords($data[0]['module']) . "\\" . ucfirst($data[0]['tableName']) . "\\Model\\" . ucfirst($data[0]['tableName']) . "Model\n";
            $str .= "	 */\n";
            $str .= "	public function set" . ucfirst($data[$i]['columnName']) . "(\$" . $data[$i]['columnName'] . ")\n";
            $str .= "	{\n";
            $str .= "         \$this->" . $data[$i]['columnName'] . " = \$" . $data[$i]['columnName'] . ";\n";
            $str .= "         return \$this;\n";
            $str .= "	} \n";
        }
    }
    $str .= "}\n";
    $str .= "?>";
}
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