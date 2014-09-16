<?php

function html($data, $dataTabDetail = null,$targetMaxRecordTab=5) {
    if (!$dataTabDetail) {
        $dataTabDetail = array();
    }
    $tabCounter = count($dataTabDetail);
    $checkbox = false;
    $total = 0;
    if (isset($data) && is_array($data)) {
        $total = intval(count($data));
        $foreignKeyYes = null;
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['columnName'] != 'companyId') {
                if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                    $foreignKeyYes = 1;
                    break;
                }
            }
        }
        $str .= "<link rel=\"stylesheet\"  type=\"text/css\" href=\"css/bootstrap.min.css\" />\n";
        $str .= "<link rel=\"stylesheet\"  type=\"text/css\" href=\"css/smartadmin-production.css\" />\n";
        $str .= "<?php\n";

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

// using Absolute path instead of relative path..
        //$str.="<script type=\"text/javascript' src=\"./library/class/classShared.php?method=default\"></script>\n";
        // testing translation  and foreign key option load first.. so ajax request respond 1

        $str .= "require_once(\$newFakeDocumentRoot.\"v3/" . $data[0]['package'] . "/" . $data[0]['module'] . "/controller/" . $data[0]['tableName'] . "Controller.php\"); \n";
        if (isset($dataTabDetail) && count($dataTabDetail) > 0) {
            for ($j = 0; $j < $tabCounter; $j++) {
                if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                    $total = count($dataTabDetail[$j]);
                    for ($i = 0; $i < $total; $i++) {
                        if ($dataTabDetail[$j][$i]['Key'] == 'PRI') {
                            $dataTabDetail[$j][0]['tableName'] = str_replace("Id", "", $dataTabDetail[$j][0]['columnName']);
                        }
                    }
                    $str .= " require_once(\$newFakeDocumentRoot.\"v3/" . $data[0]['package'] . "/" . $data[0]['module'] . "/controller/" . $dataTabDetail[$j][0]['tableName'] . "Controller.php\"); \n";
                }
            }
        }
        $str .= " require_once (\$newFakeDocumentRoot.\"library/class/classNavigation.php\");  \n";
        $str .= " require_once (\$newFakeDocumentRoot.\"library/class/classShared.php\");  \n";

// initialize dummy value for date
        $str .= " require_once (\$newFakeDocumentRoot.\"library/class/classDate.php\");  \n";
        $str .= " \$dateConvert = new \\Core\\Date\\DateClass();\n";

        $str .= "\$dateRangeStart = null;\n";
        $str .= "if (isset(\$_POST['dateRangeStart'])) {\n";
        $str .= " \$dateRangeStart = \$_POST['dateRangeStart'];\n";
        $str .= " // some error handling to avoid error\n";
        $str .= " if (isset(\$_POST['dateRangeEnd'])) {\n";
        $str .= "     if (strlen(\$_POST['dateRangeEnd']) > 0) {\n";
        $str .= "         if (isset(\$_POST['dateRangeType'])) {\n";
        $str .= "             if (\$_POST['dateRangeType'] != 'between' && \$_POST['dateRangeType'] != 'week') {\n";
        $str .= "                 \$dateRangeStart = date('d-m-Y');\n";
        $str .= "                 \$_POST['dateRangeStart'] = date('d-m-Y');\n";
        $str .= "                 unset(\$_POST['dateRangeEnd']);\n";
        $str .= "             }\n";
        $str .= "         }\n";
        $str .= "     }\n";
        $str .= " }\n";
        $str .= "} else {\n";
        $str .= " \$dateRangeStart = date('d-m-Y');\n";
        $str .= " }\n";
        $str .= " //day\n";
        $str .= " \$previousDay   = \$dateConvert->getPreviousDate(\$dateRangeStart, 'day');\n";
        $str .= " \$nextDay       = \$dateConvert->getForwardDate(\$dateRangeStart, 'day');\n";
        $str .= " //week\n";
        $str .= " \$dateRangeStartPreviousWeek = \$dateConvert->getCurrentWeekInfo(\$dateRangeStart, 'previous');\n";
        $str .= " \$dateRangeStartPreviousWeekArray = explode(\">\", \$dateRangeStartPreviousWeek);\n";
        $str .= " \$dateRangeStartPreviousWeekStartDay = \$dateRangeStartPreviousWeekArray[0];\n";
        $str .= " \$dateRangeEndPreviousWeekEndDay = \$dateRangeStartPreviousWeekArray[1];\n";

        $str .= " \$dateRangeStartWeek = \$dateConvert->getCurrentWeekInfo(\$dateRangeStart, 'current');\n";
        $str .= " \$dateRangeStartWeekArray = explode(\">\", \$dateRangeStartWeek);\n";
        $str .= " \$dateRangeStartDay = \$dateRangeStartWeekArray[0];\n";
        $str .= " \$dateRangeEndDay = \$dateRangeStartWeekArray[1];\n";

        $str .= " \$dateRangeEndForwardWeek = \$dateConvert->getCurrentWeekInfo(\$dateRangeStart, 'forward');\n";
        $str .= " \$dateRangeEndForwardWeekArray = explode(\">\", \$dateRangeEndForwardWeek);\n";
        $str .= " \$dateRangeEndForwardWeekStartDay = \$dateRangeEndForwardWeekArray[0];\n";
        $str .= " \$dateRangeEndForwardWeekEndDay = \$dateRangeEndForwardWeekArray[1];\n";
        $str .= "//month\n";
        $str .= " \$previousMonth   = \$dateConvert->getPreviousDate(\$dateRangeStart, 'month');\n";
        $str .= " \$nextMonth       = \$dateConvert->getForwardDate(\$dateRangeStart, 'month');\n";
        $str .= "//year\n";
        $str .= " \$previousYear   = \$dateConvert->getPreviousDate(\$dateRangeStart, 'year');\n";
        $str .= " \$nextYear       = \$dateConvert->getForwardDate(\$dateRangeStart, 'year');\n";
        $str .= " \$translator = new \\Core\\shared\\SharedClass();   \n";
        $str .= " \$template = new \\Core\\shared\\SharedTemplate();  \n";
        $str .= " \$translator->setCurrentDatabase('" . $data[0]['database'] . "');   \n";
        if (isset($dataTabDetail) && count($dataTabDetail) > 0) {
            $str.="\$tableName[]='" . $data[0]['tableName'] . "';\n";
            for ($j = 0; $j < $tabCounter; $j++) {
                 $str.="\$tableName[]='" . $dataTabDetail[$j][0]['tableName'] . "';\n";
            }
            $str .= " \$translator->setCurrentTable(\$tableName); \n";
        } else {
            $str .= " \$translator->setCurrentTable('" . $data[0]['tableName'] . "'); \n";
        }
        //$str .= " \$translator->setFilename('" . $data[0]['tableName'] . ".php'); \n";
        $str .= " \$_POST['from']=\"" . $data[0]['tableName'] . ".php\";\n";
        $str .= " \$_GET['from']=\"" . $data[0]['tableName'] . ".php\";\n";
        $str .= " if (isset(\$_POST['leafId'])) {\n";
        $str .= " 	\$leafId = intval(\$_POST['leafId'] * 1);\n";
        $str .= " } else if (isset(\$_GET['leafId'])) {\n";
        $str .= " 	\$leafId = intval(\$_GET['leafId'] * 1);\n";
        $str .= " } else {\n";
        $str .= " 	// redirect to main page if no id\n";
        $str .= " 	header(\"index.php\");\n";
        $str .= " 	exit();\n";
        $str .= " }\n";
        $str .= " if (\$leafId === 0) {\n";
        $str .= " 	// might injection.cut off\n";
        $str .= " 	header(\"index.php\");\n";
        $str .= " 	exit();\n";
        $str .= " }\n";
        $str .= " \$translator->setLeafId(\$leafId);\n";
        $str .= " \$translator->execute();    \n";


        $str .= " \$securityToken = \$translator->getSecurityToken();\n";
        $str .= " \$arrayInfo         =   \$translator->getFileInfo(); \n";
        $str .= " \$applicationId     =   \$arrayInfo['applicationId']; \n";
        $str .= " \$moduleId          =   \$arrayInfo['moduleId']; \n";
        $str .= " \$folderId     =   \$arrayInfo['folderId']; //future if required \n";
        $str .= " \$leafId          =   \$arrayInfo['leafId']; \n";

        $str .= " \$applicationNative =   \$arrayInfo['applicationNative']; \n";
        $str .= " \$folderNative      =   \$arrayInfo['folderNative']; \n";
        $str .= " \$moduleNative      =   \$arrayInfo['moduleNative']; \n";
        $str .= " \$leafNative        =   \$arrayInfo['leafNative']; \n";
        $str .= " \$translator->createLeafBookmark('', '', '', \$leafId); \n";

        $str .= " \$systemFormat = \$translator->getSystemFormat();   \n";
        $str .= " \$t = \$translator->getDefaultTranslation(); // short because code too long  \n";
        $str .= " \$leafTranslation = \$translator->getLeafTranslation(); \n";
        $str .= " \$leafAccess = \$translator->getLeafAccess(); \n";
        $str .= "	\$" . $data[0]['tableName'] . "Array = array(); \n";
        if ($foreignKeyYes == 1) {

            for ($i = 0; $i < $total; $i++) {
                if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                    // we only can assumed it was the same package and module otherwise manual change
                    if ($data[$i]['columnName'] != 'companyId') {
                        $str .= "	\$" . str_replace("Id", "", $data[$i]['columnName']) . "Array = array();\n";
                    }
                }
            }
        }
        $str .= " if (isset(\$_POST)) {  \n";
        $str .= "    if (isset(\$_POST['method'])) {  \n";
        $str .= "        \$" . $data[0]['tableName'] . " = new \\Core\\" . ucwords($data[0]['package']) . "\\" . ucwords($data[0]['module']) . "\\" . ucwords($data[0]['tableName']) . "\\Controller\\";
        $str .= ucfirst($data[0]['tableName']);
        $str .= "Class();  \n";
        $str .= "     define('LIMIT',10);\n";
        $str .= "     if (isset(\$_POST['offset'])) {  \n";
        $str .= "         \$offset = \$_POST['offset'];  \n";
        $str .= "     } else {\n";
        $str .= "         \$offset = 0;  \n";
        $str .= "     }\n";
        $str .= "     if (isset(\$_POST['limit'])) {  \n";
        $str .= "         \$limit = \$_POST['limit'];  \n";
        $str .= "     } else {\n";
        $str .= "         \$limit = LIMIT;  \n";
        $str .= "     }\n";
        $str .= "     if (isset(\$_POST ['query'])) { \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setFieldQuery(\$_POST ['query']); \n";
        $str .= "     } \n";
        $str .= "     if (isset(\$_POST ['filter'])) { \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setGridQuery(\$_POST ['filter']); \n";
        $str .= "     }                 \n";
        $str .= "     if (isset(\$_POST ['character'])) { \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setCharacterQuery(\$_POST['character']); \n";
        $str .= "     } \n";
        $str .= "     if (isset(\$_POST ['dateRangeStart'])) { \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setDateRangeStartQuery(\$_POST['dateRangeStart']); \n";
        $str .= "         //explode the data to get day,month,year \n";
        $str .= "         \$start=explode('-',\$_POST ['dateRangeStart']); \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setStartDay(\$start[2]); \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setStartMonth(\$start[1]); \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setStartYear(\$start[0]); \n";
        $str .= "     } \n";
        $str .= "     if (isset(\$_POST ['dateRangeEnd']) && (strlen(\$_POST['dateRangeEnd'])> 0) ) { \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setDateRangeEndQuery(\$_POST['dateRangeEnd']); \n";
        $str .= "         //explode the data to get day,month,year \n";
        $str .= "         \$start=explode('-',\$_POST ['dateRangeEnd']); \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setEndDay(\$start[2]); \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setEndMonth(\$start[1]); \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setEndYear(\$start[0]); \n";
        $str .= "     } \n";
        $str .= "     if (isset(\$_POST ['dateRangeType'])) { \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setDateRangeTypeQuery(\$_POST['dateRangeType']); \n";
        $str .= "     } \n";
        $str .= "     if (isset(\$_POST ['dateRangeExtraType'])) { \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setDateRangeExtraTypeQuery(\$_POST['dateRangeExtraType']); \n";
        $str .= "     } \n";
        $str .= "     \$" . $data[0]['tableName'] . "->setServiceOutput('html');  \n";
        $str .= "     \$" . $data[0]['tableName'] . "->setLeafId(\$leafId);  \n";
        $str .= "     \$" . $data[0]['tableName'] . "->execute();  \n";

        if ($foreignKeyYes == 1) {

            for ($i = 0; $i < $total; $i++) {
                if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                    // we only can assumed it was the same package and module otherwise manual change
                    if ($data[$i]['columnName'] != 'companyId') {
                        $str .= "     \$" . str_replace("Id", "", $data[$i]['columnName']) . "Array = \$" . $data[0]['tableName'] . "->get" . ucfirst(str_replace("Id", "", $data[$i]['columnName'])) . "();\n";
                    }
                }
            }
        }
        $str .= "     if (\$_POST['method'] == 'read') {  \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setStart(\$offset);  \n";
        $str .= "         \$" . $data[0]['tableName'] . "->setLimit(\$limit); // normal system don't like paging..  \n";

        $str .= "         \$" . $data[0]['tableName'] . "->setPageOutput('html');  \n";
        $str .= "         \$" . $data[0]['tableName'] . "Array = \$" . $data[0]['tableName'] . "->read();  \n";
        $str .= "         if (isset(\$" . $data[0]['tableName'] . "Array [0]['firstRecord'])) {  \n";
        $str .= "         	\$firstRecord = \$" . $data[0]['tableName'] . "Array [0]['firstRecord'];  \n";
        $str .= "         }  \n";
        $str .= "         if (isset(\$" . $data[0]['tableName'] . "Array [0]['nextRecord'])) {  \n";
        $str .= "         	\$nextRecord = \$" . $data[0]['tableName'] . "Array [0]['nextRecord'];  \n";
        $str .= "         }   \n";
        $str .= "         if (isset(\$" . $data[0]['tableName'] . "Array [0]['previousRecord'])) {  \n";
        $str .= "             \$previousRecord = \$" . $data[0]['tableName'] . "Array [0]['previousRecord'];  \n";
        $str .= "         }   \n";
        $str .= "         if (isset(\$" . $data[0]['tableName'] . "Array [0]['lastRecord'])) {  \n";
        $str .= "             \$lastRecord = \$" . $data[0]['tableName'] . "Array [0]['lastRecord'];  \n";
        $str .= "         	\$endRecord = \$" . $data[0]['tableName'] . "Array [0]['lastRecord'];  \n";
        $str .= "         }   \n";
        $str .= "         \$navigation = new \\Core\\Paging\\HtmlPaging();  \n";
        $str .= "         \$navigation->setLeafId(\$leafId);  \n";
        $str .= "         \$navigation->setViewPath(\$" . $data[0]['tableName'] . "->getViewPath());  \n";
        $str .= "         \$navigation->setOffset(\$offset);  \n";
        $str .= "         \$navigation->setLimit(\$limit);  \n";
        $str .= "         \$navigation->setSecurityToken(\$securityToken);  \n";
        $str .= "         \$navigation->setLoadingText(\$t['loadingTextLabel']);  \n";
        $str .= "         \$navigation->setLoadingCompleteText(\$t['loadingCompleteTextLabel']);  \n";
        $str .= "         \$navigation->setLoadingErrorText(\$t['loadingErrorTextLabel']);  \n";
        $str .= "         if (isset(\$" . $data[0]['tableName'] . "Array [0]['total'])) {  \n";
        $str .= "         	\$total = \$" . $data[0]['tableName'] . "Array [0]['total'];  \n";
        $str .= "         } else {  \n";
        $str .= "         	\$total = 0;  \n";
        $str .= "         }  \n";
        $str .= "            \$navigation->setTotalRecord(\$total);  \n";
        $str .= "        }  \n";
        $str .= "    }  \n";
        $str .= " }  \n";

