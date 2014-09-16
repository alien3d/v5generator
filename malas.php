<?php

class generator {

    /**
     * Project /Application  Name
     * @var string
     */
    private $project;

    /**
     * Target Database
     * @var string
     */
    private $targetDatabase;

    /**
     * Target table structure
     * @var string
     */
    private $targetTable;

    /**
     * To Target output  grid type either by character or date filtering
     * @var string
     */
    private $targetGridType;

    /**
     * To target output source code generator either it was html ,javascript,controller or model
     * @var string
     */
    private $targetOutput;

    /**
     * To target Package
     * @var string
     */
    private $targetPackage;

    /**
     * To target Module
     * @var string
     */
    private $targetModule;

    /**
     * Twitter Bootstrap  form type  horizontal,vertical,inline,search
     * @var string
     */
    private $targetFormStyle;

    /**
     * To return information about column
     * @var array
     */
    private $infoColumnArray;

    /**
     * Array Of Module
     * @var array
     */
    public $packageAndModule;

    /**
     *
     */
    const DEFAULTDATABASE = 'icore';

    /**
     * Constructor function
     */
    public function __construct() {
        mysql_connect("localhost", "root", "123456");
        $this->packageAndModule = array();

        $this->packageAndModule = array(
            'document' => array(
                'document',
                'numbering'
            ),
            'financial' => array(
                'accountPayable',
                'accountReceivable',
                'businessPartner',
                'cashbook',
                'fixedAsset',
                'generalLedger',
                'humanResource',
                'payroll',
                'project',
            ),
            'sample' => array(
                'midnightMarket',
                'religion'
            ),
            'portal' => array(
                'main'
            ),
            'problem' => array(),
            'system' => array(
                'common',
                'management',
                'security',
                'translation'
        ));
    }

    /**
     * main function
     */
    public function execute() {


        mysql_select_db(self::DEFAULTDATABASE);
        return $this->showCode();
    }