//start grid generation 
        $str .= "?><script type=\"text/javascript\">\n";
        // default translation
        $str .= " var t =<?php echo json_encode(\$translator->getDefaultTranslation()); ?>;\n";
        // leafTranslation
        $str .= " var leafTranslation =<?php echo json_encode(\$translator->getLeafTranslation()); ?>;\n";

        $str .= " </script><?php \n";
        $str .= " if(isset(\$_POST['method']) && isset(\$_POST['type'])) {\n ";
        $str .= " 	if (\$_POST['method'] == 'read' && \$_POST['type'] == 'list') { ?>\n";
        $str .= "	<div class=\"row\">\n";
        $str .= "		<div class=\"col-xs-12 col-sm-12 col-md-12\">\n";
        $str .= "         <?php   \$template->setLayout(1);\n";
        $str .= "                 echo \$template->breadcrumb(\$applicationNative, \$moduleNative, \$folderNative, \$leafNative,\$securityToken,\$applicationId,\$moduleId,\$folderId,\$leafId); ?>\n";
        $str .= "		</div>\n";
        $str .= " 	</div>\n";
        $str .= " 	<div id=\"infoErrorRowFluid\" class=\"row hidden\">\n";
        $str .= "		<div id=\"infoError\" class=\"col-xs-12 col-sm-12 col-md-12\">&nbsp;</div>\n";
        $str .= "	</div>\n";
        $str .= " <div id=\"content\" style=\"opacity: 1;\">\n";
        $str .= " <div class=\"row\">\n";
        $str .= "     <div align=\"left\" class=\"btn-group col-xs-10 col-sm-10 col-md-10 pull-left\"> \n";
// old type button.now moved to sidebar.Thinking optional first
//initialize dummy value

        $characterArray = range('A', 'Z');
        foreach ($characterArray as $character) {
            $str .= "      <button title=\"" . $character . "\" class=\"btn btn-success\" type=\"button\" onClick=\"ajaxQuerySearchAllCharacter('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','" . $character . "');\">" . $character . "</button> \n";
        }
        $str .= " </div>\n";
        $str .= " <div class=\"col-xs-2 col-sm-2 col-md-2\">\n";
        $str .= "     <div align=\"right\" class=\"pull-right\">\n";
        $str .= "         <div class=\"btn-group\">\n";
        $str .= "             <button class=\"btn btn-warning\" type=\"button\">\n";
        $str .= "                 <i class=\"glyphicon glyphicon-print glyphicon-white\"></i>\n";
        $str .= "             </button>\n";
        $str .= "             <button data-toggle=\"dropdown\" class=\"btn btn-warning dropdown-toggle\" type=\"button\">\n";
        $str .= "                 <span class=\"caret\"></span>\n";
        $str .= "             </button>\n";
        $str .= "			 <?php if(\$leafAccess['leafAccessPrintValue']==1) { ?>\n";
        $str .= "             <ul class=\"dropdown-menu\">\n";
        $str .= "                 <li>\n";
        $str .= "                     <a href=\"javascript:void(0)\" onClick=\"reportRequest('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$securityToken; ?>','excel')\">\n";
        $str .= "                         <i class=\"pull-right glyphicon glyphicon-download\"></i>Excel 2007\n";
        $str .= "                     </a>\n";
        $str .= "                 </li>\n";
        $str .= "                 <li>\n";
        $str .= "                     <a href =\"javascript:void(0)\" onClick=\"reportRequest('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$securityToken; ?>','csv')\">\n";
        $str .= "                         <i class =\"pull-right glyphicon glyphicon-download\"></i>CSV\n";
        $str .= "                     </a>\n";
        $str .= "                 </li>\n";
        $str .= "					</ul>\n";
        $str .= "				<?php } ?>\n";
        $str .= "				</div>\n";
        $str .= "			</div>\n";

        $str .= "		</div>\n";
        $str .= "	</div>\n";
        $str .= "	<div class=\"row\">\n";
        $str .= "		<div class=\"col-xs-12 col-sm-12 col-md-12\">&nbsp;</div>\n";
        $str .= "	</div>\n";
        $str .= "	<div class=\"row\">\n";
        $str .= "     <div id=\"leftViewportDetail\" class=\"col-xs-3 col-sm-3 col-md-3\"> \n";
        $str .= "		<div class=\"panel panel-default\">\n";
        $str .= "			<div class=\"panel-body\">\n";
        $str .= "				<div id=\"btnList\">\n";
        $str .= "				<?php  if(\$leafAccess['leafAccessCreateValue']==1) { ?>\n";
        $str .= "						<button type=\"button\" name=\"newRecordButton\" id=\"newRecordButton\" class=\"btn btn-info btn-block\" onClick=\"showForm('<?php echo \$leafId; ?>','<?php   echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>')\" value=\"<?php echo \$t['newButtonLabel']; ?>\"><?php echo \$t['newButtonLabel']; ?></button> \n";
        $str .= "				 <?php } ?>\n";
        $str .= "					</div>\n";
        $str .= "					<label for=\"queryWidget\"></label><div class=\"input-group\"><input type=\"text\" name=\"queryWidget\" id=\"queryWidget\" class=\"form-control\" value=\"<?php if(isset(\$_POST['query'])) {  echo \$_POST['query']; } ?>\"><span class=\"input-group-addon\">
<img id=\"searchTextImage\" src=\"./images/icons/magnifier.png\">
</span>
</div>\n<br>";
        $str .= "					<button type=\"button\" name=\"searchString\" id=\"searchString\" class=\"btn btn-warning btn-block\" onClick=\"ajaxQuerySearchAll('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>')\" value=\"<?php echo \$t['searchButtonLabel']; ?>\"><?php echo \$t['searchButtonLabel']; ?></button>\n";
        $str .= "     				<button type=\"button\" name=\"clearSearchString\" id=\"clearSearchString\" class=\"btn btn-info btn-block\" onClick=\"showGrid('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','0','<?php echo LIMIT; ?>',1)\" value=\"<?php echo \$t['clearButtonLabel']; ?>\"><?php echo \$t['clearButtonLabel']; ?></button>\n";
        $str .= "     				<table class=\"table table table-striped table-condensed table-hover\">\n";
        $str .= "         				<tr>\n";
// starting unix time till this day
        $str .= "             				<td>&nbsp;</td>\n";
        $str .= "             				<td align=\"center\"><img src=\"./images/icons/calendar-select-days-span.png\" alt=\"<?php echo \$t['allDay'] ?>\"></td>\n";
        $str .= "             				<td align=\"center\"><a href=\"javascript:void(0)\" rel=\"tooltip\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','01-01-1979','<?php echo  date('d-m-Y'); ?>','between','')\"><?php  echo \$t['anyTimeTextLabel']; ?></a></td>\n";
        $str .= "             				<td>&nbsp;</td>";
        $str .= "         				</tr>\n";
        $str .= "         				<tr>\n";
        $str .= "             				<td align=\"right\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"Previous Day <?php echo \$previousDay; ?>\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$previousDay; ?>','','day','next')\">&laquo;</a></td>\n";
        $str .= "             				<td align=\"center\"><img src=\"./images/icons/calendar-select-days.png\" alt=\"<?php echo \$t['day'] ?>\"></td>";
        $str .= "             				<td align=\"center\"><a href=\"javascript:void(0)\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$dateRangeStart; ?>','','day','')\"><?php  echo \$t['todayTextLabel']; ?></a></td>\n";
        $str .= "             				<td align=\"left\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"Next Day <?php echo \$nextDay; ?>\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$nextDay; ?>','','day','next')\">&raquo;</a></td>\n";
        $str .= "         				</tr>\n";
        $str .= "         				<tr>\n";
        $str .= "             				<td align=\"right\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"Previous Week<?php echo \$dateConvert->getCurrentWeekInfo(\$dateRangeStart,'previous'); ?>\"  onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$dateRangeStartPreviousWeekStartDay ; ?>','<?php echo \$dateRangeEndPreviousWeekEndDay ; ?>','week','previous')\">&laquo;</a> </td>\n";
        $str .= "             				<td align=\"center\"><img src=\"./images/icons/calendar-select-week.png\" alt=\"<?php echo \$t['week'] ?>\"></td>";
        $str .= "             				<td align=\"center\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"<?php echo \$dateConvert->getCurrentWeekInfo(\$dateRangeStart,'current'); ?>\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$dateRangeStartDay; ?>','<?php echo \$dateRangeEndDay; ?>','week','')\"><?php  echo \$t['weekTextLabel']; ?></a></td>\n";
        $str .= "             				<td align=\"left\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"Next Week <?php echo \$dateConvert->getCurrentWeekInfo(\$dateRangeStart,'next'); ?>\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$dateRangeEndForwardWeekStartDay ; ?>','<?php echo \$dateRangeEndForwardWeekEndDay ; ?>','week','next')\">&raquo;</a></td>\n";
        $str .= "        				</tr>\n";
        $str .= "         				<tr>\n";
        $str .= "             				<td align=\"right\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"Previous Month <?php echo \$previousMonth; ?>\"  onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$previousMonth; ?>','','month','previous')\">&laquo;</a></td> \n";
        $str .= "             				<td align=\"center\"><img src=\"./images/icons/calendar-select-month.png\" alt=\"<?php echo \$t['month'] ?>\"></td>";
        $str .= "             				<td align=\"center\"><a href=\"javascript:void(0)\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$dateRangeStart; ?>','','month','')\"><?php  echo \$t['monthTextLabel']; ?></a></td>\n";
        $str .= "             				<td align=\"left\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"Next Month <?php echo \$nextMonth; ?>\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$nextMonth; ?>','','month','next')\">&raquo;</a></td>\n";
        $str .= "         				</tr>\n";
        $str .= "         				<tr>\n";
        $str .= "             				<td align=\"right\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"Previous Year <?php echo \$previousYear; ?>\"  onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$previousYear; ?>','','year','previous')\">&laquo;</a></td> \n";
        $str .= "             				<td align=\"center\"><img src=\"./images/icons/calendar.png\" alt=\"<?php echo \$t['year'] ?>\"></td>";
        $str .= "             				<td align=\"center\"><a href=\"javascript:void(0)\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$dateRangeStart; ?>','','year','')\"><?php  echo \$t['yearTextLabel']; ?></a></td>\n";
        $str .= "             				<td align=\"left\"><a href=\"javascript:void(0)\" rel=\"tooltip\" title=\"Next Year <?php echo \$nextYear; ?>\" onClick=\"ajaxQuerySearchAllDate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo \$nextYear; ?>','','year','next')\">&raquo;</a></td>\n";
        $str .= "         				</tr>\n";
        $str .= "					</table>\n";
        $str .= "         				<div class=\"input-group\"><input type=\"text\" name=\"dateRangeStart\" id=\"dateRangeStart\" class=\"form-control\" value=\"<?php if(isset(\$_POST['dateRangeStart'])) { echo \$_POST['dateRangeStart']; } ?>\" onClick=\"topPage(125)\"  placeholder=\"<?php echo \$t['startDateTextLabel']; ?>\"><span class=\"input-group-addon\">
<img id=\"startDateImage\" src=\"./images/icons/calendar.png\">
</span>
</div><br>\n";
        $str .= "         				<div class=\"input-group\"><input type=\"text\" name=\"dateRangeEnd\" id=\"dateRangeEnd\" class=\"form-control\" value=\"<?php if(isset(\$_POST['dateRangeEnd'])) { echo \$_POST['dateRangeEnd']; } ?>\" onClick=\"topPage(175)\" placeholder=\"<?php echo \$t['endDateTextLabel']; ?>\"><span class=\"input-group-addon\">
<img id=\"endDateImage\" src=\"./images/icons/calendar.png\">
</span>
</div><br>\n";
        $str .= "						<button type=\"button\" name=\"searchDate\" id=\"searchDate\" class=\"btn btn-warning btn-block\" onClick=\"ajaxQuerySearchAllDateRange('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>')\" value=\"<?php echo \$t['searchButtonLabel']; ?>\"><?php echo \$t['searchButtonLabel']; ?></button>\n";
        $str .= "						<button type=\"button\" name=\"clearSearchDate\" id=\"clearSearchDate\" class=\"btn btn-info btn-block\" onClick=\"showGrid('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>',0,<?php echo LIMIT; ?>,1)\" value=\"<?php echo \$t['clearButtonLabel']; ?>\"><?php echo \$t['clearButtonLabel']; ?></button>\n";
        $str .= "			</div>\n";
        $str .= "		</div>\n";
        $str .= "	</div>\n";
        $str .= " <div id=\"rightViewport\" class=\"col-xs-9 col-sm-9 col-md-9\">\n";
        // $str .= "     <div id=\"infoPanel\"></div>  \n";

        $str .= "	<div class=\"modal fade\" id=\"deletePreview\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">\n";
        $str .= "		<div class=\"modal-dialog\">\n";
        $str .= "			<div class=\"modal-content\">\n";
        $str .= "				<div class=\"modal-header\">\n";
        $str .= "					<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"false\">&times;</button>\n";
        $str .= "					<h4 class=\"modal-title\"><?php echo \$t['deleteRecordMessageLabel']; ?></h4>\n";
        $str .= "				</div>\n";
        $str .= "				<div class=\"modal-body\">\n";
        $str .= "					<input type=\"hidden\" name=\"" . $data[0]['primaryKeyName'] . "Preview\" id=\"" . $data[0]['primaryKeyName'] . "Preview\">\n";
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['columnName'] != 'executeBy' &&
                    $data[$i]['columnName'] != 'executeTime' &&
                    $data[$i]['columnName'] != 'isDefault' &&
                    $data[$i]['columnName'] != 'isApproved' &&
                    $data[$i]['columnName'] != 'isPost' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isNew' &&
                    $data[$i]['columnName'] != 'isDraft' &&
                    $data[$i]['columnName'] != 'isUpdate' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isActive' &&
                    $data[$i]['columnName'] != 'isSlice' &&
                    $data[$i]['columnName'] != 'isSingle' &&
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'isConsolidation' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != $strId
            ) {
                $str .= "					<div class=\"form-group\" id=\"" . $data[$i]['columnName'] . "Div\">\n";
                $str .= "					<label class=\"control-label col-xs-4 col-sm-4 col-md-4 col-lg-4\" for=\"" . $data[$i]['columnName'] . "Preview\"><?php echo \$leafTranslation['" . $data[$i]['columnName'] . "Label'];  ?></label>\n";
                $str .= "					<div class=\" col-xs-8 col-sm-8 col-md-8 col-lg-8\">\n";
                $str .= "						<input class=\"form-control\" type=\"text\" name=\"" . $data[$i]['columnName'] . "Preview\" id=\"" . $data[$i]['columnName'] . "Preview\">\n";
                $str .= "         			</div>";
                $str .= "					</div>";
            }
        }
        $str .= "     		</div> \n";
        $str .= "     		<div class=\"modal-footer\"> \n";
        $str .= "                 <?php  if(\$leafAccess['leafAccessDeleteValue']==1) { ?>\n";
        $str .= "         		<button type=\"button\" class=\"btn btn-danger\" onClick=\"deleteGridRecord('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>')\" value=\"<?php echo \$t['deleteButtonLabel']; ?>\"><?php echo \$t['deleteButtonLabel']; ?></button>\n";
        $str .= "				<?php } ?>\n";
        $str .= "         		<button type=\"button\" class=\"btn btn-default\" onClick=\"showMeModal('deletePreview',0)\" value=\"<?php echo \$t['closeButtonLabel']; ?>\"><?php echo \$t['closeButtonLabel']; ?></button> \n";
        $str .= "     		</div> \n";
        $str .= " 		</div> \n";
        $str .= "     </div> \n";
        $str .= " </div> \n";


        $str .= "<div class=\"row\">\n";
        $str .= " <div class=\"col-xs-12 col-sm-12 col-md-12\">\n";
// table generation
        $str .= "     <div class=\"panel panel-default\"><table class =\"table table table-bordered table-striped table-condensed table-hover smart-form has-tickbox\" id=\"tableData\">\n";
        $str .= "         <thead> \n";
        $str .= "             <tr> \n";
        $str .= "                 <th width=\"25px\" align=\"center\"><div align=\"center\">#</div></th>\n";

// only output one record only.
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['Key'] == 'PRI') {
                $str .= "                    <th width=\"125px\"><div align=\"center\"><?php echo ucfirst(\$t['actionTextLabel']); ?></div></th>\n";
            } else {

                switch ($data[$i]['columnName']) {
                    case 'isDefault':
                    case 'isNew':
                    case 'isDraft':
                    case 'isUpdate':
                    case 'isDelete':
                    case 'isActive':
                    case 'isApproved':
                    case 'isReview':
                    case 'isPost':
                    // both consider optional
                    case $data[0]['tableName'] . 'Sequence':
                    case 'companyId':

                        break;
                    case $data[0]['tableName'] . 'Code':
                        $str .= "                  <th width=\"75px\"><div align=\"center\"><?php echo ucwords(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></div></th> \n";

                        break;
                    case $data[0]['tableName'] . 'Description':
                        $str .= "                  <th><?php echo ucwords(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></th> \n";

                        break;
                    case 'executeTime':
                        $str .= "                  <th width=\"175px\"><?php echo ucwords(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></th> \n";

                        break;

                    case 'executeBy':
                        $str .= "                  <th width=\"100px\"><div align=\"center\"><?php echo ucwords(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></div></th> \n";

                        break;
                    default:
                        $str .= "                  <th width=\"100px\"><?php echo ucwords(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></th> \n";
                }
            }
        }
        $str .= "                 <th width=\"25px\"><input type=\"checkbox\" name=\"check_all\" id=\"check_all\" alt=\"Check Record\" onClick=\"toggleChecked(this.checked)\"></th>