    function htmlForm() {
        // @todo  future using bootstrap style.. 
        ?>
        <script language="javascript">
            function db(value) {
                location.href = '<?php echo basename($_SERVER['PHP_SELF']); ?>?targetDatabase=' + value;
            }
            function changePackage() {

                var targetDatabase = $("#targetDatabase").val();
                var targetTable = $("#targetTable").val();
                var targetMasterTableId = $("#targetMasterTableId").val();
                var targetPackage = $("#targetPackage").val();
                var targetModule = $("#targetModule").val();
                var targetOutput = $("#targetOutput").val()         var targetGridType = $("#targetGridType").val();
                        var targetFormStyle = $("#targetFormStyle").val();

                url = '<?php echo basename($_SERVER['PHP_SELF']); ?>';

                if (targetDatabase) {
                    url = url + "?targetDatabase=" + targetDatabase;
                }
                if (targetTable) {
                    url = url + "&targetTable=" + targetTable;
                }
                if (targetMasterTableId) {
                    url = url + "&targetMasterTableId=" + targetMasterTableId;
                }
                if (targetPackage) {
                    url = url + "&targetPackage=" + targetPackage;
                }
                if (targetModule) {
                    url = url + "&targetModule=" + targetModule;
                }
                if (targetOutput) {
                    url = url + "&targetOutput=" + targetOutput;
                }
                if (targetGridType) {
                    url = url + "&targetGridType=" + targetGridType;
                }
                if (targetFormStyle) {
                    url = url + "&targetFormStyle=" + targetFormStyle;
                }
                location.href = url;
            }
            function check(value) {
                if (value == 'javascript') {
                    document.getElementById('targetGridType').disabled = false;
                } else {
                    document.getElementById('targetGridType').disabled = true;
                }
            }
        </script>
        <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="get">
            <table>


                <tr>
                    <td>Target Db</td>
                    <td><select name="targetDatabase" id="targetDatabase" onChange=db(this.value)>
                            <option value="">Please Select Database First</option>
                            <?php
                            $sql = "show databases;";
                            $result = mysql_query($sql) or die(mysql_error());
                            while ($row = mysql_fetch_array($result)) {
                                ?>

                                <option value="<?php echo $row['Database']; ?>"
                                <?php
                                if (isset($_GET['targetDatabase'])) {
                                    if ($_GET['targetDatabase'] == $row['Database']) {
                                        echo "selected";
                                    }
                                }
                                ?>>
                                            <?php echo $row['Database']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Target Table</td>
                    <td><select name="targetTable" id="targetTable" <?php
                        if (!(isset($_GET['targetDatabase']))) {
                            echo "disabled";
                        }
                        ?> class="<?php
                                if (!(isset($_GET['targetDatabase']))) {
                                    echo "disabled";
                                }
                                ?>">
                                    <?php if (isset($_GET['targetDatabase'])) { ?>
                                <option value="">Please Select Table</option>
                            <?php } else { ?>
                                <option value="">Please Select Database First</option>
                            <?php } ?>
                            <?php
                            if (isset($_GET['targetDatabase'])) {
                                $sql = "show tables in " . strtolower($_GET['targetDatabase']) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($_GET['targetDatabase'])]; ?>"
                                    <?php
                                    if (isset($_GET['targetTable'])) {
                                        if (strtolower($_GET['targetTable']) == strtolower($row['Tables_in_' . strtolower($_GET['targetDatabase'])])) {
                                            echo "selected";
                                        }
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($_GET['targetDatabase'])]; ?></option>
                                            <?php
                                        }
                                    }
                                    ?></select>
                    </td>
                </tr>
                <tr>
                    <td>Target Master Table</td>
                    <td><select name="targetMasterTableId" id="targetMasterTableId" <?php
                        if (!(isset($_GET['targetDatabase']))) {
                            echo "disabled";
                        }
                        ?>>
                                    <?php
                                    if (isset($_GET['targetDatabase'])) {
                                        $sql = "show tables in " . strtolower($_GET['targetDatabase']) . ";";
                                        $result = mysql_query($sql) or die(mysql_error());
                                        while ($row = mysql_fetch_array($result)) {
                                            ?> ?>
                                    <option
                                        value="<?php echo $row['Tables_in_' . strtolower($_GET['targetDatabase'])]; ?>"
                                        <?php
                                        if (isset($_GET['targetMasterTableId'])) {
                                            if (strtolower($_GET['targetMasterTableId']) == strtolower($row['Tables_in_' . strtolower($_GET['targetDatabase'])])) {
                                                echo "selected";
                                            }
                                        }
                                        ?>><?php echo $row['Tables_in_' . strtolower($_GET['targetDatabase'])]; ?></option>
                                        <?php
                                    }
                                }
                                ?></select>
                    </td>
                </tr>
                <?php $total = count($this->packageAndModule); ?>
                <tr>
                    <td>Target Package</td>
                    <td><select name="targetPackage" id="targetPackage" onChange=changePackage() <?php
                        if (!(isset($_GET['targetDatabase']))) {
                            echo "disabled";
                        }
                        ?>>
                            <option value="">Please Choose Package</option>
                            <?php foreach ($this->packageAndModule as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"

                                        <?php
                                        if (isset($_GET['targetPackage'])) {
                                            if ($_GET['targetPackage'] == $key) {
                                                echo "selected";
                                            }
                                        }
                                        ?>>
                                    <?php echo $key; ?></option>
                            <?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Target Module</td>
                    <td><select name="targetModule" id="targetModule" <?php
                        if (!(isset($_GET['targetDatabase']))) {
                            echo "disabled";
                        }
                        ?>>
                                    <?php if (isset($_GET['targetPackage'])) { ?>
                                <option value="">Please Choose Module</option>

                            <?php } else { ?>
                                <option value="">Please Choose Package</option>
                            <?php } ?>
                            <?php for ($i = 0; $i < count($this->packageAndModule[$_GET['targetPackage']]); $i++) { ?>
                                <option value="<?php echo $this->packageAndModule[$_GET['targetPackage']][$i]; ?>" <?php
                                if (isset($_GET['targetModule'])) {
                                    if ($_GET['targetModule'] == $this->packageAndModule[$_GET['targetPackage']][$i]) {
                                        echo "selected";
                                    }
                                }
                                ?>><?php echo $this->packageAndModule[$_GET['targetPackage']][$i]; ?></option>
                                    <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Source Type</td>
                    <td><select name="targetOutput" id="targetOutput" onChange=check(this.value) <?php
                        if (!(isset($_GET['targetDatabase']))) {
                            echo "disabled";
                        }
                        ?>>
                            <option value="">Please Choose</option>
                            <option value="html"
                            <?php
                            if (isset($_GET['targetOutput'])) {
                                if ($_GET['targetOutput'] == 'html') {
                                    echo "selected";
                                }
                            }
                            ?>>Html Code
                            </option>
                            <option value="javascript"
                            <?php
                            if (isset($_GET['targetOutput'])) {
                                if ($_GET['targetOutput'] == 'javascript') {
                                    echo "selected";
                                }
                            }
                            ?>>Javascript Code
                            </option>
                            <option value="model" <?php
                            if (isset($_GET['targetOutput'])) {
                                if ($_GET['targetOutput'] == 'model') {
                                    echo "selected";
                                }
                            }
                            ?>>Model Entity
                            </option>
                            <option value="controller"
                            <?php
                            if (isset($_GET['targetOutput'])) {
                                if ($_GET['targetOutput'] == 'controller') {
                                    ?> selected <?php
                                        }
                                    }
                                    ?>>Controller
                            </option>
                            <option value="service"
                            <?php
                            if (isset($_GET['targetOutput'])) {
                                if ($_GET['targetOutput'] == 'service') {
                                    ?> selected <?php
                                        }
                                    }
                                    ?>>Service
                            </option>
                        </select></td>
                </tr>
                <tr>
                    <td>Target Form Type</td>
                    <td><select name="targetGridType" id="targetGridType" <?php
                        if (!(isset($_GET['targetDatabase']))) {
                            echo "disabled";
                        }
                        ?>>
                            <option value="first"
                            <?php
                            if (isset($_GET['targetGridType'])) {
                                if ($_GET['targetGridType'] == 'first') {
                                    echo "selected";
                                }
                            }
                            ?>>Form Only
                            </option>
                            <option value="second"
                            <?php
                            if (isset($_GET['targetGridType'])) {
                                if ($_GET['targetGridType'] == 'second') {
                                    echo "selected";
                                }
                            }
                            ?>>Grid Only(Detail)
                            </option>
                            <option value="third"
                            <?php
                            if (isset($_GET['targetGridType'])) {
                                if ($_GET['targetGridType'] == 'third') {
                                    echo "selected";
                                }
                            }
                            ?>>Viewport + Grid Only
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Target Form Style</td>
                    <td><select name="targetFormStyle" id="targetFormStyle" <?php
                                if (!(isset($_GET['targetDatabase']))) {
                                    echo "disabled";
                                }
                                ?>>
                            <option value="form-vertical"
                            <?php
                            if (isset($_GET['targetFormStyle'])) {
                                if ($_GET['targetFormStyle'] == 'form-vertical') {
                                    echo "selected";
                                }
                            }
                            ?>>form-vertical
                            </option>
                            <option value="form-inline"
                            <?php
                            if (isset($_GET['targetFormStyle'])) {
                                if ($_GET['targetFormStyle'] == 'form-inline') {
                                    echo "selected";
                                }
                            }
                            ?>>form-inline
                            </option>
                            <option value="form-horizontal"
                            <?php
                            if (isset($_GET['targetFormStyle'])) {
                                if ($_GET['targetFormStyle'] == 'form-horizontal') {
                                    echo "selected";
                                }
                            }
                            ?>>form-horizontal
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" text="submit"></td>
                    <td><input type="reset" name="reset" text="reset"></td>
                </tr>
            </table>
        </form>
        <?php
    }

    /**
     * Output source code
     */
    public function showCode() {
        // check for financial issue =
        // initialize value
        $infoColumn = array();
        if ($this->getTargetTable()) {
            $sqlDescribe = "            DESCRIBE `" . $this->getTargetDatabase() . "`.`" . $this->getTargetTable() . "`";
            $resultFieldTable = mysql_query($sqlDescribe);
            if (!$resultFieldTable) {
                echo "Error dol" . mysql_error();
            }
            $i = 0;

            while ($rowFieldTable = mysql_fetch_array($resultFieldTable)) {
                // echo "ada loop ";
                //echo print_r($rowFieldTable);
                $infoColumn[0]['project'] = $this->getProject();
                $infoColumn[0]['database'] = $this->getTargetDatabase();
                $infoColumn[0]['tableName'] = $this->getTargetTable();
                $infoColumn[0]['package'] = $this->getTargetPackage();
                $infoColumn[0]['module'] = $this->getTargetModule();
                $infoColumn[0]['targetFormStyle'] = $this->getTargetFormStyle();
                $infoColumn[$i]['columnName'] = $rowFieldTable['Field'];
                $infoColumn[$i]['Type'] = $rowFieldTable['Type'];
                $infoColumn[$i]['Key'] = $rowFieldTable['Key'];
                // cannot follow blindly table name+id for generation
                if ($rowFieldTable['Key'] == 'PRI') {
                    $infoColumn[0]['primaryKeyName'] = $rowFieldTable['Field'];
                }
                $infoColumn[$i]['foreignKey'] = $this->getInfoTableColumn($rowFieldTable['Field']);
                $infoColumn[$i]['length'] = preg_replace("/[^0-9]/", "", $rowFieldTable['Type']);

                $findme = 'varchar';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {

                    $infoColumn[$i]['formType'] = "text";
                }
                $findme = 'char';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {

                    $infoColumn[$i]['formType'] = "text";
                }
                $findme = 'text';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {
                    $infoColumn[$i]['formType'] = "text";
                }
                $findme = 'time';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {
                    $infoColumn[$i]['formType'] = "text";
                }
                $findme = 'int';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {
                    $infoColumn[$i]['formType'] = "int";
                }
                $findme = 'date';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {
                    $infoColumn[$i]['formType'] = "date";
                }
                $findme = 'datetime';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {
                    $infoColumn[$i]['formType'] = "datetime";
                }
                $findme = 'tiny';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {
                    $infoColumn[$i]['formType'] = "tiny";
                }

                $findme = 'double';
                $pos = strpos($rowFieldTable['Type'], $findme);
                if ($pos !== false) {
                    $infoColumn[$i]['formType'] = "double";
                }
                if ($infoColumn[$i]['formType'] == '' || $infoColumn[$i]['formType'] == null) {
                    echo " miau Tell me this type : [" . $rowFieldTable['Type'] . "] [" . $rowFieldTable['Field'] . "]<br>";
                }
                $i++;
            }
            $this->setInfoColumnArray($infoColumn);
            switch ($this->getTargetOutput()) {
                case 'html':
                    return ($this->generateHtml());

                    break;
                case 'javascript':
                    return ($this->generateJavascript());
                    break;
                case 'controller':

                    return ($this->generateController());
                    break;
                case 'model':
                    return ($this->generateModel());
                    break;
                case 'service':
                    return ($this->generateService());
                    break;
                default:
                    return "Please Identify output type";
            }
        }
    }

    /**
     * Bring information column either it was foreign key or not
     * @param string $columnName
     * @return int
     */
    private function getInfoTableColumn($columnName) {

        $sql = "
		SELECT	table_schema, 
			table_name, 
			column_name, 
			referenced_table_schema, 
			referenced_table_name, 
			referenced_column_name
		FROM 	information_schema.KEY_COLUMN_USAGE
		WHERE 	table_schema='" . $this->getTargetDatabase() . "'
		AND 	table_name = '" . $this->getTargetTable() . "'
		AND  	column_name ='" . $columnName . "'		";

        $resultForeignKey = mysql_query($sql) or die(mysql_error());
        $rowForeignKey = mysql_fetch_array($resultForeignKey);
        if ($rowForeignKey['referenced_table_schema'] != null && $rowForeignKey['referenced_table_name'] != null && $rowForeignKey ['referenced_column_name'] != null) {
            $foreignKey = 1;
        } else {
            $foreignKey = 0;
        }
        return $foreignKey;
    }

    /**
     * Generate html Content
     * @return string
     */
    private function generateHtml() {
        // initialize dumy value
        $str = null;
        $data = null;
        $data = $this->getInfoColumnArray();
        include("html.php");
        return $str;
    }

    /**
     * Generate Javascript Content
     * @return string
     */
    private function generateJavascript() {
        // initialize dumy value
        $str = null;
        $data = null;
        $data = $this->getInfoColumnArray();
        include("javascript.php");
        return $str;
    }

    /**
     * Generate Controller Content
     * @return string
     */
    private function generateController() {
        // initialize dumy value
        $str = null;
        $data = null;
        $data = $this->getInfoColumnArray();
        include("controller.php");
        return $str;
    }

    /**
     * Generate Model Content
     * @return string
     */
    private function generateModel() {
        // initialize dumy value
        $str = null;
        $data = null;
        $data = $this->getInfoColumnArray();
        include("model.php");
        return $str;
    }

    /**
     * Generate Service Content.For Foreign Key Only
     * @return string
     */
    private function generateService() {
        // initialize dumy value
        $str = null;
        $data = null;
        $data = $this->getInfoColumnArray();
        include("service.php");
        return $str;
    }

    /**
     * Return Project/Application name
     * return string $targetDatabase
     */
    public function getProject() {
        return $this->project;
    }

    /**
     * Set Target Project/Application name
     * param string $value
     */
    public function setProject($value) {
        $this->project = $value;
    }

    /**
     * Return Target Database
     * return string $targetDatabase
     */
    public function getTargetDatabase() {
        return $this->targetDatabase;
    }

    /**
     * Set Target Database
     * param string $value
     */
    public function setTargetDatabase($value) {
        $this->targetDatabase = $value;
    }

    /**
     * Return Target Table
     * return string $targetTable
     */
    public function getTargetTable() {
        return $this->targetTable;
    }

    /**
     * Set Target Table
     * param string $value
     */
    public function setTargetTable($value) {
        $this->targetTable = $value;
    }

    /**
     * Return Target Grid Type
     * return string $targetTable
     */
    public function getTargetGridType() {
        return $this->targetGridType;
    }

    /**
     * Set Target Grid Type
     * param string $value
     */
    public function setTargetGridType($value) {
        $this->targetGridType = $value;
    }

    /**
     * Return Target Output
     * return string $output
     */
    public function getTargetOutput() {
        return $this->targetOutput;
    }

    /**
     * Set Target Output
     * param string $value
     */
    public function setTargetOutput($value) {
        $this->targetOutput = $value;
    }

    /**
     * Return Target Package
     * return string $output
     */
    public function getTargetPackage() {
        return $this->targetPackage;
    }

    /**
     * Set Target Package
     * param string $value
     */
    public function setTargetPackage($value) {
        $this->targetPackage = $value;
    }

    /**
     * Return Target Module
     * return string $output
     */
    public function getTargetModule() {
        return $this->targetModule;
    }

    /**
     * Set Target Module
     * param string $value
     */
    public function setTargetModule($value) {
        $this->targetModule = $value;
    }

    /**
     * Return Target Output
     * return string $output
     */
    public function getInfoColumnArray() {
        return $this->infoColumnArray;
    }

    /**
     * Set Target Output
     * param string $value
     */
    public function setInfoColumnArray($value) {
        $this->infoColumnArray = $value;
    }

    /**
     * Return Target Output
     * return string $output
     */
    public function getTargetFormStyle() {
        return $this->targetFormStyle;
    }

    /**
     * Set Target Output
     * param string $value
     */
    public function setTargetFormStyle($value) {
        $this->targetFormStyle = $value;
    }

}

/// what if loop db  and we create  system based on it... and fwrite them alll wahahah


$_GET['targetDatabase'] = 'fixedAsset';
$_GET['targetOutput'] = 'html';
$_GET['targetModule'] = 'asset';
$_GET['targetPackage'] = 'financial';
$_GET['project'] = 'APPS';
$_GET['targetFormStyle'] = 'form-vertical';

$generator = new generator();
$arrayFileType = array('html', 'javascript', 'service', 'model', 'controller');

foreach ($arrayFileType as $_GET['targetOutput']) {

    if (isset($_GET['targetDatabase']) && strlen($_GET['targetDatabase']) > 0) {
        $generator->setTargetDatabase($_GET['targetDatabase']);
    }

    if (isset($_GET['targetDatabase'])) {
        $sql = "show tables in " . strtolower($_GET['targetDatabase']) . ";";
        $result = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_array($result)) {
            $_GET['targetTable'] = $row['Tables_in_' . strtolower($_GET['targetDatabase'])];
            $findme = 'generalLedger';
            $pos = strpos($_GET['targetTable'], $findme);
            if ($pos !== false) {
                $_GET['targetModule'] = 'generalLedger';
            }
            $findme = 'asset';
            $pos = strpos($_GET['targetTable'], $findme);
            if ($pos !== false) {
                $_GET['targetModule'] = 'asset';
            }

            $findme = 'generalLedger';
            $pos = strpos($_GET['targetTable'], $findme);
            if ($pos !== false) {
                $_GET['targetModule'] = 'generalLedger';
            }

            $findme = 'accountPayable';
            $pos = strpos($_GET['targetTable'], $findme);
            if ($pos !== false) {
                $_GET['targetModule'] = 'accountPayable';
            }

            $findme = 'businessPartner';
            $pos = strpos($_GET['targetTable'], $findme);
            if ($pos !== false) {
                $_GET['targetModule'] = 'businessPartner';
            }

            $findme = 'cashbook';
            $pos = strpos($_GET['targetTable'], $findme);
            if ($pos !== false) {
                $_GET['targetModule'] = 'cashbook';
            }

            $findme = 'humanResource';
            $pos = strpos($_GET['targetTable'], $findme);
            if ($pos !== false) {
                $_GET['targetModule'] = 'humanResource';
            }
            $findme = 'translation';
            $pos = strpos($_GET['targetTable'], $findme);
            if ($pos !== false) {
                $_GET['targetModule'] = 'translation';
            }


            if (isset($_GET['targetTable']) && strlen($_GET['targetTable']) > 0) {
                $generator->setTargetTable($_GET['targetTable']);
            }
            if (isset($_GET['targetGridType']) && strlen($_GET['targetGridType']) > 0) {
                $generator->setTargetGridType($_GET['targetDatabase']);
            }
            if (isset($_GET['targetOutput']) && strlen($_GET['targetOutput']) > 0) {
                $generator->setTargetOutput($_GET['targetOutput']);
            }
            if (isset($_GET['targetPackage']) && strlen($_GET['targetPackage']) > 0) {
                $generator->setTargetPackage($_GET['targetPackage']);
            }
            if (isset($_GET['targetModule']) && strlen($_GET['targetModule']) > 0) {
                $generator->setTargetModule($_GET['targetModule']);
            }
            if (isset($_GET['targetFormStyle']) && strlen($_GET['targetFormStyle']) > 0) {
                $generator->setTargetFormStyle($_GET['targetFormStyle']);
            }

            $extension = null;
            $template == null;
            switch ($_GET['targetOutput']) {
                case 'model':
                    $extension = 'Model.php';
                    $folder = 'model';
                    break;
                case 'controller':
                    $extension = 'Controller.php';
                    $folder = 'controller';
                    break;
                case 'javascript':
                    $extension = '.js';
                    $folder = 'javascript';
                    break;
                case 'service':
                    $extension = 'Service.php';
                    $folder = 'service';
                    break;
                case 'html':
                    $extension = '.php';
                    $folder = 'view';
                    break;
            }

//
            if (file_exists('./' . $folder . '/' . $_GET['targetTable'] . $extension)) {
                unlink('./' . $folder . '/' . $_GET['targetTable'] . $extension);
            }
            $fp = fopen('./' . $folder . '/' . $_GET['targetTable'] . $extension, 'w');
            $generator->setProject($_GET['project']);
            fwrite($fp, $generator->execute());
        }
    }
}
?>
  