";
        $str .= "             </tr> \n";
        $str .= "         </thead> \n";
        $str .= "         <tbody id=\"tableBody\"> \n";
        $str .= "             <?php   if (\$_POST['method'] == 'read' && \$_POST['type'] == 'list' && \$_POST['detail'] == 'body') { \n";
        $str .= "                 if (is_array(\$" . $data[0]['tableName'] . "Array)) { \n";
        $str .= "                     \$totalRecord = intval(count(\$" . $data[0]['tableName'] . "Array)); \n";
        $str .= "                     if (\$totalRecord > 0) { \n";
        $str .= "                         \$counter=0; \n";
        $str .= "                         for (\$i = 0; \$i < \$totalRecord; \$i++) { \n";
        $str .= "                             \$counter++; ?>\n";
        $str .= "                            	<tr ";
        $str .= "<?php \n";
        $str .= "                                           if (\$" . $data[0]['tableName'] . "Array[\$i]['isDelete'] == 1) { \n";
        $str .= "                                                echo \"class=\\\"danger\\\"\"; \n";
        $str .= "                                            } else { \n";
        $str .= "                                                if (\$" . $data[0]['tableName'] . "Array[\$i]['isDraft'] == 1) { \n";
        $str .= "                                                    echo \"class=\\\"warning\\\"\"; \n";
        $str .= "                                               } \n";
        $str .= "                                           } \n";
        $str .= "                                            ?>>\n";
        $str .= "                             	<td vAlign=\"top\" align=\"center\"><div align=\"center\"><?php echo (\$counter+\$offset); ?>.</div></td>";
        $strInside = null;

        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['Key'] == 'PRI') {
                $str .= "                       	<td vAlign=\"top\" align=\"center\"><div class=\"btn-group\" align=\"center\">\n";
                $str .= "<?php if(\$leafAccess['leafAccessUpdateValue']==1) { ?>\n";
                $str .= "                                 <button type=\"button\" class=\"btn btn-warning btn-sm\" title=\"Edit\" onClick=\"showFormUpdate('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>','<?php echo intval(\$" . $data[0]['tableName'] . "Array [\$i]['" . $data[0]['primaryKeyName'] . "']); ?>',<?php echo \$leafAccess['leafAccessUpdateValue']; ?>,<?php echo \$leafAccess['leafAccessDeleteValue']; ?>);\" value=\"Edit\"><i class=\"glyphicon glyphicon-edit glyphicon-white\"></i></button>\n";
                $str .="<?php }\n";
                $str .="if(\$leafAccess['leafAccessDeleteValue']==1) { ?>\n";
                $str .= "                                 <button type=\"button\" class=\"btn btn-danger btn-sm\" title=\"Delete\" onClick=\"showModalDelete(";
                $str .="}\n";
                for ($d = 0; $d < $total; $d++) {
                    // encode first to prevent bugs on javascript parsing
                    if ($data[$d]['columnName'] != 'executeBy' &&
                            $data[$d]['columnName'] != 'executeTime' &&
                            $data[$d]['columnName'] != 'isDefault' &&
                            $data[$d]['columnName'] != 'isApproved' &&
                            $data[$d]['columnName'] != 'isPost' &&
                            $data[$d]['columnName'] != 'isDelete' &&
                            $data[$d]['columnName'] != 'isNew' &&
                            $data[$d]['columnName'] != 'isDraft' &&
                            $data[$d]['columnName'] != 'isUpdate' &&
                            $data[$d]['columnName'] != 'isDelete' &&
                            $data[$d]['columnName'] != 'isActive' &&
                            $data[$d]['columnName'] != 'isSlice' &&
                            $data[$d]['columnName'] != 'isSingle' &&
                            $data[$d]['columnName'] != 'isReview' &&
                            $data[$d]['columnName'] != 'isConsolidation' &&
                            $data[$d]['columnName'] != 'companyId'
                    ) {
                        if ($data[$d]['Key'] == 'MUL') {
                            if ($data[$d]['columnName'] != 'companyId') {
                                //exception for some cases
                                if ($data[$d]['columnName'] == 'businessPartnerId') {
                                    $field = str_replace("Id", "", $data[$d]['columnName']) . "Company";
                                } else if ($data[$d]['columnName'] == 'employeeId') {
                                    $field = str_replace("Id", "", $data[$d]['columnName']) . "FirstName";
                                } else if ($data[$d]['columnName'] == 'staffId') {
                                    $field = str_replace("Id", "", $data[$d]['columnName']) . "Name";
                                } else if ($data[$d]['columnName'] == 'chartOfAccountId') {
                                    $field = str_replace("Id", "", $data[$d]['columnName']) . "Title";
                                } else if ($data[$d]['columnName'] == 'assetId') {
                                    $field = str_replace("Id", "", $data[$d]['columnName']) . "Name";
                                } else {
                                    $field = str_replace("Id", "", $data[$d]['columnName']) . "Description";
                                }
                                $strInside .= "'<?php echo rawurlencode(\$" . $data[0]['tableName'] . "Array [\$i]['" . $field . "']); ?>',";
                            }
                        } else {
                            $strInside .= "'<?php echo rawurlencode(\$" . $data[0]['tableName'] . "Array [\$i]['" . $data[$d]['columnName'] . "']); ?>',";
                        }
                    }
                }
                $str .= substr($strInside, 0, -1);
                $str .= ")\" value=\"Delete\"><i class=\"glyphicon glyphicon-trash glyphicon-white\"></i></button><?php } ?></div></td> \n";
            } else {

                switch ($data[$i]['columnName']) {
                    case 'isDefault':
                    case 'isNew':
                    case 'isDraft':
                    case 'isUpdate':
                    case 'isDelete':
                    case 'isActive':
                    case 'isApproved':
                    case 'isReview':
                    case 'isPost':
                    // both consider optional
                    case $data[0]['tableName'] . 'Sequence':
                    case 'companyId':
                        break;
                    case 'executeBy':
                        $str .= "                                    <td vAlign=\"top\" align=\"center\"><div align=\"center\">\n";
                        $str .= "   <?php if(isset(\$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "'])) {\n";
                        $str .= "           if(isset(\$_POST['query']) || isset(\$_POST['character'])) { \n";
                        $str .= "				if(isset(\$_POST['query']) && strlen(\$_POST['query'])>0) { \n";
                        $str .= "               	if(strpos(strtolower(\$" . $data[0]['tableName'] . "Array[\$i]['staffName']),strtolower(\$_POST['query'])) !== false){\n";
                        $str .= "                   	echo str_replace(strtolower(\$_POST['query']),\"<span class=\\\"label label-info\\\">\".strtolower(\$_POST['query']).\"</span>\",strtolower(\$" . $data[0]['tableName'] . "Array[\$i]['staffName']));\n";
                        $str .= "               	}else{\n";
                        $str .= "               		echo \$" . $data[0]['tableName'] . "Array[\$i]['staffName']; \n";
                        $str .= "					}\n";
                        $str .= "				} else if (isset(\$_POST['character']) && strlen(\$_POST['character'])>0) { \n";
                        $str .= "               	if(strpos(\$" . $data[0]['tableName'] . "Array[\$i]['staffName'],\$_POST['character']) !== false){\n";
                        $str .= "                   	echo str_replace(strtolower(\$_POST['query']),\"<span class=\\\"label label-info\\\">\".strtolower(\$_POST['character']).\"</span>\",strtolower(\$" . $data[0]['tableName'] . "Array[\$i]['staffName']));\n";
                        $str .= "               	}else{\n";
                        $str .= "               		echo \$" . $data[0]['tableName'] . "Array[\$i]['staffName']; \n";
                        $str .= "					}\n";
                        $str .= "           	} else {\n";
                        $str .= "               	echo \$" . $data[0]['tableName'] . "Array[\$i]['staffName']; \n";
                        $str .= "				}\n";
                        $str .= "           } else {\n";
                        $str .= "               	echo \$" . $data[0]['tableName'] . "Array[\$i]['staffName']; \n";
                        $str .= "			} ?>\n";
                        $str .= "                             <?php } else { ?>\n";
                        $str .= "                                   &nbsp;\n";
                        $str .= "                             <?php } ?>\n  ";
                        $str .= "                            </div></td>\n";
                        break;
                    case 'executeTime':
                        $str .= "                             <?php if(isset(\$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "'])) { \n";
                        $str .= "                                 \$valueArray = \$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "'];  \n";
                        $str .= "                                 if (\$dateConvert->checkDateTime(\$valueArray)) {\n";
                        $str .= "                                   \$valueArrayDate 	=   explode(' ',\$valueArray);  \n";
                        $str .= "                                   \$valueArrayFirst 	=   \$valueArrayDate[0];         \n";
                        $str .= "                                   \$valueArraySecond	=   \$valueArrayDate[1];          \n";

                        $str .= "                                   \$valueDataFirst 	=   explode('-',\$valueArrayFirst);  \n";
                        $str .= "                                   \$year              =   \$valueDataFirst[0];               \n";
                        $str .= "                                   \$month             =   \$valueDataFirst[1];            \n";
                        $str .= "                                   \$day               =   \$valueDataFirst[2];                \n";

                        $str .= "                                   \$valueDataSecond 	=   explode(':',\$valueArraySecond);  \n";
                        $str .= "                                   \$hour              =   \$valueDataSecond[0];  \n";
                        $str .= "                                   \$minute            =   \$valueDataSecond[1];  \n";
                        $str .= "                                   \$second            =   \$valueDataSecond[2];  \n";

                        $str .= "                                   \$value = date(\$systemFormat['systemSettingDateFormat'].\" \".\$systemFormat['systemSettingTimeFormat'],mktime(\$hour,\$minute,\$second,\$month,\$day,\$year)); \n";
                        $str .= "                                 } else { \n";
                        $str .= "                                   \$value=null;\n";
                        $str .= "                                 } ?>\n";
                        $str .= "                                	<td vAlign=\"top\"><?php echo \$value; ?></td> \n";
                        $str .= "                             <?php } else { ?>\n";
                        $str .= "                                 <td>&nbsp;</td> \n";
                        $str .= "                             <?php } ?>\n  	";
                        break;
                    default:
                        // if the type are decimal or float. align right
                        // if the length is 4 align  center
                        // if  normal align  left.For easy reading

                        if ($data[$i]['formType'] == 'double' || $data[$i]['formType'] == 'int') {
                            if ($data[$i]['Key'] == 'MUL') {
                                $alignStart = "<div align=\"center\">";
                            } else {
                                $alignStart = "<div align=\"right\">";
                            }
                        } else if ($data[$i]['length'] == 2 || $data[$i]['length'] == 4 || $data[$i]['length'] == 8 || $data[$i]['length'] == 4) {
                            $alignStart = "<div align=\"center\">";
                        } else {
                            $alignStart = "<div align=\"left\">";
                        }
                        if ($data[$i]['columnName'] == 'executeBy' || $data[$i]['columnName'] == $data[0]['tableName'] . 'Code') {
                            $alignStart = "<div align=\"center\">";
                        }
                        $alignEnd = "</div>";
                        //must check data type if date .. convert output to master setting date

                        if ($data[$i]['field'] == 'date') {
                            $str .= "                             <?php if(isset(\$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "'])) { \n";

                            $str .= "                                 \$valueArray 		= 	\$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']; \n";
                            $str .= "                                 if (\$dateConvert->checkDate(\$valueArray)) {\n";
                            $str .= "                                   \$valueData 		= 	explode('-',\$valueArray);  \n";
                            $str .= "                                   \$year 				= 	\$valueData[0];  \n";
                            $str .= "                                   \$month 			= 	\$valueData[1];   \n";
                            $str .= "                                   \$day 				= 	\$valueData[2];  \n";
                            $str .= "                                   \$value				=	date(\$systemFormat['systemSettingDateFormat'],mktime(0,0,0,\$month,\$day,\$year));\n";
                            $str .= "                                 }else { \n";
                            $str .= "                                   \$value=null;\n";
                            $str .= "                                 }  ?>\n";
                            $str .= "                                 <td vAlign=\"top\"><?php echo \$value; ?></td> \n";

                            $str .= "                             <?php } else { ?>\n ";
                            $str .= "                                 <td vAlign=\"top\">" . $alignStart . "&nbsp;" . $alignEnd . "</td> \n ";
                            $str .= "                             <?php } ?>\n";
                        } else if ($data[$i]['field'] == 'datetime') {
                            $str .= "                             <?php if(isset(\$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "'])) {\n";

                            $str .= "                                 \$valueArray = \$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']; \n";
                            $str .= "                                 if (\$dateConvert->checkDateTime(\$valueArray)) {\n";
                            $str .= "                                   \$valueArrayDate 	=	explode(' ',\$valueArray);\n";
                            $str .= "                                   \$valueArrayFirst 	= 	\$valueArrayDate[0];\n";
                            $str .= "                                   \$valueArraySecond	= 	\$valueArrayDate[1];\n";

                            $str .= "                                   \$valueDataFirst 	= 	explode('-',\$valueArrayFirst);\n";
                            $str .= "                                   \$year 				=	\$valueDataFirst[0];\n";
                            $str .= "                                   \$month 			= 	\$valueDataFirst[1];\n";
                            $str .= "                                   \$day	 			= 	\$valueDataFirst[2];\n";

                            $str .= "                                   \$valueDataSecond 	= 	explode(':',\$valueArraySecond);\n";
                            $str .= "                                   \$hour 				= 	\$valueDataSecond[0];\n";
                            $str .= "                                   \$minute 			= 	\$valueDataSecond[1];\n";
                            $str .= "                                   \$second 			= 	\$valueDataSecond[2];\n";

                            $str .= "                                   \$value = date(\$systemFormat['systemSettingDateFormat'].\" \".\$systemFormat['systemSettingTimeFormat'],mktime(\$hour,\$minute,\$second,\$month,\$day,\$year));\n";
                            $str .= "                                 }else { \n";
                            $str .= "                                   \$value=null;\n";
                            $str .= "                                 }  ?>\n";
                            $str .= "                                 <td vAlign=\"top\">" . $alignStart . "<?php echo \$value; ?>" . $alignEnd . "</td>; \n";

                            $str .= "                             <?php } else { ?>\n ";
                            $str .= "                                 <td vAlign=\"top\">" . $alignStart . "&nbsp;" . $alignEnd . "</td> \n ";
                            $str .= "                             <?php } ?>\n";
                        } else if ($data[$i]['field'] == 'float' || $data[$i]['field'] == 'double') {
                            $str .= "                             <?php \$d = \$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']; \n";
                            $str .= "                                   if(class_exists('NumberFormatter')) {\n";
                            $str .= "                                       if(is_array(\$systemFormat) && \$systemFormat['languageCode'] !='') {\n";
                            $str .= "                                           \$a = new \\NumberFormatter(\$systemFormat['languageCode'], \\NumberFormatter::CURRENCY );\n";
                            $str .= "                                           \$d = \$a->format($" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']);\n";
                            $str .= "                                       } else {\n";
                            $str .= "                                           \$d = number_format(\$d).\" You can assign Currency Format \"; \n";
                            $str .= "                                       }\n";
                            $str .= "                                   } else {\n";
                            $str .= "                                      \$d = number_format(\$d);\n";
                            $str .= "                                   } ?>\n";
                            $str .= "    <td vAlign=\"top\"><div align=\"right\"><?php echo\$d; ?></div></td>\n";
                        } else {
                            // check if the column name contain word desc. if true replace it
                            $pos = strpos($data[$i]['columnName'], 'Id');
                            // mostly it was a foreign key
                            if ($pos !== false) {
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
                                    $str .= "                                    <td vAlign=\"top\">" . $alignStart . "\n";
                                    $str .= "<?php  if(isset(\$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "'])) { \n";
                                    $str .= "           if(isset(\$_POST['query']) ||  isset(\$_POST['character'])){ \n";
                                    $str .= "				if(isset(\$_POST['query']) && strlen(\$_POST['query'])>0) {\n";
                                    $str .= "               	if(strpos(\$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "'],\$_POST['query']) !== false){\n";
                                    $str .= "                   	echo str_replace(\$_POST['query'],\"<span class=\\\"label label-info\\\">\".\$_POST['query'].\"</span>\",\$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "']);\n";
                                    $str .= "					}else {\n";
                                    $str .= "                   	echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "']; \n";
                                    $str .= "					}\n";
                                    $str .= "               } else if (isset(\$_POST['character']) && strlen(\$_POST['character'])>0) { \n";
                                    $str .= "					if(strpos(\$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "'],\$_POST['character']) !== false){\n";
                                    $str .= "                   	echo str_replace(\$_POST['character'],\"<span class=\\\"label label-info\\\">\".\$_POST['character'].\"</span>\",\$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "']);\n";
                                    $str .= "					}else{\n";
                                    $str .= "                   	echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "']; \n";
                                    $str .= "					}\n";
                                    $str .= "               }else{\n";
                                    $str .= "                   echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "']; \n";
                                    $str .= "				}\n";
                                    $str .= "           } else {\n";
                                    $str .= "                echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $field . "']; \n";
                                    $str .= "           } ?>\n";
                                    $str .= "           " . $alignEnd . "\n";

                                    $str .= " <?php } else {  ?>\n ";
                                    $str .= "                                    &nbsp;\n ";
                                    $str .= "<?php } ?>\n";
                                    $str .= " </td>\n";
                                }
                            } else {
                                $str .= "                                    <td vAlign=\"top\">" . $alignStart . "\n";
                                $str .= "   <?php   if(isset(\$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "'])) { \n";
                                $str .= "               if(isset(\$_POST['query']) || isset(\$_POST['character'])) { \n";
                                $str .= "					if(isset(\$_POST['query']) && strlen(\$_POST['query'])>0) { \n";
                                $str .= "                   	if(strpos(strtolower(\$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']),strtolower(\$_POST['query'])) !== false){\n";
                                $str .= "                       	echo str_replace(strtolower(\$_POST['query']),\"<span class=\\\"label label-info\\\">\".strtolower(\$_POST['query']).\"</span>\",strtolower(\$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']));\n";
                                $str .= "						}else { \n";
                                $str .= "                   		echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']; \n";
                                $str .= "						}\n";
                                $str .= "                   } else if(isset(\$_POST['character']) && strlen(\$_POST['character'])>0) { \n";
                                $str .= "						if(strpos(strtolower(\$" . $data[0]['tableName'] . "Array[\$i]['" . str_replace("Id", "Description", $data[$i]['columnName']) . "']),strtolower(\$_POST['character'])) !== false){\n";
                                $str .= "                       	echo str_replace(strtolower(\$_POST['character']),\"<span class=\\\"label label-info\\\">\".strtolower(\$_POST['character']).\"</span>\",strtolower(\$" . $data[0]['tableName'] . "Array[\$i]['" . str_replace("Id", "Description", $data[$i]['columnName']) . "']));\n";
                                $str .= "						}else{ \n";
                                $str .= "                   		echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']; \n";
                                $str .= "						}\n";
                                $str .= "                   }else {\n";
                                $str .= "                   	echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']; \n";
                                $str .= "					}\n";
                                $str .= "               } else {\n";
                                $str .= "                   echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $data[$i]['columnName'] . "']; \n";
                                $str .= "               } ?>\n";
                                $str .= "           " . $alignEnd . "\n";
                                $str .= "<?php } else { ?>\n ";
                                $str .= "                                   &nbsp;\n";
                                $str .= "<?php } ?>\n";
                                $str .= "</td>\n";
                            }
                        }
                }
            }
        }
// new experiment delete function back.. give more focus to user.. 
        $str .= "                             <?php if(\$" . $data[0]['tableName'] . "Array[\$i]['isDelete']) {\n";
        $str .= "                                 \$checked=\"checked\";\n";
        $str .= "                             } else {\n";
        $str .= "                                 \$checked=NULL;\n";
        $str .= "                             }  ?>\n";
        $str .= "                            <td vAlign=\"top\">
    <input class=\"form-control\" style=\"display:none;\" type=\"checkbox\" name=\"" . $data[0]['primaryKeyName'] . "[]\"  value=\"<?php echo \$" . $data[0]['tableName'] . "Array[\$i]['" . $data[0]['primaryKeyName'] . "']; ?>\">
    <?php  if(\$leafAccess['leafAccessDeleteValue']==1) { ?>
	<input class=\"form-control\" <?php echo \$checked; ?> type=\"checkbox\" name=\"isDelete[]\" value=\"<?php echo \$" . $data[0]['tableName'] . "Array[\$i]['isDelete']; ?>\">
    <?php } ?>
</td>\n";
        $str .= "                    	</tr> \n";
        $str .= "                  <?php } \n } else {  ?>\n";
        $str .= "                    <tr> \n";
        $str .= "                        <td colspan=\"7\" vAlign=\"top\" align=\"center\"><?php \$" . $data[0]['tableName'] . "->exceptionMessage(\$t['recordNotFoundLabel']); ?></td> \n";
        $str .= "                    </tr> \n";
        $str .= "         <?php    }\n }  else { ?> \n";
        $str .= "                    <tr> \n";
        $str .= "                        <td colspan=\"7\" vAlign=\"top\" align=\"center\"><?php \$" . $data[0]['tableName'] . "->exceptionMessage(\$t['recordNotFoundLabel']); ?></td> \n";
        $str .= "                    </tr> \n";
        $str .= "                    <?php \n";
        $str .= "                } \n";
        $str .= "            } else { ?> \n";
        $str .= "                <tr> \n";
        $str .= "                    <td colspan=\"7\" vAlign=\"top\" align=\"center\"><?php \$" . $data[0]['tableName'] . "->exceptionMessage(\$t['loadFailureLabel']); ?></td> \n";
        $str .= "                </tr> \n";
        $str .= "                <?php \n";
        $str .= "            } \n";
        $str .= "          ?> \n";
        $str .= "             </tbody> \n";
        $str .= "         </table></div>\n";
        $str .= "     </div>\n";
        $str .= " </div>\n";
        $str .= " <div class=\"row\">\n";
        $str .= "     <div class=\"col-xs-9 col-sm-9 col-md-9 pull-left\" align=\"left\">\n";
        $str .= "         <?php \$navigation->pagenationv4(\$offset); ?>\n";
        $str .= "     </div>\n";
        $str .= "     <div class=\"col-xs-3 col-sm-3 col-md-3 pull-right pagination\" align=\"right\">\n";
        $str .= "        <?php  if(\$leafAccess['leafAccessDeleteValue']==1) { ?>\n";
        $str .= "		<button type=\"button\" class=\"delete btn btn-warning\" onClick=\"deleteGridRecordCheckbox('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>')\"> \n";
        $str .= "			<i class=\"glyphicon glyphicon-white glyphicon-trash\"></i> \n";
        $str .= "		</button> \n";
        $str .= "        <?php } ?>\n";
        $str .= "     </div>\n";
        $str .= " </div> \n";
        $str .= "  <script type=\"text/javascript\"> \n";
        $str .= "     \$(document).ready(function(){ \n";
        $str .= "         \$(document).scrollTop(0);\n";
        $str .= "         \$('#dateRangeStart').datepicker({  \n";
        $str .= "             format :'<?php echo  \$systemFormat['systemSettingDateFormat']; ?>'  \n";
        $str .= "         }).on('changeDate', function () {\n";
        $str .= "             \$(this).datepicker('hide');\n";
        $str .= "         });  \n";
        $str .= "         \$('#dateRangeEnd').datepicker({  \n";
        $str .= "             format :'<?php echo  \$systemFormat['systemSettingDateFormat']; ?>'  \n";
        $str .= "         }).on('changeDate', function () {\n";
        $str .= "             \$(this).datepicker('hide');\n";
        $str .= "         });   \n";
        $str .= "     }); \n";
        $str .= "     function toggleChecked(status) {\n";
        $str .= "         \$('input:checkbox').each( function() {\n";
        $str .= "             \$(this).attr('checked',status);\n";
        $str .= "         });\n";
        $str .= "     } \n";
        $str .= " </script> \n";
        $str .= " </div>\n";
        $str .= "</div>\n";
        $str .= "</div>\n";
        $str .= "    <?php } }  \n";


//generate form
        $str .= " if ((isset(\$_POST['method']) == 'new' || isset(\$_POST['method']) == 'read') && \$_POST['type'] == 'form') { ?> \n";
                $str .= "<?php\n";
		if (isset($dataTabDetail) && count($dataTabDetail) > 0) {
            for ($j = 0; $j < $tabCounter; $j++) {
                if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                    $total = count($dataTabDetail[$j]);
					
                        $str .= "\$" . $dataTabDetail[$j][0]['tableName'] . " = new \\Core\\" . ucwords($data[0]['package']) . "\\" . ucwords($data[0]['module']) . "\\" . ucwords($dataTabDetail[$j][0]['tableName']) . "\\Controller\\";
                        $str .= ucfirst($dataTabDetail[$j][0]['tableName']);
                        $str .= "Class();  \n";

                        $str .= " \$" . $dataTabDetail[$j][0]['tableName'] . "->setServiceOutput('html');  \n";
                        $str .= " \$" . $dataTabDetail[$j][0]['tableName'] . "->setLeafId(\$leafId);  \n";
                        $str .= " \$" . $dataTabDetail[$j][0]['tableName'] . "->execute();  \n";
						$str .= " \$" . $dataTabDetail[$j][0]['tableName'] . "->setStart(0);  \n";
						$str .= " \$" . $dataTabDetail[$j][0]['tableName'] . "->setLimit(999999);\n";
						$str .= " \$" . $dataTabDetail[$j][0]['tableName'] . "->setPageOutput('html');  \n";
						$str .= "if(isset(\$_POST['" . $data[0]['primaryKeyName'] . "'])) { \n";
						$str .= " \$" . $dataTabDetail[$j][0]['tableName'] . "Array = \$" . $dataTabDetail[$j][0]['tableName'] . "->read();  \n";
						$str .= " }\n";
                    for ($i = 0; $i < $total; $i++) {
							if ($dataTabDetail[$j][$i]['columnName'] != 'companyId' 
								&& $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName']) {
								if ($dataTabDetail[$j][$i]['Key'] == 'MUL') {
									// we only can assumed it was the same package and module otherwise manual change
									$str .= " \$" . str_replace("Id", "", $dataTabDetail[$j][$i]['columnName']) . "Array = \$" . $dataTabDetail[$j][0]['tableName'] . "->get" . ucfirst(str_replace("Id", "", $dataTabDetail[$j][$i]['columnName'])) . "();\n";
								}
							}						
                    }
                }
            }
        }
		$str .= " ?>\n";
        $str .= "<form class=\"" . $data[0]['targetFormStyle'] . "\">\n";
        $str .= " <input type=\"hidden\" name=\"" . $data[0]['primaryKeyName'] . "\" id=\"" . $data[0]['primaryKeyName'] . "\" value=\"<?php if (isset(\$_POST['" . $data[0]['primaryKeyName'] . "'])) {
			echo \$_POST['" . $data[0]['primaryKeyName'] . "'];    
		}  ?>\"> \n";
        $str .= " <div class=\"row\">\n";
        $str .= "  <div class=\"col-xs-12 col-sm-12 col-md-12\">\n";
        $str .= "   <?php \$template->setLayout(2); \n";
        $str .= "    echo	\$template->breadcrumb(\$applicationNative, \$moduleNative, \$folderNative, \$leafNative,\$securityToken,\$applicationId,\$moduleId,\$folderId,\$leafId);   ?> \n";
        $str .= "   </div> \n";
        $str .= "   </div> \n";
        $str .= "   <div id=\"infoErrorRowFluid\" class=\"row hidden\">\n";
        $str .= "    <div id=\"infoError\" class=\"col-xs-12 col-sm-12 col-md-12\">&nbsp;</div>\n";
        $str .= "   </div>\n";
        $str .= " 	<div id=\"content\" style=\"opacity: 1;\">\n";
        $str .= "		<div class=\"row\">\n";
        $str .= "			<div class=\"col-xs-12 col-sm-12 col-md-12\">\n";
        $str .= "				<div class=\"panel panel-info\">\n";
        $str .= "					<div class=\"panel-heading\">\n";
        $str .= "						<div class=\"pull-left\">\n";
        $str .= "                         <div class=\"btn-group\" align=\"left\">\n";
        $str .= "                          <a id=\"newRecordButton1\" href=\"javascript:void(0)\" class=\"btn btn-success disabled\"><i class=\"glyphicon glyphicon-plus glyphicon-white\"></i> <?php echo \$t['newButtonLabel']; ?> </a> \n";
        $str .= "                          <a id=\"newRecordButton2\" href=\"javascript:void(0)\" class=\"btn dropdown-toggle btn-success disabled\" data-toggle=\"dropdown\"><span class=caret></span></a> \n";
        $str .= "                          <ul class=\"dropdown-menu\"> \n";
        $str .= "                           <li><a id=\"newRecordButton3\" href=\"javascript:void(0)\" class=\"disabled\"><i class=\"glyphicon glyphicon-plus\"></i> <?php  echo \$t['newContinueButtonLabel']; ?></a> </li> \n";
        $str .= "                           <li><a id=\"newRecordButton4\" href=\"javascript:void(0)\" class=\"disabled\"><i class=\"glyphicon glyphicon-edit\"></i> <?php  echo \$t['newUpdateButtonLabel']; ?></a> </li> \n";
        $str .= "                           <li><a id=\"newRecordButton7\" href=\"javascript:void(0)\" class=\"disabled\"><i class=\"glyphicon glyphicon-list\"></i> <?php  echo \$t['newListingButtonLabel']; ?> </a></li> \n";
        $str .= "                          </ul> \n";
        $str .= "                         </div> \n";
        $str .= "                         <div class=\"btn-group\" align=\"left\">\n";
        $str .= "                          <a id=\"updateRecordButton1\" href=\"javascript:void(0)\" class=\"btn btn-info disabled\"><i class=\"glyphicon glyphicon-edit glyphicon-white\"></i> <?php  echo \$t['updateButtonLabel']; ?> </a> \n";
        $str .= "                          <a id=\"updateRecordButton2\" href=\"javascript:void(0)\" class=\"btn dropdown-toggle btn-info disabled\" data-toggle=\"dropdown\"><span class=\"caret\"></span></a> \n";
        $str .= "                          <ul class=\"dropdown-menu\"> \n";
        $str .= "                           <li><a id=\"updateRecordButton3\" href=\"javascript:void(0)\" class=\"disabled\"><i class=\"glyphicon glyphicon-plus\"></i> <?php  echo \$t['updateButtonLabel']; ?></a> </li> \n";
        $str .= "                           <li><a id=\"updateRecordButton5\" href=\"javascript:void(0)\" class=\"disabled\"><i class=\"glyphicon glyphicon-list-alt\"></i> <?php  echo \$t['updateListingButtonLabel']; ?></a> </li> \n";
        $str .= "                          </ul> \n";
        $str .= "                         </div> \n";
        $str .= "                        <div class=\"btn-group\">\n";
        $str .= "                          <button type=\"button\" id=\"deleteRecordButton\" class=\"btn btn-danger disabled\"><i class=\"glyphicon glyphicon-trash glyphicon-white\"></i> <?php echo \$t['deleteButtonLabel']; ?> </button> \n";
        $str .= "                         </div> \n";
        $str .= "                         <div class=\"btn-group\">\n";
        $str .= "                           <button type=\"button\" id=\"resetRecordButton\" class=\"btn btn-info\" onClick=\"resetRecord(<?php echo \$leafId; ?>,'<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>',<?php echo \$leafAccess['leafAccessCreateValue']; ?>,<?php echo \$leafAccess['leafAccessUpdateValue']; ?>,<?php echo \$leafAccess['leafAccessDeleteValue']; ?>)\" value=\"<?php echo \$t['resetButtonLabel']; ?>\"><i class=\"glyphicon glyphicon-refresh glyphicon-white\"></i> <?php echo \$t['resetButtonLabel']; ?> </button> \n";
        $str .= "                          </div> \n";
        $str .= "                          <div class=\"btn-group\">\n";
        $str .= "                           <button type=\"button\" id=\"postRecordButton\" class=\"btn btn-warning disabled\"><i class=\"glyphicon glyphicon-cog glyphicon-white\"></i> <?php echo \$t['postButtonLabel']; ?> </button> \n";
        $str .= "                           </div> \n";
        $str .= "                          <div class=\"btn-group\">\n";
        $str .= "                           <button type=\"button\" id=\"listRecordButton\" class=\"btn btn-info\" onClick=\"showGrid('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>',0,<?php echo LIMIT; ?>,1)\"><i class=\"glyphicon glyphicon-list glyphicon-white\"></i> <?php echo \$t['gridButtonLabel']; ?> </button> \n";
        $str .= "                          </div> \n";
        $str .= "                        </div>\n";
        $str .= "						<div align=\"right\">\n";
        $str .= "                          <div class=\"btn-group\">\n";
        $str .= "                           <button type=\"button\" id=\"firstRecordButton\" class=\"btn btn-default\" onClick=\"firstRecord('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>',<?php echo \$securityToken; ?>','<?php echo \$leafAccess['leafAccessUpdateValue']; ?>','<?php echo \$leafAccess['leafAccessDeleteValue']; ?>');\"><i class=\"glyphicon glyphicon-fast-backward glyphicon-white\"></i> <?php echo \$t['firstButtonLabel']; ?> </button> \n";
        $str .= "							</div> \n";
        $str .= "							<div class=\"btn-group\">\n";
        $str .= "								<button type=\"button\" id=\"previousRecordButton\" class=\"btn btn-default disabled\" onClick=\"previousRecord('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>',<?php echo \$leafAccess['leafAccessUpdateValue']; ?>,<?php echo \$leafAccess['leafAccessDeleteValue']; ?>);\"><i class=\"glyphicon glyphicon-backward glyphicon-white\"></i> <?php echo \$t['previousButtonLabel']; ?> </button> \n";
        $str .= "							</div>\n";
        $str .= "							<div class=\"btn-group\">\n";
        $str .= "								<button type=\"button\" id=\"nextRecordButton\" class=\"btn btn-default disabled\" onClick=\"nextRecord('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php echo \$securityToken; ?>',<?php echo \$leafAccess['leafAccessUpdateValue']; ?>,<?php echo \$leafAccess['leafAccessDeleteValue']; ?>);\"><i class=\"glyphicon glyphicon-forward glyphicon-white\"></i> <?php echo \$t['nextButtonLabel']; ?> </button> \n";
        $str .= "        					</div>\n";
        $str .= "							<div class=\"btn-group\">\n";
        $str .= "								<button type=\"button\" id=\"endRecordButton\" class=\"btn btn-default\" onClick=\"endRecord('<?php echo \$leafId; ?>','<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>',";
        $str .= "'<?php echo \$securityToken; ?>','<?php echo \$leafAccess['leafAccessUpdateValue']; ?>','<?php echo \$leafAccess['leafAccessDeleteValue']; ?>');\"><i class=\"glyphicon glyphicon-fast-forward glyphicon-white\"></i> <?php echo \$t['endButtonLabel']; ?> </button> \n";
        $str .= "							</div>\n";
        $str .= "						</div>\n";
        $str .= "					</div>\n";
        $str .= "					<div class=\"panel-body\">\n";

        // here the complex tab
        $str .= "	<div class=\"jarviswidget\" id=\"wid-id-8\" data-widget-colorbutton=\"false\" data-widget-editbutton=\"false\" data-widget-togglebutton=\"false\" data-widget-deletebutton=\"false\" data-widget-fullscreenbutton=\"false\" data-widget-custombutton=\"false\" data-widget-sortable=\"false\">\n";
        $str .= "<header>\n";
        $str .= "<ul id=\"myTab\" class=\"nav nav-tabs pull-right in tab-content\">\n";
        $str .= "<li class=\"active\"><a href=\"#" . $data[0]['tableName'] . "\"  data-toggle=\"tab\">" . $data[0]['tableName'] . "</a></li>\n";
        for ($d = 0; $d < $tabCounter; $d++) {
            $str.="\n\n\n<li><a href=\"#" . $dataTabDetail[$d][0]['tableName'] . "\"  data-toggle=\"tab\">" . $dataTabDetail[$d][0]['tableName'] . "</a></li>\n";
        }
        $str.="</ul>\n";
        $str .="</header>\n";
        $str .= "\n\n\n<div class=\"tab-content\">";
        $str .= "\n\n\n<div class=\"tab-pane active\" id=\"" . $data[0]['tableName'] . "\">\n";
        $str .= "   <div class=\"row\">\n";
        $str .= "    <div class=\"col-xs-12 col-sm-12 col-md-12\">\n";
        $d = 1;
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['columnName'] != 'executeBy' &&
                    $data[$i]['columnName'] != 'executeTime' &&
                    $data[$i]['columnName'] != 'isDefault' &&
                    $data[$i]['columnName'] != 'isApproved' &&
                    $data[$i]['columnName'] != 'isPost' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isNew' &&
                    $data[$i]['columnName'] != 'isDraft' &&
                    $data[$i]['columnName'] != 'isUpdate' &&
                    $data[$i]['columnName'] != 'isActive' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'journalNumber'
            ) {
                $d++;
                switch ($data[$i]['field']) {
                    case 'varchar':
                    case 'text':
                    case 'string':
                        // check if field name have Code.. Max for character.
                        $pos = strpos($data[$i]['columnName'], 'Code');
                        if ($pos !== false) {

                            $str .= "\n\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                            $str .= " <label class=\"control-label col-xs-4 col-sm-4 col-md-4 col-lg-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                            $str .= "  <div class=\"col-xs-8 col-sm-8 col-md-8 col-lg-8\">\n";
                            $str .= "   <div class=\"input-group\">\n";
                            $str .= "    <input class=\"form-control\" type=\"text\" name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\"  
						onKeyUp=\"removeMeError('" . $data[$i]['columnName'] . "')\" 
						value=\"<?php if(isset(\$" . $data[0]['tableName'] . "Array) && is_array(\$" . $data[0]['tableName'] . "Array)) {  
						if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) { echo htmlentities(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']); } } ?>\" maxlength=\"16\">\n";
                            $str .= "    <span class=\"input-group-addon\"><img src=\"./images/icons/document-code.png\"></span></div>\n";
                            $str .= "   <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                            $str .= " </div>\n";
                            $str .= "</div>\n";
                        } else {
                            if (intval(str_replace(array("varchar", "(", ")"), "", $data[$i]['Type'])) == '512') {
                                // textarea no need to validate
                                $str .= "\n\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                                $str .= " <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                                $str .= "  <div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                                $str .= "   <textarea class=\"form-control\" name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\">";
                                $str .= "<?php if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {\n
																		echo htmlentities(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']);\n 
																	  } ?></textarea>\n";
                                $str .= "  <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                                $str .= " </div>\n";
                                $str .= "</div>\n";
                            } else {
                                if ($data[$i]['columnName'] == 'documentNumber') {
                                    // document number no need to validate
                                    $str .= "\n\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                                    $str .= " <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";

                                    $str.="	<div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                                    $str.="		<div class=\"input-group\">\n";
                                    $str.="			<input type=\"text\" name=\"documentNumber\" id=\"documentNumber\" class=\" form-control disabled\" disabled value=\"<?php if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {\n";
                                    $str.="					   if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) { echo htmlentities(\$" . $data[0]['tableName'] . "Array[0]['documentNumber']); } \n";
                                    $str.="				   } ?>\"><span class=\"input-group-addon\"><img src=\"./images/icons/document-number.png\"></span></div>\n";
                                    $str.="		<span class=\"help-block\" id=\"documentNumberHelpMe\"></span>\n";
                                    $str.="	</div>\n";
                                    $str.="</div>\n";
                                } else {
                                    $str .= "\n\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                                    $str .= "  <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                                    $str .= "  <div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                                    $str .= "   <input class=\"form-control\" type=\"text\" name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\"";
                                    if ($data[$i]['validate'] == 1) {
                                        $str .= " onKeyUp=\"removeMeError('" . $data[$i]['columnName'] . "')\" ";
                                    }
                                    $str .= " value=\"<?php if(isset(\$" . $data[0]['tableName'] . "Array) && is_array(\$" . $data[0]['tableName'] . "Array)) {  if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) { echo htmlentities(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']); } } ?>\">\n";
                                    $str .= "   <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                                    $str .= " </div>\n";
                                    $str .= "</div>\n";
                                }
                            }
                        }
                        break;
                    case 'double':
                    case 'float':
                        $str .= "\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                        $str .= " <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                        $str .= " <div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                        $str .= "  <div class=\"input-group\">\n";
                        $str .= "   <input class=\"form-control\" type=\"text\" name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\" ";
                        if ($data[$i]['validate'] == 1) {
                            $str .= " onKeyUp=\"removeMeError('" . $data[$i]['columnName'] . "')\" ";
                        }
                        $str .= " value=\"<?php if(isset(\$" . $data[0]['tableName'] . "Array) && is_array(\$" . $data[0]['tableName'] . "Array)) {  if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) { echo htmlentities(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']); }  } ?>\">\n";
                        $str .= "   <span class=\"input-group-addon\"><img src=\"./images/icons/currency.png\"></span></div>\n";
                        $str .= "   <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                        $str .= "  </div>\n";
                        $str .= "</div>\n";
                        break;
                    case 'int':
                        if ($data[$i]['Key'] == 'PRI') {
                            // don't do anything for primary key. input hidden all ready cater for it
                        } else if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
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
                            // combo box no need to validate  since will take default value 
                            $str .= "\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                            $str .= " <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                            $str .= " <div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                            $str .= "  <select name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\" class=\"form-control  chzn-select\">\n";
                            $str .= "   <option value=\"\"></option>\n";
                            $str .= "   <?php	if (is_array(\$" . str_replace('Id', '', $data[$i]['columnName']) . "Array)) {\n";
                            $str .= "   \$totalRecord = intval(count(\$" . str_replace('Id', '', $data[$i]['columnName']) . "Array));\n";
                            $str .= "   if(\$totalRecord > 0 ){ \n";
                            $str .= "												\$d=1;\n";
                            $str .= "												for (\$i = 0; \$i < \$totalRecord; \$i++) {\n";
                            $str .= "													if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {\n";
                            $str .= "														if(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']==\$" . str_replace('Id', '', $data[$i]['columnName']) . "Array[\$i]['" . $data[$i]['columnName'] . "']){\n";
                            $str .= "															\$selected=\"selected\";\n";
                            $str .= "														} else {\n";
                            $str .= "                                             				\$selected=NULL;\n";
                            $str .= "														}\n";
                            $str .= "													} else {\n";
                            $str .= "                                             			\$selected=NULL;\n";
                            $str .= "                                         			} ?>\n";
                            $str .= " <option value=\"<?php echo \$" . str_replace('Id', '', $data[$i]['columnName']) . "Array[\$i]['" . $data[$i]['columnName'] . "']; ?>\" <?php echo \$selected; ?>><?php echo \$d; ?>. <?php echo \$" . str_replace('Id', '', $data[$i]['columnName']) . "Array[\$i]['" . $field . "']; ?></option> \n";
                            $str .= " <?php               \$d++;\n";
                            $str .= "   }\n";
                            $str .= "    }   else { ?>\n";
                            $str .= "    <option value=\"\"><?php echo \$t['notAvailableTextLabel']; ?></option>\n";
                            $str .= "   <?php		}\n";
                            $str .= "   } else { ?>\n";
                            $str .= "   <option value=\"\"><?php echo \$t['notAvailableTextLabel']; ?></option>\n";
                            $str .= "  <?php } ?>\n";
                            $str .= "  </select>\n";
                            $str .= "  <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                            $str .= " </div>\n";
                            $str .= "</div>\n";
                        } else if ($data[$i]['Key'] == '') {
                            if ($data[$i]['columnName'] == 'executeBy') {
                                
                            } else {
                                // execute by no need to validate 
                                $str .= "\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                                $str .= "                 		<label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                                $str .= "						<div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                                $str .= "							<div class=\"input-group\">\n";
                                $str .= "							<input class=\"form-control\" type=\"text\" name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\"\n";
                                $str .= "							value=\"<?php	if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {
																					if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {
																					echo htmlentities(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']);
																				} 
																				} ?>\">\n";
                                $str .= "							<span class=\"input-group-addon\"><img src=\"./images/icons/sort-number.png\"></span></div>\n";
                                $str .= "							<span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                                $str .= "						</div>\n";
                                $str .= "</div>\n";
                            }
                        }
                        break;
                    case 'tiny':
                    case 'bool':
                        if ($data[$i]['columnName'] != 'isDefault' &&
                                $data[$i]['columnName'] != 'isApproved' &&
                                $data[$i]['columnName'] != 'isPost' &&
                                $data[$i]['columnName'] != 'isDelete' &&
                                $data[$i]['columnName'] != 'isNew' &&
                                $data[$i]['columnName'] != 'isDraft' &&
                                $data[$i]['columnName'] != 'isUpdate' &&
                                $data[$i]['columnName'] != 'isDelete' &&
                                $data[$i]['columnName'] != 'isActive' &&
                                $data[$i]['columnName'] != 'isSlice' &&
                                $data[$i]['columnName'] != 'isSingle' &&
                                $data[$i]['columnName'] != 'isReview' &&
                                $data[$i]['columnName'] != 'isConsolidation'
                        ) {
                            $checkbox = true;
                            $str .= "\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                            $str .= "  <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                            $str .= "  <div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                            $str .= "    <input class=\"form-control\" type=\"checkbox\" name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\" 
						value=\"<?php if(isset(\$" . $data[0]['tableName'] . "Array) && is_array(\$" . $data[0]['tableName'] . "Array)) {
                        if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {
						echo \$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'];
						}
                    } ?>\" <?php if(isset(\$" . $data[0]['tableName'] . "Array) && is_array(\$" . $data[0]['tableName'] . "Array)) {
                        if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {
							if($" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']==TRUE || $" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']==1){
							echo \"checked\";
						}
                    } } ?>>\n";

                            $str .= "   <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                            $str .= " </div>\n";
                            $str .= "</div>\n";
                        }
                        break;
                    case 'time':
                        $str .= "\n\n<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                        $str .= " <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";

                        $str .= " <div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                        $str .= "  <div class=\"input-group bootstrap-timepicker\">\n";
                        $str .= "   <input class=\"form-control\" id=\"" . $data[$i]['columnName'] . "\" name=\"" . $data[$i]['columnName'] . "\" type=\"text\" class=\"form-control\" value=\"<?php if(isset(\$" . $data[0]['tableName'] . "Array) && is_array(\$" . $data[0]['tableName'] . "Array)) {
                        if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {
						echo \$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'];
						}
                    } ?>\">\n";
                        $str .= "   <span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-time\"></i></span>\n";
                        $str .= "   </div>\n";
                        $str .= "  <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                        $str .= " </div>\n";
                        $str .= "</div>\n";

                        break;
                    case 'date':
                    case 'datetime':
                        //must check data type if date .. convert output to master setting date
                        // no need to validate
                        if ($data[$i]['field'] == 'date') {
                            $str .= "\n\n<?php if(isset(\$" . $data[0]['tableName'] . "Array) && is_array(\$" . $data[0]['tableName'] . "Array)) {
                        \n";
                            $str .= "   if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {\n";
                            $str .= "   \$valueArray = \$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "']; \n";
                            $str .= "   if (\$dateConvert->checkDate(\$valueArray)) {\n";
                            $str .= "       \$valueData = explode('-', \$valueArray); \n";
                            $str .= "       \$year = \$valueData[0]; \n";
                            $str .= "       \$month = \$valueData[1];\n";
                            $str .= "       \$day = \$valueData[2];\n";
                            $str .= "       \$value = date(\$systemFormat['systemSettingDateFormat'], mktime(0, 0, 0, \$month, \$day, \$year));\n";
                            $str .= "   } else {\n";
                            $str .= "      \$value =null; \n";
                            $str .= "   }\n } } else { \$value=null; } ?>\n";
                            $str .= "<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                            $str .= " <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                            $str .= " <div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                            $str .= "  <div class=\"input-group\">\n";
                            $str .= "   <input class=\"form-control\" type=\"text\" name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\" value=\"<?php if(isset(\$value)) {
                        echo \$value;
                    } ?>\" >\n";
                            $str .= "   <span class=\"input-group-addon\"><img src=\"./images/icons/calendar.png\" id=\"" . $data[$i]['columnName'] . "Image\"></span></div>\n";
                            $str .= "   <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                            $str .= " </div>\n";
                            $str .= "</div>\n";
                        } else if ($data[$i]['field'] == 'datetime') {
                            if ($data[$i]['columnName'] != 'executeTime') {
                                $str .= "\n\n<?php if(isset(\$" . $data[0]['tableName'] . "Array) && is_array(\$" . $data[0]['tableName'] . "Array)) { \n";
                                $str .= "   if(isset(\$" . $data[0]['tableName'] . "Array[0]['" . $data[$i]['columnName'] . "'])) {\n";

                                $str .= "   \$valueArray = \$" . $data[0]['tableName'] . "Array[0]['executeTime']; \n";
                                $str .= "   if (\$dateConvert->checkDateTime(\$valueArray)) {\n";
                                $str .= "       \$valueArrayDate = explode(' ', \$valueArray); \n";
                                $str .= "       \$valueArrayFirst = \$valueArrayDate[0]; \n";
                                $str .= "       \$valueArraySecond = \$valueArrayDate[1]; \n";

                                $str .= "       \$valueDataFirst = explode('-', \$valueArrayFirst); \n";
                                $str .= "       \$year = \$valueDataFirst[0]; \n";
                                $str .= "       \$month = \$valueDataFirst[1]; \n";
                                $str .= "       \$day = \$valueDataFirst[2]; \n";

                                $str .= "       \$valueDataSecond = explode(':', \$valueArraySecond); \n";
                                $str .= "       \$hour = \$valueDataSecond[0]; \n";
                                $str .= "       \$minute = \$valueDataSecond[1];\n";
                                $str .= "       \$second = \$valueDataSecond[2];\n";

                                $str .= " \$value = date(\$systemFormat['systemSettingDateFormat'].\" \".\$systemFormat['systemSettingTimeFormat'],mktime(\$hour,\$minute,\$second,\$month,\$day,\$year)); \n";
                                $str .= "   } else { \n";
                                $str .= "       \$value=null;\n";
                                $str .= "   } }  } else { \$value=null; } ?>\n";
                                $str .= " <div class=\"form-group\" id=\"" . $data[$i]['columnName'] . "Form\">\n";
                                $str .= "  <label class=\"control-label col-xs-4 col-sm-4 col-md-4\" for=\"" . $data[$i]['columnName'] . "\"><strong><?php echo ucfirst(\$leafTranslation['" . $data[$i]['columnName'] . "Label']); ?></strong></label>\n";
                                $str .= "  <div class=\"col-xs-8 col-sm-8 col-md-8\">\n";
                                $str .= "   <input class=\"form-control\" type=\"text\" name=\"" . $data[$i]['columnName'] . "\" id=\"" . $data[$i]['columnName'] . "\" value=\"<?php if(isset(\$value)) { echo \$value; } ?>\" >\n";
                                $str .= "    <span class=\"help-block\" id=\"" . $data[$i]['columnName'] . "HelpMe\"></span>\n";
                                $str .= "  </div>\n";
                                $str .= "</div>\n";
                            }
                        }


                        break;
                    default :
                        $str .= " Cannot Resolve  Type :[ " . $data[$i]['formType'] . "]";
                }
                if ($d == 2) {
                    $str .= " </div>\n";
                    $str .= "</div>\n";
                    // last line might not generated.generated for first loop only
                    if ($i != $total) {
                        $str .= "\n\n\n\n<div class=\"row\">\n";
                        $str .= " <div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">\n";
                    }
                    $d = 0;
                }
            }
        }
        $str .= "  </div>\n";
        $str .= " </div>\n";
        $str .= "</div>\n";

        // okay here depend how much panel we got
        for ($d = 0; $d < $tabCounter; $d++) {
            $str.="\n\n\n<div class=\"tab-pane fade\" id=\"" . $dataTabDetail[$d][0]['tableName'] . "\">\n";
            $str.=" <table class =\"table table-bordered table-striped table-condensed table-hover smart-form has-tickbox\" id=\"tableData\">\n";


            $str.="  <thead>\n";
            $str.="   <tr>\n";
            for ($i = 0; $i < count($dataTabDetail[$d]); $i++) {
                if ($dataTabDetail[$d][$i]['columnName'] != 'executeBy' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'executeTime' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isDefault' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isApproved' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isPost' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isDelete' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isNew' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isDraft' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isUpdate' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isActive' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'companyId' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'isReview' &&
                        $dataTabDetail[$d][$i]['columnName'] != 'journalNumber' &&
                        $dataTabDetail[$d][$i]['columnName'] != $dataTabDetail[$d][0]['tableName'] . "LineNumber" &&
                        $dataTabDetail[$d][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                        $dataTabDetail[$d][$i]['columnName'] != $dataTabDetail[$d][$i]['primaryKeyName']
                ) {
                    $str.="     <th><?php echo ucwords(\$leafTranslation['" . $dataTabDetail[$d][$i]['columnName'] . "Label']); ?></th>\n";
                }
            }
            $str.=" </tr>\n";
            $str.="</thead>\n\n";
            $str.="<tbody>\n";
            for ($counter = 0; $counter < $targetMaxRecordTab; $counter++) {
                $str.=" <tr>\n";
                for ($i = 0; $i < count($dataTabDetail[$d]); $i++) {
                    switch ($dataTabDetail[$d][$i]['field']) {
                        case 'varchar':
                        case 'text':
                        case 'string':
                            // check if field name have Code.. Max for character.
                            $pos = strpos($dataTabDetail[$d][$i]['columnName'], 'Code');
                            if ($pos !== false) {
                                $str .=" <td vAlign=\"top\" align=\"center\"><input class=\"form-control\" type=\"text\" name=\"" . $dataTabDetail[$d][$i]['columnName'] . "[]\" id=\"" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "\" value=\"<?php echo \$" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "; ?>\" maxlength=\"16\"></td>\n";
                            } else if ($dataTabDetail[$d][$i]['columnName'] != 'journalNumber' || $dataTabDetail[$d][$i]['columnName'] != 'documentNumber') {
                                $str .= "<td vAlign=\"top\" align=\"center\"><input class=\"form-control\" type=\"text\" name=\"" . $dataTabDetail[$d][$i]['columnName'] . "[]\" id=\"" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "\" value=\"<?php echo \$" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "; ?>\"></td>\n";
                            }
                            break;
                        case 'double' : // currency figure
                        case 'float':
                            $str .= " <td vAlign=\"top\" align=\"center\"><input class=\"form-control\" type=\"text\" name=\"" . $dataTabDetail[$d][$i]['columnName'] . "[]\" id=\"" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "\" value=\"<?php echo \$" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "; ?>\"></td>\n";
                            break;
                        case 'int':
                            if ($dataTabDetail[$d][$i]['columnName'] != $data[0]['primaryKeyName'] && 
							    $dataTabDetail[$d][$i]['columnName'] != $dataTabDetail[$d][0]['tableName'] . "LineNumber") {
                                if ($dataTabDetail[$d][$i]['Key'] == 'PRI') {
                                    // don't do anything for primary key. input hidden all ready cater for it
                                } else if ($dataTabDetail[$d][$i]['Key'] == 'MUL') {
                                    // here auto filter main table who had detail
                                    if ($dataTabDetail[$d][$i]['columnName'] != 'executeBy' && $dataTabDetail[$d][$i]['columnName'] != 'companyId' && $dataTabDetail[$d][$i]['columnName'] != $dataTabDetail[0]['primaryKeyName']) {
                                        $str .= " <td vAlign=\"top\" align=\"left\">\n";
                                        $str .= "	<select name=\"" . $dataTabDetail[$d][$i]['columnName'] . "[]\" id=\"" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "\" class=\"chzn-select form-control\">\n";
                                        $str .= "          <option value=\"\"><?php echo \$t['pleaseSelectTextLabel']; ?></option>\n";

                                        $str .= "          <?php if (is_array(\$" . str_replace('Id', '', $dataTabDetail[$d][$i]['columnName']) . "Array)) {\n";
                                        $str .= "          \$totalRecord = intval(count(\$" . str_replace('Id', '', $dataTabDetail[$d][$i]['columnName']) . "Array));\n";
                                        $str .= "          if(\$totalRecord > 0 ){ \n";
                                        $str .= "          for (\$i = 0; \$i < \$totalRecord; \$i++) {\n";
                                        $str .= "              if(\$" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "==\$" . str_replace('Id', '', $dataTabDetail[$d][$i]['columnName']) . "Array[\$i]['" . $dataTabDetail[$d][$i]['columnName'] . "']){\n";
                                        $str .= "           \$selected='selected';\n";
                                        $str .= "          } else {\n";
                                        $str .= "            \$selected=NULL;\n";
                                        $str .= "          } ?>\n";
                                        $str .= " <option value=\"<?php echo \$" . str_replace('Id', '', $dataTabDetail[$d][$i]['columnName']) . "Array[\$i]['" . $dataTabDetail[$d][$i]['columnName'] . "']; ?>\" <?php echo \$selected; ?>><?php echo \$" . str_replace('Id', '', $dataTabDetail[$d][$i]['columnName']) . "Array[\$i]['" . str_replace('Id', '', $dataTabDetail[$d][$i]['columnName']) . "Description']; ?></option>\n";
                                        $str .= "          <?php }\n";
                                        $str .= "     }   else { ?>\n";
                                        $str .= "		<option value=\"\"><?php echo \$t['notAvailableTextLabel']; ?></option>\n";
                                        $str .= "       <?php }";
                                        $str .= "     } else { ?>\n";
                                        $str .= "	<option value=\"\"><?php echo \$t['notAvailableTextLabel']; ?></option>\";\n";
                                        $str .= "<?php } ?>\"\n";


                                        $str .= "</select></td>\n";
                                    }
                                } else if ($dataTabDetail[$d][$i]['Key'] == '') {
                                    if ($dataTabDetail[$d][$i]['columnName'] == 'executeBy') {
                                        //  $str .= "\$str.=\"<td vAlign=\\\"top\\\" align=\\\"center\\\"><input class=\\\"form-control\\\" type=\\\"text\\\" name=\\\"" . $dataTabDetail[$d][$i]['columnName'] . "[]\\\" id=\\\"" . $dataTabDetail[$d][$i]['columnName'] . "\".\$items[\$j]['" . $dataTabDetail[0]['primaryKeyName'] . "'].\"\\\" value=\\\"\".\$items[\$j]['staffName'].\"\\\" readOnly>\n";
                                        //  $str .= "                 </td>\";\n";
                                    } else {
                                        if ($dataTabDetail[$d][$i]['columnName'] != $dataTabDetail[0]['tableName'] . 'LineNumber') {
                                            $str .= "<td vAlign=\"top\" align=\"center\"><input class=\"form-control\" type=\"text\" name=\"" . $dataTabDetail[$d][$i]['columnName'] . "[]\" id=\"" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "\" value=\"<?php echo \$" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "; ?>\"></td>\n";
                                        }
                                    }
                                }
                            }
                            break;
                        case 'tiny':
                        case 'bool';
                            if ($dataTabDetail[$d][$i]['columnName'] != 'isDefault' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isApproved' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isPost' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isDelete' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isNew' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isDraft' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isUpdate' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isDelete' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isActive' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isSlice' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isSingle' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isReview' &&
                                    //special flag
                                    $dataTabDetail[$d][$i]['columnName'] != 'isInvestment' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isRule78' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isPromiseDate' &&
                                    $dataTabDetail[$d][$i]['columnName'] != 'isConsolidation'
                            ) {
                                $str .= "    <td vAlign=\"top\" align=\"center\"><input class=\"form-control\" type=\"checkbox\" name=\"" . $dataTabDetail[$d][$i]['columnName'] . "[]\" id=\"" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "\" value=\"<?php echo \$" . $dataTabDetail[$d][$i]['columnName'] . "+" . $counter . "; ?>\"></td>\n";
                            }
                            break;

                        case 'date':
                        case 'datetime':
                            //must check data type if date .. convert output to master setting date

                            if ($dataTabDetail[$d][$i]['field'] == 'date') {
                                $str .= "<?php if(isset(\$" . $dataTabDetail[0]['tableName'] . "Array[\$i]['" . $dataTabDetail[$d][$i]['columnName'] . "'])) { \n";
                                $str .= " \$valueArray = \$" . $dataTabDetail[0]['tableName'] . "Array[\$i]['" . $dataTabDetail[$d][$i]['columnName'] . "'];\n";
                                $str .= " \$valueData = explode('-', \$valueArray);\n";
                                $str .= " \$year = \$valueData[0];\n";
                                $str .= " \$month = \$valueData[1]; \n";
                                $str .= " \$day = \$valueData[2];\n";
                                $str .= " \$value = date(\$systemFormat['systemSettingDateFormat'], mktime(0, 0, 0, \$month, \$day, \$year));\n";
                                $str .= " } else { \$value=null; }  ?>\n";
                                $str .= " <td vAlign=\"top\" align=\"center\"><input class=\"form-control\" type=\"text\" name=\"" . $dataTabDetail[$d][$i]['columnName'] . "\"  id=\"" . $dataTabDetail[$d][$i]['columnName'] . "\"  value=\"<?php echo \$value; ?>\"></td>\n";
                            } else if ($dataTabDetail[$d][$i]['field'] == 'datetime') {
                                $str .= "<?php if(isset(\$" . $dataTabDetail[0]['tableName'] . "Array[\$i]['" . $dataTabDetail[$d][$i]['columnName'] . "'])) { \n";
                                $str .= " \$valueArray = \$" . $dataTabDetail[0]['tableName'] . "Array[\$i]['" . $dataTabDetail[$d][$i]['columnName'] . "'];\n";
                                $str .= " \$valueArrayDate = explode(' ', \$valueArray);\n";
                                $str .= " \$valueArrayFirst = \$valueArrayDate[0];\n";
                                $str .= " \$valueArraySecond = \$valueArrayDate[1];\n";
                                $str .= " \$valueDataFirst = explode('-', \$valueArrayFirst); \n";
                                $str .= " \$year = \$valueDataFirst[0];\n";
                                $str .= " \$month = \$valueDataFirst[1];\n";
                                $str .= " \$day = \$valueDataFirst[2]; \n";
                                $str .= " \$valueDataSecond = explode(':', \$valueArraySecond); \n";
                                $str .= " \$hour = \$valueDataSecond[0];\n";
                                $str .= " \$minute = \$valueDataSecond[1];\n";
                                $str .= " \$second = \$valueDataSecond[2]; \n";

                                $str .= " \$value = date(\$systemFormat['systemSettingDateFormat'].\" \".\$systemFormat['systemSettingTimeFormat'],mktime(\$hour,\$minute,\$second,\$month,\$day,\$year)); \n";
                                $str .= " } else { \$value=null; } ?>\n";
                                if ($dataTabDetail[$d][$i]['columnName'] != 'executeTime') {

                                    $str .= "     <td vAlign=\"top\" align=\"center\"><input class=\"form-control\" type=\"text\" name=\"" . $dataTabDetail[$d][$i]['columnName'] . "\" id=\"" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "\" value=\" <?php echo \$value; ?>\"></td>\n";
                                } else {
                                    $str .= "     <td vAlign=\"top\" align=\"center\"><input class=\"form-control\" type=\"text\" name=\"" . $dataTabDetail[$d][$i]['columnName'] . "\" id=\"" . $dataTabDetail[$d][$i]['columnName'] . "_" . $counter . "\" value=\"<?php echo \$value; ?>\" readOnly></td>\n";
                                }
                            }


                            break;
                        default :
                        // $str.=" unknown";
                    }
                }
                $str .= "    </tr>\n";
            }
            $str .="  </tbody>\n";
            $str .=" </table>";
            $str .="</div>\n";
        }
        $str .= " 	  </ul>\n";
        $str .= "      <input type=\"hidden\" name=\"firstRecordCounter\" id=\"firstRecordCounter\" value=\"<?php if(isset(\$firstRecord)) { echo intval(\$firstRecord); } ?>\"> \n";
        $str .= "      <input type=\"hidden\" name=\"nextRecordCounter\" id=\"nextRecordCounter\" value=\"<?php if(isset(\$nextRecord)) { echo intval(\$nextRecord); } ?>\"> \n";
        $str .= "      <input type=\"hidden\" name=\"previousRecordCounter\" id=\"previousRecordCounter\" value=\"<?php if(isset(\$previousRecord)) { echo intval(\$previousRecord); } ?>\"> \n";
        $str .= "      <input type=\"hidden\" name=\"lastRecordCounter\" id=\"lastRecordCounter\" value=\"<?php if(isset(\$lastRecord)) { echo intval(\$lastRecord); } ?>\"> \n";
        $str .= "      <input type=\"hidden\" name=\"endRecordCounter\" id=\"endRecordCounter\" value=\"<?php if(isset(\$endRecord)) { echo intval(\$endRecord); } ?>\"> \n";
        $str .= "     </div>\n";
        $str .= "    </div>\n";
        $str .= "   </div>\n";
        $str .= "  </div>\n";
        $str .= " </div>\n";
        $str .= "</form>\n";

        // here will be detail table
        // end of detail table
        $str .= "\n\n\n<script type=\"text/javascript\"> \n";
        $str .= " \$(document).ready(function(){  \n";
        $str .= "  \$('#myTab a').click(function (e) {\n";
        $str .= "  e.preventDefault();\n";
        $str .= "  \$(this).tab('show');\n";
        $str .= "  })\n";
        $str .= " \$(document).scrollTop(0);\n";
        $str .= " \$(\".chzn-select\").chosen({ search_contains: true });\n";
        $str .= " \$(\".chzn-select-deselect\").chosen({allow_single_deselect:true});\n";

        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['columnName'] != 'executeBy' &&
                    $data[$i]['columnName'] != 'executeTime' &&
                    $data[$i]['columnName'] != 'isDefault' &&
                    $data[$i]['columnName'] != 'isApproved' &&
                    $data[$i]['columnName'] != 'isPost' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isNew' &&
                    $data[$i]['columnName'] != 'isDraft' &&
                    $data[$i]['columnName'] != 'isUpdate' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isActive' &&
                    $data[$i]['columnName'] != 'isSingle' &&
                    $data[$i]['columnName'] != 'isConsolidation' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isReview'
            ) {
                switch ($data[$i]['field']) {
                    case 'varchar':
                    case 'text':
                    case 'string':
                        $str .= " validateMeAlphaNumeric('" . $data[$i]['columnName'] . "'); \n";
                        break;
                    case 'double':
                    case 'float':
                        $str .= " validateMeCurrency('" . $data[$i]['columnName'] . "'); \n";
                        break;
                    case 'int':
                        if ($data[$i]['columnName'] != 'executeBy' && $data[$i]['columnName'] != 'companyId') {
                            $str .= " validateMeNumeric('" . $data[$i]['columnName'] . "'); \n";
                        }
                        break;
                    case 'date':

                        $str .= " \$('#" . $data[$i]['columnName'] . "').datepicker({ \n";
                        $str .= "  format :\"<?php echo  \$systemFormat['systemSettingDateFormat']; ?>\"\n";
                        $str .= " }).on('changeDate', function () {\n";
                        $str .= "  \$(this).datepicker('hide');\n";
                        $str .= " });   \n";
                        break;
                    case 'datetime':
                        if ($data[$i]['columnName'] != 'executeTime') {
                            $str .= " \$('#" . $data[$i]['columnName'] . "').datepicker({ \n";
                            $str .= "   format :\"<?php echo \$systemFormat['systemSettingDateFormat'].\$systemFormat['systemSettingTimeFormat']; ?>\"\n";
                            $str .= " }).on('changeDate', function () {\n";
                            $str .= "  \$(this).datepicker('hide');\n";
                            $str .= " });   \n";
                        }
                        break;
                    case 'time':
                        $str .= " $('#" . $data[$i]['columnName'] . "').timepicker();\n";
                        break;
                    case 'tiny':
                    case 'bool':
                        if ($data[$i]['columnName'] != 'isDefault' &&
                                $data[$i]['columnName'] != 'isApproved' &&
                                $data[$i]['columnName'] != 'isPost' &&
                                $data[$i]['columnName'] != 'isDelete' &&
                                $data[$i]['columnName'] != 'isNew' &&
                                $data[$i]['columnName'] != 'isDraft' &&
                                $data[$i]['columnName'] != 'isUpdate' &&
                                $data[$i]['columnName'] != 'isDelete' &&
                                $data[$i]['columnName'] != 'isActive' &&
                                $data[$i]['columnName'] != 'isReview'
                        ) {
                            $str .= " $('#" . $data[$i]['columnName'] . "').bootstrapSwitch();\n";
                        }
                        break;
                    default :
                        $str .= "what time ya" . $data[$i]['formType'];
                }
            }
        }

        for ($i = 0; $i < $dataTabDetail[$d]['total']; $i++) {
            switch ($dataTabDetail[$d][$i]['field']) {
                case 'varchar':
                case 'text':
                case 'string':
                    $str .= " validateMeAlphaNumericRange('" . $dataTabDetail[$d][$i]['columnName'] . "'); \n";
                    break;
                case 'double':
                case 'float':
                    $str .= " validateMeCurrencyRange('" . $dataTabDetail[$d][$i]['columnName'] . "'); \n";
                    break;
                case 'int':
                    if ($dataTabDetail[$i]['columnName'] != 'executeBy' && $dataTabDetail[$i]['columnName'] != 'companyId') {
                        $str .= " validateMeNumericRange('" . $dataTabDetail[$d][$i]['columnName'] . "'); \n";
                    }
                    break;
                case 'bool':
                    if ($data[$i]['columnName'] != 'isDefault' &&
                            $data[$d][$i]['columnName'] != 'isApproved' &&
                            $data[$d][$i]['columnName'] != 'isPost' &&
                            $data[$d][$i]['columnName'] != 'isDelete' &&
                            $data[$d][$i]['columnName'] != 'isNew' &&
                            $data[$d][$i]['columnName'] != 'isDraft' &&
                            $data[$d][$i]['columnName'] != 'isUpdate' &&
                            $data[$d][$i]['columnName'] != 'isDelete' &&
                            $data[$d][$i]['columnName'] != 'isActive' &&
                            $data[$d][$i]['columnName'] != 'isReview'
                    ) {
                        $str .= "             $('" . $data[$d][$i]['columnName'] . "').bootstrapSwitch();\n";
                    }
                    break;
            }
        }

        $str .= " <?php if(\$_POST['method']==\"new\") { ?> \n";
        $str .= "  \$('#resetRecordButton').removeClass().addClass('btn btn-info'); \n";
        $str .= " <?php if(\$leafAccess['leafAccessCreateValue']==1) { ?> \n";

        //remove classes

        $str .= "   \$('#newRecordButton1').removeClass().addClass('btn btn-success').attr('onClick', \"newRecord(<?php echo \$leafId; ?>,'<?php  echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php  echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',1)\"); \n";
        $str .= "   \$('#newRecordButton2').removeClass().addClass('btn  dropdown-toggle btn-success'); \n";
        $str .= "   \$('#newRecordButton3').attr('onClick', \"newRecord(<?php echo \$leafId; ?>,'<?php  echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php  echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',1)\"); \n";
        $str .= "   \$('#newRecordButton4').attr('onClick', \"newRecord(<?php echo \$leafId; ?>,'<?php  echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php  echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',2)\"); \n";
        $str .= "   \$('#newRecordButton5').attr('onClick', \"newRecord(<?php echo \$leafId; ?>,'<?php  echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php  echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',3)\"); \n";
        $str .= "   \$('#newRecordButton6').attr('onClick', \"newRecord(<?php echo \$leafId; ?>,'<?php  echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php  echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',4)\"); \n";
        $str .= "   \$('#newRecordButton7').attr('onClick', \"newRecord(<?php echo \$leafId; ?>,'<?php  echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php  echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',5)\"); \n";


        $str .= " <?php } else { ?>\n";
        // disabled button if don't have access
        // add disabled class
        $str .= "             \$('#newRecordButton1').removeClass().addClass('btn btn-success disabled').attr('onClick', ''); \n";
        $str .= "             \$('#newRecordButton2').removeClass().addClass('btn dropdown-toggle btn-success disabled'); \n";

        //remove classes
        $str .= "         <?php } ?>";
        $str .= "             \$('#updateRecordButton1').removeClass().addClass('btn btn-info disabled');\n";
        $str .= "             \$('#updateRecordButton2').removeClass().addClass('btn dropdown-toggle btn-info disabled');\n";

        $str .= "             \$('#updateRecordButton1').attr('onClick', ''); \n";
        $str .= "             \$('#updateRecordButton2').attr('onClick', ''); \n";
        $str .= "             \$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "             \$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "             \$('#updateRecordButton5').attr('onClick', ''); \n";

        $str .= "             \$('#deleteRecordButton').removeClass().addClass('btn btn-danger disabled').attr('onClick', ''); \n";
        $str .= "             \$('#firstRecordButton').removeClass().addClass('btn btn-default');  \n";
        $str .= "             \$('#endRecordButton').removeClass().addClass('btn btn-default'); \n";
        $str .= " <?php } else  if (\$_POST['" . $data[0]['primaryKeyName'] . "']) { ?> \n";
// new button segment
// add disabled class
        $str .= "             \$('#newRecordButton1').removeClass().addClass('btn btn-success disabled').attr('onClick', ''); \n";
        $str .= "             \$('#newRecordButton2').removeClass().addClass('btn dropdown-toggle btn-success disabled'); \n";
        $str .= "             \$('#newRecordButton3').attr('onClick', ''); \n";
        $str .= "             \$('#newRecordButton4').attr('onClick', ''); \n";
        $str .= "             \$('#newRecordButton5').attr('onClick', ''); \n";
        $str .= "             \$('#newRecordButton6').attr('onClick', ''); \n";
        $str .= "             \$('#newRecordButton7').attr('onClick', ''); \n";

// end new button segment
// update button segment

        $str .= " <?php if(\$leafAccess['leafAccessUpdateValue']==1) { ?> \n";
        $str .= "             \$('#updateRecordButton1').removeClass().addClass('btn btn-info').attr('onClick', \"updateRecord(<?php echo \$leafId; ?>,'<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',1,<?php echo \$leafAccess['leafAccessDeleteValue']; ?>)\")
	;\n";
// toggle button
        $str .= "             \$('#updateRecordButton2').removeClass().addClass('btn dropdown-toggle btn-info'); \n";
        $str .= "             \$('#updateRecordButton3').attr('onClick', \"updateRecord(<?php echo \$leafId; ?>,'<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',1,<?php echo \$leafAccess['leafAccessDeleteValue']; ?>)\"); \n";
        $str .= "             \$('#updateRecordButton4').attr('onClick', \"updateRecord(<?php echo \$leafId; ?>,'<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',2,<?php echo \$leafAccess['leafAccessDeleteValue']; ?>)\"); \n";
        $str .= "             \$('#updateRecordButton5').attr('onClick', \"updateRecord(<?php echo \$leafId; ?>,'<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',3,<?php echo \$leafAccess['leafAccessDeleteValue']; ?>)\"); \n";
        $str .= " <?php }  else { ?> \n";
        $str .= "             \$('#updateRecordButton1').removeClass().addClass('btn btn-info disabled').attr('onClick', ''); \n";
// toggle button
        $str .= "             \$('#updateRecordButton2').removeClass().addClass('btn dropdown-toggle btn-info disabled'); \n";
        $str .= "             \$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "             \$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "             \$('#updateRecordButton5').attr('onClick', ''); \n";
        $str .= " <?php } ?> \n";

        $str .= " <?php if(\$leafAccess['leafAccessDeleteValue']==1) { ?> \n";
        $str .= "             \$('#deleteRecordButton').removeClass().addClass('btn btn-danger').attr('onClick', \"deleteRecord(<?php echo \$leafId; ?>,'<?php echo \$" . $data[0]['tableName'] . "->getControllerPath(); ?>','<?php  echo \$" . $data[0]['tableName'] . "->getViewPath(); ?>','<?php  echo \$securityToken; ?>',<?php  echo \$leafAccess['leafAccessDeleteValue']; ?>)\"); \n";
        $str .= " <?php }  else { ?> \n";
        $str .= "             \$('#deleteRecordButton').removeClass().addClass('btn btn-danger disabled').attr('onClick', ''); \n";
        $str .= "  <?php } ?>  \n";
        $str .= " <?php } ?>  \n";
        $str .= "         }); \n";
        $str .= "    </script> \n";
        $str .= "<?php } ?> \n";

        $str .= "<script type=\"text/javascript\" src=\"./v3/" . $data[0]['package'] . "/" . $data[0]['module'] . "/javascript/" . $data[0]['tableName'] . ".js\"></script> \n";
    }
// input type hidden
//footer
    $str .= "<hr><footer><p>IDCMS 2012/2013</p></footer>";
    return $str;
}
?>  

