<?php

/**
 * Main Code Generator File
 * Class generator
 */
class generator {

    /**
     * Page
     * @var int
     * */
    private $pageNumber;

    /**
     * Project /Application Name
     * @var string
     */
    private $project;

    /**
     * Target Database Vendor
     * @var string
     */
    private $targetDatabaseVendor;

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
     * Target table detail
     * @var string
     */
    private $targetTabOneTable;

    /**
     * Target table detail
     * @var string
     */
    private $targetTabTwoTable;

    /**
     * Target table detail
     * @var string
     */
    private $targetTabThreeTable;

    /**
     * Target table detail
     * @var string
     */
    private $targetTabFourTable;

    /**
     * Target table detail
     * @var string
     */
    private $targetTabFiveTable;

    /**
     * To target output source code generator either it was html ,javascript,controller or model
     * @var string
     */
    private $targetSourceCode;

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
     * Edit On Grid, List + Form, List + Form + multi tab
     * @var string
     */
    private $targetFormType;

    /**
     * Code Block
     * @var string
     */
    private $targetCodeBlock;

    /**
     * Maximum Tab Record
     * @var string
     */
    private $targetMaximumTabRecord;
	
	 /**
     * Form Business Flow,Entry,Print,History,Cancel,Void
     * @var string
     */
    private $targetFormBusinessFlow;
	
	 /**
     * Model Type =1 normal Type 2 multi table
     * @var string
     */
    private $targetModelType;

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
    const DEFAULT_DATABASE = 'icore';

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
            'humanResource' => array(
                'employment',
                'job',
                'leave',
                'recruitment',
                'setting',
                'timeSheet',
                'payroll',
                'loan',
                'training',
                'workOrder'
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
                'loan',
                'inventory'
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
                'translation',
                'document'
        ));
        $this->setTargetDatabase(self::DEFAULT_DATABASE);
    }

    /**
     * main function
     */
    public function execute() {
        $this->setTargetDatabase(self::DEFAULT_DATABASE);
        mysql_select_db(self::DEFAULT_DATABASE);
    }

    function htmlForm() {
        ?>

        <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">

        <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">
        <link rel="stylesheet" href="./js/plugin/chosen/chosen.css">
        <link rel="stylesheet" href="./js/plugin/chosen-bootstrap-master/chosen.bootstrap.min.css">
        <link rel="stylesheet" title="Default" href="styles/default.css">
        <link rel="alternate stylesheet" title="Dark" href="styles/dark.css">
        <link rel="alternate stylesheet" title="FAR" href="styles/far.css">
        <link rel="alternate stylesheet" title="IDEA" href="styles/idea.css">
        <link rel="alternate stylesheet" title="Sunburst" href="styles/sunburst.css">
        <link rel="alternate stylesheet" title="Zenburn" href="styles/zenburn.css">
        <link rel="alternate stylesheet" title="Visual Studio" href="styles/vs.css">
        <link rel="alternate stylesheet" title="Ascetic" href="styles/ascetic.css">
        <link rel="alternate stylesheet" title="Magula" href="styles/magula.css">
        <link rel="alternate stylesheet" title="GitHub" href="styles/github.css">
        <link rel="alternate stylesheet" title="Google Code" href="styles/googlecode.css">
        <link rel="alternate stylesheet" title="Brown Paper" href="styles/brown_paper.css">
        <link rel="alternate stylesheet" title="School Book" href="styles/school_book.css">
        <link rel="alternate stylesheet" title="IR Black" href="styles/ir_black.css">
        <link rel="alternate stylesheet" title="Solarized - Dark" href="styles/solarized_dark.css">
        <link rel="alternate stylesheet" title="Solarized - Light" href="styles/solarized_light.css">
        <link rel="alternate stylesheet" title="Arta" href="styles/arta.css">
        <link rel="alternate stylesheet" title="Monokai" href="styles/monokai.css">


        <style>
            body {
                font: small Arial, sans-serif;
            }

            h2 {
                font: bold 100% Arial, sans-serif;
                margin-top: 2em;
                margin-bottom: 0.5em;
            }

            table {
                width: 100%;
                padding: 0;
                border-collapse: collapse;
            }

            th {
                width: 12em;
                padding: 0;
                margin: 0;
            }

            td {
                padding-bottom: 1em;
            }

            td, th {
                vertical-align: top;
                text-align: left;
            }

            pre {
                margin: 0;
                font-size: medium;
            }

            #switch {
                overflow: auto;
                width: 57em;
                list-style: none;
                padding: 0;
                margin: 0;
            }

            #switch li {
                float: left;
                width: 10em;
                padding: 0.1em;
                margin: 0.1em 1em 0.1em 0;
                background: #EEE;
                cursor: pointer;
            }

            #switch li.current {
                background: #CCC;
                font-weight: bold;
            }

            .test {
                color: #888;
                font-weight: normal;
                margin: 2em 0 0 0;
            }

            .test var {
                font-style: normal;
            }

            .passed {
                color: green;
            }

            .failed {
                color: red;
            }

            .code {
                font: medium monospace;
            }

            .code .keyword {
                font-weight: bold;
            }
        </style>
        <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="get" class="form-horizontal">
            <div class="widget-body fuelux">
                <div class="wizard">
                    <ul class="steps">
                        <li data-target="#step1" <?php if ($this->getPageNumber() == 1) { ?>class="active"<?php } ?>><a href="index.php?pageNumber=1&targetPackage=<?php echo $this->getTargetPackage(); ?>&targetModule=<?php echo $this->getTargetModule(); ?>&targetFormStyle=<?php echo $this->getTargetFormStyle(); ?>&targetFormLayout=<?php echo $this->getTargetFormLayout(); ?>&targetSourceCode=<?php echo $this->getTargetSourceCode(); ?>&getDatabaseVendor=<?php echo $_GET['getDatabaseVendor']; ?>&getDatabase=<?php echo $_GET['getDatabase']; ?>&targetFormBusinessFlow=<?php echo $_GET['targetFormBusinessFlow']; ?>">Package</a><span class="chevron"></span></li>
                        <li data-target="#step2" <?php if ($this->getPageNumber() == 2) { ?>class="active"<?php } ?>><a href="index.php?pageNumber=2&targetPackage=<?php echo $this->getTargetPackage(); ?>&targetModule=<?php echo $this->getTargetModule(); ?>&targetFormStyle=<?php echo $this->getTargetFormStyle(); ?>&targetFormLayout=<?php echo $this->getTargetFormLayout(); ?>&targetSourceCode=<?php echo $this->getTargetSourceCode(); ?>&getDatabaseVendor=<?php echo $_GET['getDatabaseVendor']; ?>&getDatabase=<?php echo $_GET['getDatabase']; ?>&targetFormBusinessFlow=<?php echo $_GET['targetFormBusinessFlow']; ?>">Form</a><span class="chevron"></span></li>
                        <li data-target="#step3" <?php if ($this->getPageNumber() == 3) { ?>class="active"<?php } ?>><a href="index.php?pageNumber=3&targetPackage=<?php echo $this->getTargetPackage(); ?>&targetModule=<?php echo $this->getTargetModule(); ?>&targetFormStyle=<?php echo $this->getTargetFormStyle(); ?>&targetFormLayout=<?php echo $this->getTargetFormLayout(); ?>&targetSourceCode=<?php echo $this->getTargetSourceCode(); ?>&getDatabaseVendor=<?php echo $_GET['getDatabaseVendor']; ?>&getDatabase=<?php echo $_GET['getDatabase']; ?>&targetFormBusinessFlow=<?php echo $_GET['targetFormBusinessFlow']; ?>">Database</a><span class="chevron"></span></li>  
                        <li data-target="#step4" <?php if ($this->getPageNumber() == 4) { ?>class="active"<?php } ?>><a href="index.php?pageNumber=4&targetPackage=<?php echo $this->getTargetPackage(); ?>&targetModule=<?php echo $this->getTargetModule(); ?>&targetFormStyle=<?php echo $this->getTargetFormStyle(); ?>&targetFormLayout=<?php echo $this->getTargetFormLayout(); ?>&targetSourceCode=<?php echo $this->getTargetSourceCode(); ?>&getDatabaseVendor=<?php echo $_GET['getDatabaseVendor']; ?>&getDatabase=<?php echo $_GET['getDatabase']; ?>&targetFormBusinessFlow=<?php echo $_GET['targetFormBusinessFlow']; ?>">Table</a><span class="chevron"></span></li>
                        <li data-target="#step5" <?php if ($this->getPageNumber() == 5) { ?>class="active"<?php } ?>><a href="index.php?pageNumber=5&targetPackage=<?php echo $this->getTargetPackage(); ?>&targetModule=<?php echo $this->getTargetModule(); ?>&targetFormStyle=<?php echo $this->getTargetFormStyle(); ?>&targetFormLayout=<?php echo $this->getTargetFormLayout(); ?>&targetSourceCode=<?php echo $this->getTargetSourceCode(); ?>&getDatabaseVendor=<?php echo $_GET['getDatabaseVendor']; ?>&getDatabase=<?php echo $_GET['getDatabase']; ?>&targetFormBusinessFlow=<?php echo $_GET['targetFormBusinessFlow']; ?>">Column</a><span class="chevron"></span></li>
                        <li data-target="#step6" <?php if ($this->getPageNumber() == 6) { ?>class="active"<?php } ?>><a href="index.php?pageNumber=6&targetPackage=<?php echo $this->getTargetPackage(); ?>&targetModule=<?php echo $this->getTargetModule(); ?>&targetFormStyle=<?php echo $this->getTargetFormStyle(); ?>&targetFormLayout=<?php echo $this->getTargetFormLayout(); ?>&targetSourceCode=<?php echo $this->getTargetSourceCode(); ?>&getDatabaseVendor=<?php echo $_GET['getDatabaseVendor']; ?>&getDatabase=<?php echo $_GET['getDatabase']; ?>&targetFormBusinessFlow=<?php echo $_GET['targetFormBusinessFlow']; ?>">Result</a><span class="chevron"></span></li>
						<li data-target="#step7" <?php if ($this->getPageNumber() == 7) { ?>class="active"<?php } ?>><a href="index.php?pageNumber=7&targetPackage=<?php echo $this->getTargetPackage(); ?>&targetModule=<?php echo $this->getTargetModule(); ?>&targetFormStyle=<?php echo $this->getTargetFormStyle(); ?>&targetFormLayout=<?php echo $this->getTargetFormLayout(); ?>&targetSourceCode=<?php echo $this->getTargetSourceCode(); ?>&getDatabaseVendor=<?php echo $_GET['getDatabaseVendor']; ?>&getDatabase=<?php echo $_GET['getDatabase']; ?>&targetFormBusinessFlow=<?php echo $_GET['targetFormBusinessFlow']; ?>">Model</a><span class="chevron"></span></li>
						<li data-target="#step8" <?php if ($this->getPageNumber() == 8) { ?>class="active"<?php } ?>><a href="index.php?pageNumber=8&targetPackage=<?php echo $this->getTargetPackage(); ?>&targetModule=<?php echo $this->getTargetModule(); ?>&targetFormStyle=<?php echo $this->getTargetFormStyle(); ?>&targetFormLayout=<?php echo $this->getTargetFormLayout(); ?>&targetSourceCode=<?php echo $this->getTargetSourceCode(); ?>&getDatabaseVendor=<?php echo $_GET['getDatabaseVendor']; ?>&getDatabase=<?php echo $_GET['getDatabase']; ?>&targetFormBusinessFlow=<?php echo $_GET['targetFormBusinessFlow']; ?>">Service</a><span class="chevron"></span></li>



                    </ul>
                    <div class="actions">
                        <button type="button" class="btn btn-sm btn-primary btn-prev" onClick="getPreviousPage(<?php echo ($this->getPageNumber() - 1); ?>);">
                            <i class="fa fa-arrow-left"></i>Prev
                        </button>
                        <button type="button" class="btn btn-sm btn-success btn-next" data-last="Finish" onClick="getNextPage(<?php echo ($this->getPageNumber() + 1); ?>);">
                            Next<i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div><br>
				<!-- <pre><?php echo print_r($_GET); ?></pre> -->
                <br>
                <table align="center" width="90%" border=1  class="table table-bordered table-striped table-condensed table-hover smart-form has-tickbox">


                    <?php if ($this->getPageNumber() == 1) { ?>

                        <input type="hidden" name="targetFormStyle" id="targetFormStyle" value="<?php echo $this->getTargetFormStyle(); ?>">
                        <input type="hidden" name="targetFormLayout" id="targetFormLayout" value="<?php echo $this->getTargetFormLayout(); ?>">
                        <input type="hidden" name="targetSourceCode" id="targetSourceCode" value="<?php echo $this->getTargetSourceCode(); ?>">
                        <input type="hidden" name="targetMaximumTabRecord" id="targetMaximumTabRecord" value="<?php echo $this->getTargetMaximumTabRecord(); ?>">
                        <input type="hidden" name="targetCodeBlock" id="targetCodeBlock" value="<?php echo $this->getTargetCodeBlock(); ?>">
						<input type="hidden" name="targetFormBusinessFlow" id="targetFormBusinessFlow" value="<?php echo $this->getTargetFormBusinessFlow(); ?>">
						
                        <input type="hidden" name="targetDatabase" id="targetDatabase" value="<?php echo $this->getTargetDatabase(); ?>">
                        <input type="hidden" name="targetDatabaseVendor" id="targetDatabaseVendor" value="<?php echo $this->getTargetDatabaseVendor(); ?>">

                        <input type="hidden" name="targetTabOneTable" id="targetTabOneTable" value="<?php echo $this->getTargetTabOneTable(); ?>">
                        <input type="hidden" name="targetTabTwoTable" id="targetTabTwoTable" value="<?php echo $this->getTargetTabTwoTable(); ?>">
                        <input type="hidden" name="targetTabThreeTable" id="targetTabThreeTable" value="<?php echo $this->getTargetTabThreeTable(); ?>">
                        <input type="hidden" name="targetTabFourTable" id="targetTabFourTable" value="<?php echo $this->getTargetTabFourTable(); ?>">
                        <input type="hidden" name="targetTabFiveTable" id="targetTabFiveTable" value="<?php echo $this->getTargetTabFiveTable(); ?>">
                        <?php $total = count($this->packageAndModule); ?>
                        <tr>
                            <td>Package</td>
                            <td><select class="chzn-select form-control" name="targetPackage" id="targetPackage" onChange="setRefresh(1)">
                                    <option value="">Please Choose Package</option>
                                    <?php foreach ($this->packageAndModule as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"

                                                <?php
                                                if ($this->getTargetPackage() == $key) {
                                                    echo "selected";
                                                }
                                                ?>>
                                            <?php echo $key; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Module</td>
                            <td><select class="chzn-select form-control" name="targetModule" id="targetModule" <?php
                                if (!$this->getTargetPackage()) {
                                    echo "disabled";
                                }
                                ?>  style="width:600px">
                                        <?php if ($this->getTargetPackage()) { ?>
                                        <option value="">Please Choose Module</option>

                                    <?php } else { ?>
                                        <option value="">Please Choose Package</option>
                                    <?php } ?>
                                    <?php for ($i = 0; $i < count($this->packageAndModule[$this->getTargetPackage()]); $i++) { ?>
                                        <option value="<?php echo $this->packageAndModule[$this->getTargetPackage()][$i]; ?>" <?php
                                        if ($this->getTargetModule() == $this->packageAndModule[$this->getTargetPackage()][$i]) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $this->packageAndModule[$this->getTargetPackage()][$i]; ?></option>
                                            <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                <?php } ?>

                <?php if ($this->getPageNumber() == 2) { ?>
                    <input type="hidden" name="targetPackage" id="targetPackage" value="<?php echo $this->getTargetPackage(); ?>">
                    <input type="hidden" name="targetModule" id="targetModule" value="<?php echo $this->getTargetModule(); ?>">

                    <input type="hidden" name="targetDatabase" id="targetDatabase" value="<?php echo $this->getTargetDatabase(); ?>">
                    <input type="hidden" name="targetDatabaseVendor" id="targetDatabaseVendor" value="<?php echo $this->getTargetDatabaseVendor(); ?>">

                    <input type="hidden" name="targetTabOneTable" id="targetTabOneTable" value="<?php echo $this->getTargetTabOneTable(); ?>">
                    <input type="hidden" name="targetTabTwoTable" id="targetTabTwoTable" value="<?php echo $this->getTargetTabTwoTable(); ?>">
                    <input type="hidden" name="targetTabThreeTable" id="targetTabThreeTable" value="<?php echo $this->getTargetTabThreeTable(); ?>">
                    <input type="hidden" name="targetTabFourTable" id="targetTabFourTable" value="<?php echo $this->getTargetTabFourTable(); ?>">
                    <input type="hidden" name="targetTabFiveTable" id="targetTabFiveTable" value="<?php echo $this->getTargetTabFiveTable(); ?>">
                    <tr>
                        <td>Form Layout</td>
                        <td><select class="chzn-select form-control" name="targetFormLayout" id="targetFormLayout">
                                <option value="form"
                                <?php
                                if ($this->getTargetFormLayout() == 'form') {
                                    echo "selected";
                                }
                                ?>>Form Only
                                </option>
                                <option value="grid"
                                <?php
                                if ($this->getTargetFormLayout() == 'grid') {
                                    echo "selected";
                                }
                                ?>>Edit In Grid
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Form Style</td>
                        <td><select class="chzn-select form-control" name="targetFormStyle" id="targetFormStyle">
                                <option value="form-horizontal"
                                <?php
                                if ($this->getTargetFormStyle() == 'form-horizontal') {
                                    echo "selected";
                                }
                                ?>>form-horizontal
                                </option>
                                <option value="form-vertical"
                                <?php
                                if ($this->getTargetFormStyle() == 'form-vertical') {
                                    echo "selected";
                                }
                                ?>>form-vertical
                                </option>
                                <option value="form-inline"
                                <?php
                                if ($this->getTargetFormStyle() == 'form-inline') {
                                    echo "selected";
                                }
                                ?>>form-inline
                                </option>

                            </select>
                        </td>
                    </tr>
					<tr>
                        <td>Form Business Flow (entry,print,history,report) controller only </td>
                        <td><select class="chzn-select form-control" name="targetFormStyle" id="targetFormStyle">
                                <option value="0"
                                <?php
                                if ($this->getTargetFormStyle() == 0) {
                                    echo "selected";
                                }
                                ?>>False
                                </option>
                                <option value="1"
                                <?php
                                if ($this->getTargetFormStyle() ==1) {
                                    echo "selected";
                                }
                                ?>>True
                                </option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Source Code</td>
                        <td><select class="chzn-select form-control" name="targetSourceCode" id="targetSourceCode">
                                <option value="">Please Choose</option>
                                <optgroup label="PHP programming">
                                    <option value="html"
                                    <?php
                                    if ($this->getTargetSourceCode() == 'html') {
                                        echo "selected";
                                    }
                                    ?>>Html Code
                                    </option>
                                    <option value="javascript"
                                    <?php
                                    if ($this->getTargetSourceCode() == 'javascript') {
                                        echo "selected";
                                    }
                                    ?>>Javascript Code
                                    </option>
                                    <option value="model" <?php
                                    if ($this->getTargetSourceCode() == 'model') {
                                        echo "selected";
                                    }
                                    ?>>Model Entity
                                    </option>
                                    <option value="controller"
                                    <?php
                                    if ($this->getTargetSourceCode() == 'controller') {
                                        ?> selected <?php
                                            }
                                            ?>>Controller
                                    </option>
                                    <option value="service"
                                    <?php
                                    if ($this->getTargetSourceCode() == 'service') {
                                        ?> selected <?php
                                            }
                                            ?>>Service
                                </optgroup>
                            </select></td>
                    </tr>
                    <tr>
                        <td>Code Block</td>
                        <td><select  class="chzn-select form-control"name="targetCodeBlock" id="targetCodeBlock">
                                <option value="">Not Available</option>
                                <option value="all">All</option>
                                <option value="crud">Create,Update,Delete,View Only</option>
                                <option value="report">PhpExcel Block</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Maximum Tab Detail Record</td>
                        <td><input class="form-control" style="padding:5px" type="text" name="targetMaximumTabRecord" id="targetMaximumTabRecord" value="5"></td>
                    </tr>
                    </table>
                <?php } ?>
                <?php if ($this->getPageNumber() == 3) { ?>
                    <input type="hidden" name="targetPackage" id="targetPackage" value="<?php echo $this->getTargetPackage(); ?>">
                    <input type="hidden" name="targetModule" id="targetModule" value="<?php echo $this->getTargetModule(); ?>">

                    <input type="hidden" name="targetFormStyle" id="targetFormStyle" value="<?php echo $this->getTargetFormStyle(); ?>">
                    <input type="hidden" name="targetFormLayout" id="targetFormLayout" value="<?php echo $this->getTargetFormLayout(); ?>">
                    <input type="hidden" name="targetSourceCode" id="targetSourceCode" value="<?php echo $this->getTargetSourceCode(); ?>">
                    <input type="hidden" name="targetMaximumTabRecord" id="targetMaximumTabRecord" value="<?php echo $this->getTargetMaximumTabRecord(); ?>">
                    <input type="hidden" name="targetCodeBlock" id="targetCodeBlock" value="<?php echo $this->getTargetCodeBlock(); ?>">
					<input type="hidden" name="targetFormBusinessFlow" id="targetFormBusinessFlow" value="<?php echo $this->getTargetFormBusinessFlow(); ?>">
					
                    <input type="hidden" name="targetTabOneTable" id="targetTabOneTable" value="<?php echo $this->getTargetTabOneTable(); ?>">
                    <input type="hidden" name="targetTabTwoTable" id="targetTabTwoTable" value="<?php echo $this->getTargetTabTwoTable(); ?>">
                    <input type="hidden" name="targetTabThreeTable" id="targetTabThreeTable" value="<?php echo $this->getTargetTabThreeTable(); ?>">
                    <input type="hidden" name="targetTabFourTable" id="targetTabFourTable" value="<?php echo $this->getTargetTabFourTable(); ?>">
                    <input type="hidden" name="targetTabFiveTable" id="targetTabFiveTable" value="<?php echo $this->getTargetTabFiveTable(); ?>">
                    <tr>
                        <td>Database Vendor</td>
                        <td><select  class="chzn-select form-control"name="targetDatabaseVendor" id="targetDatabaseVendor">
                                <option value="all">All</option>
                                <option value="mysql">Mysql</option>
                                <option value="mssql">Microsoft Sql Server</option>
                                <option value="oracle">Oracle</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:400px">Target Db</td>
                        <td style="width:600px"><select class="chzn-select form-control" name="targetDatabase" id="targetDatabase" onChange="db(this.value)" style="width:600px">
                                <option value="">Please Select Database First</option>
                                <?php
                                $sql = "show databases;";
                                $result = mysql_query($sql);
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
                    </tr>
                <?php } ?>
                <?php if ($this->getPageNumber() == 4 || $this->getPageNumber() == 5) { ?>  
                    <input type="hidden" name="targetPackage" id="targetPackage" value="<?php echo $this->getTargetPackage(); ?>">
                    <input type="hidden" name="targetModule" id="targetModule" value="<?php echo $this->getTargetModule(); ?>">

                    <input type="hidden" name="targetFormStyle" id="targetFormStyle" value="<?php echo $this->getTargetFormStyle(); ?>">
                    <input type="hidden" name="targetFormLayout" id="targetFormLayout" value="<?php echo $this->getTargetFormLayout(); ?>">
                    <input type="hidden" name="targetSourceCode" id="targetSourceCode" value="<?php echo $this->getTargetSourceCode(); ?>">
                    <input type="hidden" name="targetMaximumTabRecord" id="targetMaximumTabRecord" value="<?php echo $this->getTargetMaximumTabRecord(); ?>">
                    <input type="hidden" name="targetCodeBlock" id="targetCodeBlock" value="<?php echo $this->getTargetCodeBlock(); ?>">
					<input type="hidden" name="targetFormBusinessFlow" id="targetFormBusinessFlow" value="<?php echo $this->getTargetFormBusinessFlow(); ?>">
					
                    <input type="hidden" name="targetDatabase" id="targetDatabase" value="<?php echo $this->getTargetDatabase(); ?>">

                    <tr>
                        <td>Main Table</td>
                        <td><select class="chzn-select form-control" name="targetTable" id="targetTable">
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while (($row = mysql_fetch_array($result)) == TRUE) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                        }
                                        ?></select>
                        </td>
                    </tr>
                    <?php
                    if ($this->getPageNumber() == 5) {
                        if ($this->getTargetTable()) {
                            ?>
                            <tr>
                                <td colspan="2" align="center"><table align="center" width="90%" border=1  class="table table-bordered table-striped table-condensed table-hover smart-form has-tickbox">
                                        <thead>
                                            <tr>
                                                <th>Column</th>
                                                <th>Type</th>
                                                <th>Key</th>
                                                <th width="75px">Yes</th>
                                                <th width="75px">Validation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlDescribe = "
																	DESCRIBE `" . $this->getTargetDatabase() . "`.`" . $this->getTargetTable() . "`";
                                            $resultFieldTable = mysql_query($sqlDescribe);
                                            if (!$resultFieldTable) {
                                                echo "Error dol" . mysql_error();
                                            }
                                            $i = 0;
                                            $appear = true;
                                            while (($rowFieldTable = mysql_fetch_array($resultFieldTable)) == TRUE) {
                                                if (strpos($rowFieldTable['Type'], '512') || strpos($rowFieldTable['Type'], 'tiny')) {
                                                    $appear = false;
                                                } else {
                                                    $appear = true;
                                                }
                                                if ($rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isPost' && $rowFieldTable['Field'] != 'isActive' && $rowFieldTable['Field'] != 'isDraft' && $rowFieldTable['Field'] != 'isNew' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isDelete' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isReview' && $rowFieldTable['Field'] != 'isApproved') {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rowFieldTable['Field']; ?></td>
                                                        <td><?php echo $rowFieldTable['Type']; ?></td>
                                                        <td><?php echo $rowFieldTable['Key']; ?></td>
                                                        <td><input checked  type="checkbox" name="<?php echo $this->getTargetTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>"></td>
                                                        <td>
                                                            <?php
                                                            if ($appear == true) {
                                                                if ($rowFieldTable['Key'] != 'PRI' && $rowFieldTable['Key'] != 'MUL') {
                                                                    if ($rowFieldTable['Type'] != 'date') {
                                                                        if ($rowFieldTable['Field'] != 'executeBy' && $rowFieldTable['Field'] != 'executeTime' && $rowFieldTable['Field'] != 'documentNumber' && $rowFieldTable['Field'] != 'referenceNumber' && $rowFieldTable['Field'] != 'journalNumber') {
                                                                            ?>

                                                                            <input type="checkbox" name="<?php echo $this->getTargetTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>"></td>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                <?php
                                                } $appear = false;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td><b>Tab 1</b></td>
                        <td><select class="chzn-select form-control" name="targetTabOneTable" id="targetTabOneTable" onChange="">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTabOneTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                }
                                ?></select>
                        </td>
                    </tr>
                    <?php
                    if ($this->getPageNumber() == 5) {
                        if ($this->getTargetTabOneTable()) {
                            ?>
                            <tr>
                                <td colspan="2" align="center"><table align="center" width="90%" border=1  class="table table-bordered table-striped table-condensed table-hover smart-form has-tickbox">
                                        <thead>
                                            <tr>
                                                <th>Column</th>
                                                <th>Type</th>
                                                <th>Key</th>
                                                <th width="75px">Yes</th>
                                                <th width="75px">Validation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlDescribe = "
																	DESCRIBE `" . $this->getTargetDatabase() . "`.`" . $this->getTargetTabOneTable() . "`";
                                            $resultFieldTable = mysql_query($sqlDescribe);
                                            if (!$resultFieldTable) {
                                                echo "Error dol" . mysql_error();
                                            }
                                            $i = 0;
                                            $appear = true;
                                            while (($rowFieldTable = mysql_fetch_array($resultFieldTable)) == TRUE) {
                                                if (strpos($rowFieldTable['Type'], '512') || strpos($rowFieldTable['Type'], 'tiny')) {
                                                    $appear = false;
                                                } else {
                                                    $appear = true;
                                                }
                                                if ($rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isPost' && $rowFieldTable['Field'] != 'isActive' && $rowFieldTable['Field'] != 'isDraft' && $rowFieldTable['Field'] != 'isNew' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isDelete' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isReview' && $rowFieldTable['Field'] != 'isApproved') {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rowFieldTable['Field']; ?></td>
                                                        <td><?php echo $rowFieldTable['Type']; ?></td>
                                                        <td><?php echo $rowFieldTable['Key']; ?></td>
                                                        <td><input checked  type="checkbox" name="<?php echo $this->getTargetTabOneTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabOneTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>"></td>
                                                        <td><?php
                                                            if ($appear == true) {
                                                                if ($rowFieldTable['Key'] != 'PRI' && $rowFieldTable['Key'] != 'MUL') {
                                                                    if ($rowFieldTable['Type'] != 'date') {
                                                                        if ($rowFieldTable['Field'] != 'executeBy' && $rowFieldTable['Field'] != 'executeTime' && $rowFieldTable['Field'] != 'documentNumber' && $rowFieldTable['Field'] != 'referenceNumber' && $rowFieldTable['Field'] != 'journalNumber' && strtolower($rowFieldTable['Field']) != strtolower($this->getTargetTabOneTable() . 'LineNumber')) {
                                                                            ?><input type="checkbox" name="<?php echo $this->getTargetTabOneTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabOneTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>"><?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?></td>

                                                    </tr>
                                                <?php
                                                } $appear = false;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td>Tab 2 </td>
                        <td><select class="chzn-select form-control" name="targetTabTwoTable" id="targetTabTwoTable">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTabTwoTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                    <?php
                                }
                                ?></select>
                        </td>
                    </tr>
                    <?php
                    if ($this->getPageNumber() == 5) {
                        if ($this->getTargetTabTwoTable()) {
                            ?>
                            <tr>
                                <td colspan="2" align="center"><table align="center" width="90%" border=1  class="table table-bordered table-striped table-condensed table-hover smart-form has-tickbox">
                                        <thead>
                                            <tr>
                                                <th>Column</th>
                                                <th>Type</th>
                                                <th>Key</th>
                                                <th width="75px">Yes</th>
                                                <th width="75px">Validation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlDescribe = "
																	DESCRIBE `" . $this->getTargetDatabase() . "`.`" . $this->getTargetTabTwoTable() . "`";
                                            $resultFieldTable = mysql_query($sqlDescribe);
                                            if (!$resultFieldTable) {
                                                echo "Error dol" . mysql_error();
                                            }
                                            $i = 0;
                                            $appear = true;
                                            while (($rowFieldTable = mysql_fetch_array($resultFieldTable)) == TRUE) {
                                                if (strpos($rowFieldTable['Type'], '512') || strpos($rowFieldTable['Type'], 'tiny')) {
                                                    $appear = false;
                                                } else {
                                                    $appear = true;
                                                }
                                                if ($rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isPost' && $rowFieldTable['Field'] != 'isActive' && $rowFieldTable['Field'] != 'isDraft' && $rowFieldTable['Field'] != 'isNew' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isDelete' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isReview' && $rowFieldTable['Field'] != 'isApproved') {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rowFieldTable['Field']; ?></td>
                                                        <td><?php echo $rowFieldTable['Type']; ?></td>
                                                        <td><?php echo $rowFieldTable['Key']; ?></td>
                                                        <td><input checked  type="checkbox" name="<?php echo $this->getTargetTabTwoTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabTwoTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>"></td>
                                                        <td><?php
                                                            if ($appear == true) {
                                                                if ($rowFieldTable['Key'] != 'PRI' && $rowFieldTable['Key'] != 'MUL') {
                                                                    if ($rowFieldTable['Type'] != 'date') {
                                                                        if ($rowFieldTable['Field'] != 'executeBy' && $rowFieldTable['Field'] != 'executeTime' && $rowFieldTable['Field'] != 'documentNumber' && $rowFieldTable['Field'] != 'referenceNumber' && $rowFieldTable['Field'] != 'journalNumber' && strtolower($rowFieldTable['Field']) != strtolower($this->getTargetTabTwoTable() . 'LineNumber')) {
                                                                            ?><input type="checkbox" name="<?php echo $this->getTargetTabTwoTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabTwoTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>"><?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?></td>
                                                    </tr>
                                                <?php
                                                } $appear = false;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <td>Tab 3</td>
                        <td><select class="chzn-select form-control" name="targetTabThreeTable" id="targetTabThreeTable">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                            if (strtolower($this->getTargetTabThreeTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                <?php
            }
            ?></select>
                        </td>
                    </tr>
                    <?php
                    if ($this->getPageNumber() == 5) {
                        if ($this->getTargetTabThreeTable()) {
                            ?>
                            <tr>
                                <td colspan="2" align="center"><table align="center" width="90%" border=1  class="table table-bordered table-striped table-condensed table-hover smart-form has-tickbox">
                                        <thead>
                                            <tr>
                                                <th>Column</th>
                                                <th>Type</th>
                                                <th>Key</th>
                                                <th width="75px">Yes</th>
                                                <th width="75px">Validation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlDescribe = "
																	DESCRIBE `" . $this->getTargetDatabase() . "`.`" . $this->getTargetTabThreeTable() . "`";
                                            $resultFieldTable = mysql_query($sqlDescribe);
                                            if (!$resultFieldTable) {
                                                echo "Error dol" . mysql_error();
                                            }
                                            $i = 0;
                                            $appear = true;
                                            while (($rowFieldTable = mysql_fetch_array($resultFieldTable)) == TRUE) {
                                                if (strpos($rowFieldTable['Type'], '512') || strpos($rowFieldTable['Type'], 'tiny')) {
                                                    $appear = false;
                                                } else {
                                                    $appear = true;
                                                }
                                                if ($rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isPost' && $rowFieldTable['Field'] != 'isActive' && $rowFieldTable['Field'] != 'isDraft' && $rowFieldTable['Field'] != 'isNew' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isDelete' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isReview' && $rowFieldTable['Field'] != 'isApproved') {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rowFieldTable['Field']; ?></td>
                                                        <td><?php echo $rowFieldTable['Type']; ?></td>
                                                        <td><?php echo $rowFieldTable['Key']; ?></td>
                                                        <td><input checked  type="checkbox" name="<?php echo $this->getTargetTabThreeTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabThreeTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>"></td>
                                                        <td><?php
                                                            if ($appear == true) {
                                                                if ($rowFieldTable['Key'] != 'PRI' && $rowFieldTable['Key'] != 'MUL') {
                                                                    if ($rowFieldTable['Type'] != 'date') {
                                                                        if ($rowFieldTable['Field'] != 'executeBy' && $rowFieldTable['Field'] != 'executeTime' && $rowFieldTable['Field'] != 'documentNumber' && $rowFieldTable['Field'] != 'referenceNumber' && $rowFieldTable['Field'] != 'journalNumber' && strtolower($rowFieldTable['Field']) != strtolower($this->getTargetTabThreeTable() . 'LineNumber')) {
                                                                            ?><input type="checkbox" name="<?php echo $this->getTargetTabThreeTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabThreeTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>"><?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?></td>

                                                    </tr>
                        <?php
                        } $apper = false;
                    }
                    ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                    <?php
                }
            }
            ?>
                    <tr>
                        <td>Tab 4 </td>
                        <td><select class="chzn-select form-control" name="targetTabFourTable" id="targetTabFourTable">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                            <?php
                                            if (strtolower($this->getTargetTabFourTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                        <?php
                    }
                    ?></select>
                        </td>
                    </tr>
            <?php
            if ($this->getPageNumber() == 5) {
                if ($this->getTargetTabFourTable()) {
                    ?>
                            <tr>
                                <td colspan="2" align="center"><table align="center" width="90%" border=1  class="table table-bordered table-striped table-condensed table-hover smart-form has-tickbox">
                                        <thead>
                                            <tr>
                                                <th>Column</th>
                                                <th>Type</th>
                                                <th>Key</th>
                                                <th width="75px">Yes</th>
                                                <th width="75px">Validation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlDescribe = "
																	DESCRIBE `" . $this->getTargetDatabase() . "`.`" . $this->getTargetTabFourTable() . "`";
                                            $resultFieldTable = mysql_query($sqlDescribe);
                                            if (!$resultFieldTable) {
                                                echo "Error dol" . mysql_error();
                                            }
                                            $i = 0;
                                            $appear = true;
                                            while (($rowFieldTable = mysql_fetch_array($resultFieldTable)) == TRUE) {
                                                if (strpos($rowFieldTable['Type'], '512') || strpos($rowFieldTable['Type'], 'tiny')) {
                                                    $appear = false;
                                                } else {
                                                    $appear = true;
                                                }
                                                if ($rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isPost' && $rowFieldTable['Field'] != 'isActive' && $rowFieldTable['Field'] != 'isDraft' && $rowFieldTable['Field'] != 'isNew' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isDelete' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isReview' && $rowFieldTable['Field'] != 'isApproved') {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rowFieldTable['Field']; ?></td>
                                                        <td><?php echo $rowFieldTable['Type']; ?></td>
                                                        <td><?php echo $rowFieldTable['Key']; ?></td>
                                                        <td><input checked type="checkbox" name="<?php echo $this->getTargetTabFourTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabFourTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>"></td>
                                                        <td><?php
                                                            if ($appear == true) {
                                                                if ($rowFieldTable['Key'] != 'PRI' && $rowFieldTable['Key'] != 'MUL') {
                                                                    if ($rowFieldTable['Type'] != 'date') {
                                                                        if ($rowFieldTable['Field'] != 'executeBy' && $rowFieldTable['Field'] != 'executeTime' && $rowFieldTable['Field'] != 'documentNumber' && $rowFieldTable['Field'] != 'referenceNumber' && $rowFieldTable['Field'] != 'journalNumber' && strtolower($rowFieldTable['Field']) != strtolower($this->getTargetTabFourTable() . 'LineNumber')) {
                                                                            ?><input type="checkbox" name="<?php echo $this->getTargetTabFourTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabFourTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>"><?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?></td>

                                                    </tr>
                        <?php
                        } $appear = false;
                    }
                    ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                    <?php
                }
            }
            ?>
                    <tr>
                        <td>Tab 5 </td>
                        <td><select class="chzn-select form-control" name="targetTabFiveTable" id="targetTabFiveTable">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                            <?php
                                            if (strtolower($this->getTargetTabFiveTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                        <?php
                    }
                    ?></select>
                        </td>
                    </tr>
            <?php
            if ($this->getPageNumber() == 6) {
                if ($this->getTargetTabFiveTable()) {
                    ?>
                            <tr>
                                <td colspan="2" align="center"><table align="center" width="90%" border=1  class="table table-bordered table-striped table-condensed table-hover smart-form has-tickbox">
                                        <thead>
                                            <tr>
                                                <th>Column</th>
                                                <th>Type</th>
                                                <th>Key</th>
                                                <th width="75px">Yes</th>
                                                <th width="75px">Validation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sqlDescribe = "
																	DESCRIBE `" . $this->getTargetDatabase() . "`.`" . $this->getTargetTabFiveTable() . "`";
                                            $resultFieldTable = mysql_query($sqlDescribe);
                                            if (!$resultFieldTable) {
                                                echo "Error dol" . mysql_error();
                                            }
                                            $i = 0;
                                            $appear = true;
                                            while (($rowFieldTable = mysql_fetch_array($resultFieldTable)) == TRUE) {
                                                if (strpos($rowFieldTable['Type'], '512') || strpos($rowFieldTable['Type'], 'tiny')) {
                                                    $appear = false;
                                                } else {
                                                    $appear = true;
                                                }
                                                if ($rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isDefault' && $rowFieldTable['Field'] != 'isPost' && $rowFieldTable['Field'] != 'isActive' && $rowFieldTable['Field'] != 'isDraft' && $rowFieldTable['Field'] != 'isNew' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isDelete' && $rowFieldTable['Field'] != 'isUpdate' && $rowFieldTable['Field'] != 'isReview' && $rowFieldTable['Field'] != 'isApproved') {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rowFieldTable['Field']; ?></td>
                                                        <td><?php echo $rowFieldTable['Type']; ?></td>
                                                        <td><?php echo $rowFieldTable['Key']; ?></td>
                                                        <td><input checked  type="checkbox" name="<?php echo $this->getTargetTabFiveTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabFiveTable(); ?>_column_<?php echo $rowFieldTable['Field']; ?>"></td>
                                                        <td><?php
                                                            if ($appear == true) {
                                                                if ($rowFieldTable['Key'] != 'PRI' && $rowFieldTable['Key'] != 'MUL') {
                                                                    if ($rowFieldTable['Type'] != 'date') {
                                                                        if ($rowFieldTable['Field'] != 'executeBy' && $rowFieldTable['Field'] != 'executeTime' && $rowFieldTable['Field'] != 'documentNumber' && $rowFieldTable['Field'] != 'referenceNumber' && $rowFieldTable['Field'] != 'journalNumber' && strtolower($rowFieldTable['Field']) != strtolower($this->getTargetTabFiveTable() . 'LineNumber')) {
                                                                            ?><input type="checkbox" name="<?php echo $this->getTargetTabFiveTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>" id="<?php echo $this->getTargetTabFiveTable(); ?>_validation_<?php echo $rowFieldTable['Field']; ?>">
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?></td>

                                                    </tr>
                        <?php
                        } $appear = false;
                    }
                    ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                <?php
                }
            }
            ?>
                    </table>
        <?php } ?>
        <?php if ($this->getPageNumber() == 6) { ?>
                    <input type="hidden" name="targetPackage" id="targetPackage" value="<?php echo $this->getTargetPackage(); ?>">
                    <input type="hidden" name="targetModule" id="targetModule" value="<?php echo $this->getTargetModule(); ?>">

                    <input type="hidden" name="targetFormStyle" id="targetFormStyle" value="<?php echo $this->getTargetFormStyle(); ?>">
                    <input type="hidden" name="targetFormLayout" id="targetFormLayout" value="<?php echo $this->getTargetFormLayout(); ?>">
                    <input type="hidden" name="targetSourceCode" id="targetSourceCode" value="<?php echo $this->getTargetSourceCode(); ?>">
                    <input type="hidden" name="targetMaximumTabRecord" id="targetMaximumTabRecord" value="<?php echo $this->getTargetMaximumTabRecord(); ?>">
                    <input type="hidden" name="targetCodeBlock" id="targetCodeBlock" value="<?php echo $this->getTargetCodeBlock(); ?>">
					<input type="hidden" name="targetFormBusinessFlow" id="targetFormBusinessFlow" value="<?php echo $this->getTargetFormBusinessFlow(); ?>">
					
                    <input type="hidden" name="targetDatabase" id="targetDatabase" value="<?php echo $this->getTargetDatabase(); ?>">
                    <input type="hidden" name="targetDatabaseVendor" id="targetDatabaseVendor" value="<?php echo $this->getTargetDatabaseVendor(); ?>">

                    <input type="hidden" name="targetTabOneTable" id="targetTabOneTable" value="<?php echo $this->getTargetTabOneTable(); ?>">
                    <input type="hidden" name="targetTabTwoTable" id="targetTabTwoTable" value="<?php echo $this->getTargetTabTwoTable(); ?>">
                    <input type="hidden" name="targetTabThreeTable" id="targetTabThreeTable" value="<?php echo $this->getTargetTabThreeTable(); ?>">
                    <input type="hidden" name="targetTabFourTable" id="targetTabFourTable" value="<?php echo $this->getTargetTabFourTable(); ?>">
                    <input type="hidden" name="targetTabFiveTable" id="targetTabFiveTable" value="<?php echo $this->getTargetTabFiveTable(); ?>">
                    <?php $text = $this->getGeneratedCode(); ?>
                    <tr>
                        <td><textarea class="form-control" rows="10"><?php echo trim($text); ?></textarea></td>
                    </tr>
                    <tr>
                        <td>    <div class="php">
                                <pre class="php"><code><?php echo trim($text); ?></code></pre></div></td>
                    </tr>
        <?php } ?>
		<?php if($this->getPageNumber() == 7) { ?>
		<input type="hidden" name="targetSourceCode" id="targetSourceCode" value="model">
		<tr>
                            <td>Package</td>
                            <td><select class="chzn-select form-control" name="targetPackage" id="targetPackage" onChange="setRefresh(7)">
                                    <option value="">Please Choose Package</option>
                                    <?php foreach ($this->packageAndModule as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"

                                                <?php
                                                if ($this->getTargetPackage() == $key) {
                                                    echo "selected";
                                                }
                                                ?>>
                                            <?php echo $key; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Module</td>
                            <td><select class="chzn-select form-control" name="targetModule" id="targetModule" <?php
                                if (!$this->getTargetPackage()) {
                                    echo "disabled";
                                }
                                ?>  style="width:600px">
                                        <?php if ($this->getTargetPackage()) { ?>
                                        <option value="">Please Choose Module</option>

                                    <?php } else { ?>
                                        <option value="">Please Choose Package</option>
                                    <?php } ?>
                                    <?php for ($i = 0; $i < count($this->packageAndModule[$this->getTargetPackage()]); $i++) { ?>
                                        <option value="<?php echo $this->packageAndModule[$this->getTargetPackage()][$i]; ?>" <?php
                                        if ($this->getTargetModule() == $this->packageAndModule[$this->getTargetPackage()][$i]) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $this->packageAndModule[$this->getTargetPackage()][$i]; ?></option>
                                            <?php } ?>
                                </select>
                            </td>
                        </tr>
		<tr>
                        <td>Main Table</td>
                        <td><select class="chzn-select form-control" name="targetTable" id="targetTable">
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while (($row = mysql_fetch_array($result)) == TRUE) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                        }
                                        ?></select>
                        </td>
                    </tr>
					<tr>
						<td>Model Type  </td>
						<td><select name="targetModelType" id="targetModelType" class="chzn-select form-control">
								<option value="normalModel">Normal</option>
								<option value="multiModel">Line Number(Detail Table Only)</option>
								</select>
						 </td>
						 </tr>
						      <tr>
                        <td>Maximum Tab Detail Record</td>
                        <td><input class="form-control" type="text" name="targetMaximumTabRecord" id="targetMaximumTabRecord" value="5"></td>
                    </tr>

					<tr>
						<td colspan="2"><button type="button" name="submit" id="submit" onClick="quickModel()" class="btn btn-info btn-lg">Generate</button>
					</tr>
					
		<?php } ?>
		<?php if($this->getPageNumber() == 8) { ?>
		<input type="hidden" name="targetSourceCode" id="targetSourceCode" value="service">
		<tr>
                            <td>Package</td>
                            <td><select class="chzn-select form-control" name="targetPackage" id="targetPackage" onChange="setRefresh(8)">
                                    <option value="">Please Choose Package</option>
                                    <?php foreach ($this->packageAndModule as $key => $value) { ?>
                                        <option value="<?php echo $key; ?>"

                                                <?php
                                                if ($this->getTargetPackage() == $key) {
                                                    echo "selected";
                                                }
                                                ?>>
                                            <?php echo $key; ?></option>
                                    <?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Module</td>
                            <td><select class="chzn-select form-control" name="targetModule" id="targetModule" <?php
                                if (!$this->getTargetPackage()) {
                                    echo "disabled";
                                }
                                ?>  style="width:600px">
                                        <?php if ($this->getTargetPackage()) { ?>
                                        <option value="">Please Choose Module</option>

                                    <?php } else { ?>
                                        <option value="">Please Choose Package</option>
                                    <?php } ?>
                                    <?php for ($i = 0; $i < count($this->packageAndModule[$this->getTargetPackage()]); $i++) { ?>
                                        <option value="<?php echo $this->packageAndModule[$this->getTargetPackage()][$i]; ?>" <?php
                                        if ($this->getTargetModule() == $this->packageAndModule[$this->getTargetPackage()][$i]) {
                                            echo "selected";
                                        }
                                        ?>><?php echo $this->packageAndModule[$this->getTargetPackage()][$i]; ?></option>
                                            <?php } ?>
                                </select>
                            </td>
                        </tr>
						     <tr>
                        <td>Maximum Tab Detail Record</td>
                        <td><input class="form-control" style="padding:5px" type="text" name="targetMaximumTabRecord" id="targetMaximumTabRecord" value="5"></td>
                    </tr>

			
					 <tr>
                        <td>Main Table</td>
                        <td><select class="chzn-select form-control" name="targetTable" id="targetTable">
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while (($row = mysql_fetch_array($result)) == TRUE) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                        }
                                        ?></select>
                        </td>
                    </tr>
					       <tr>
                        <td><b>Tab 1</b></td>
                        <td><select class="chzn-select form-control" name="targetTabOneTable" id="targetTabOneTable">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTabOneTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                }
                                ?></select>
                        </td>
                    </tr>
					       <tr>
                        <td><b>Tab 2</b></td>
                        <td><select class="chzn-select form-control" name="targetTabTwoTable" id="targetTabTwoTable">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTabOneTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                }
                                ?></select>
                        </td>
                    </tr>
					       <tr>
                        <td><b>Tab 3</b></td>
                        <td><select class="chzn-select form-control" name="targetTabThreeTable" id="targetTabThreeTab">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTabOneTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                }
                                ?></select>
                        </td>
                    </tr>
					       <tr>
                        <td><b>Tab 4</b></td>
                        <td><select class="chzn-select form-control" name="targetTabFourTab" id="targetTabFourTab">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTabOneTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                }
                                ?></select>
                        </td>
                    </tr>
					       <tr>
                        <td><b>Tab 5</b></td>
                        <td><select class="chzn-select form-control" name="targetTabFiveTab" id="targetTabFiveTab">
                                <option value="">Unavailable</option>
                                <?php
                                $sql = "show tables in " . strtolower($this->getTargetDatabase()) . ";";
                                $result = mysql_query($sql) or die(mysql_error());
                                while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?>"
                                    <?php
                                    if (strtolower($this->getTargetTabOneTable()) == strtolower($row['Tables_in_' . strtolower($this->getTargetDatabase())])) {
                                        echo "selected";
                                    }
                                    ?>><?php echo $row['Tables_in_' . strtolower($this->getTargetDatabase())]; ?></option>
                                            <?php
                                }
                                ?></select>
                        </td>
                    </tr>
							<tr>
						<td colspan="2"><button type="button" name="submit" id="submit" onClick="quickService()" class="btn btn-info btn-lg">Generate</button>
					</tr>
						<?php } ?>
                </table>
        </form>
        <?php
    }

    /**
     *
     * @param string $targetTable
     * @param null|array $filterArray
     * @param null|array $validationArray
     * @return mixed array table
     */
    public function showCode($targetTable, $filterArray = null, $validationArray = null) {

        // initialize value
        $infoColumn = array();
        if ($targetTable) {
            $sqlDescribe = "
            DESCRIBE `" . $this->getTargetDatabase() . "`.`" . $targetTable . "`";
            $resultFieldTable = mysql_query($sqlDescribe);
            if (!$resultFieldTable) {
                echo "Error dol" . mysql_error();
            }
            $i = 0;
            while (($rowFieldTable = mysql_fetch_array($resultFieldTable)) == TRUE) {
				if(is_array($filterArray) && count($filterArray)>0) {
                $key = array_search($rowFieldTable['Field'], $filterArray, true);
                if (strlen($key) > 0) {

					
					$infoColumn[0]['package'] = $this->getTargetPackage();
                    $infoColumn[0]['module'] = $this->getTargetModule();
					
					$infoColumn[0]['databaseVendor'] = $this->getTargetDatabaseVendor();
                    $infoColumn[0]['database'] = $this->getTargetDatabase();
					
                    
                    
                    $infoColumn[0]['targetFormStyle'] = $this->getTargetFormStyle();
					$infoColumn[0]['targetMaximumTabRecord'] = $this->getTargetMaximumTabRecord();
					$infoColumn[0]['targetCodeBlock'] = $this->getTargetCodeBlock();
					
                    $infoColumn[$i]['columnName'] = $rowFieldTable['Field'];
                    $infoColumn[$i]['Type'] = $rowFieldTable['Type'];
                    $infoColumn[$i]['Key'] = $rowFieldTable['Key'];
                    // cannot follow blindly table name+id for generation
                    if ($rowFieldTable['Key'] == 'PRI') {
                        $infoColumn[0]['primaryKeyName'] = $rowFieldTable['Field'];
						$infoColumn[0]['tableName'] = str_replace("Id","",$infoColumn[0]['primaryKeyName']);
						//echo " sini boh \n".$infoColumn[0]['tableName']."[".$rowFieldTable['Field']."]";
                    }
                    $infoColumn[$i]['foreignKey'] = $this->getInfoTableColumn($targetTable,$rowFieldTable['Field']);
                    $infoColumn[$i]['length'] = preg_replace("/[^0-9]/", "", $rowFieldTable['Type']);
					if(is_array($validationArray)) {
						if(count(validationArray)>0) {
							$key = array_search($rowFieldTable['Field'], $validationArray, true);
							if (strlen($key) > 0) {
								$infoColumn[$i]['validate'] = 1;
							} else {
								$infoColumn[$i]['validate'] = 0;
							}
						}
					} else {
						$infoColumn[$i]['validate'] = 0;
					}
                    $findme = 'varchar';
                    $findVarchar = strpos($rowFieldTable['Type'], $findme);
                    if ($findVarchar !== false) {

                        $infoColumn[$i]['formType'] = "text";
                    }
                    // this is for detail table
                    if ($this->getTargetTabOneTable()) {

                        //$infoColumn[0]['detail'] = $this->getDetailDescribe();
                    } else {
                        $infoColumn[0]['detail'] = 0;
                    }
                    $findChar = strpos($rowFieldTable['Type'], 'char');
                    if ($findChar !== false) {

                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "string";
                    }
                    $findText = strpos($rowFieldTable['Type'], 'text');
                    if ($findText !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "string";
                    }
                    $findInt = strpos($rowFieldTable['Type'], 'int');
                    if ($findInt !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "int";
                    }
                    $findDate = strpos($rowFieldTable['Type'], 'date');
                    if ($findDate !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "date";
                    }
                    $findDateTime = strpos($rowFieldTable['Type'], 'datetime');
                    if ($findDateTime !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "datetime";
                    }
                    $findTime = strpos($rowFieldTable['Type'], 'time');
                    if ($findTime !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "time";
                    }
                    $findTiny = strpos($rowFieldTable['Type'], 'tiny');
                    if ($findTiny !== false) {
                        $infoColumn[$i]['formType'] = "bool";
                        $infoColumn[$i]['field'] = "bool";
                    }

                    $findDouble = strpos($rowFieldTable['Type'], 'double');
                    if ($findDouble !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "double";
                    }
                    if ($infoColumn[$i]['formType'] == '' || $infoColumn[$i]['formType'] == null) {
                        $infoColumn[$i]['formType'] = " miau Tell me this type : [" . $rowFieldTable['Type'] . "] [" . $rowFieldTable['Field'] . "]<br>";
                        $infoColumn[$i]['field'] = " miau Tell me this type : [" . $rowFieldTable['Type'] . "] [" . $rowFieldTable['Field'] . "]<br>";
                    }
                    $i++;
                }
            } else {
				$infoColumn[0]['package'] = $this->getTargetPackage();
                    $infoColumn[0]['module'] = $this->getTargetModule();
					
					$infoColumn[0]['databaseVendor'] = $this->getTargetDatabaseVendor();
                    $infoColumn[0]['database'] = $this->getTargetDatabase();
					
                    
                    
                    $infoColumn[0]['targetFormStyle'] = $this->getTargetFormStyle();
					$infoColumn[0]['targetMaximumTabRecord'] = $this->getTargetMaximumTabRecord();
					$infoColumn[0]['targetCodeBlock'] = $this->getTargetCodeBlock();
					
                    $infoColumn[$i]['columnName'] = $rowFieldTable['Field'];
                    $infoColumn[$i]['Type'] = $rowFieldTable['Type'];
                    $infoColumn[$i]['Key'] = $rowFieldTable['Key'];
                    // cannot follow blindly table name+id for generation
                    if ($rowFieldTable['Key'] == 'PRI') {
                        $infoColumn[0]['primaryKeyName'] = $rowFieldTable['Field'];
						$infoColumn[0]['tableName'] = str_replace("Id","",$infoColumn[0]['primaryKeyName']);
						//echo " sini boh \n".$infoColumn[0]['tableName']."[".$rowFieldTable['Field']."]";
                    }
                    $infoColumn[$i]['foreignKey'] = $this->getInfoTableColumn($targetTable,$rowFieldTable['Field']);
                    $infoColumn[$i]['length'] = preg_replace("/[^0-9]/", "", $rowFieldTable['Type']);
					
					if(is_array($validationArray)) {
						if(count($validationArray)>0) { 
							$key = array_search($rowFieldTable['Field'], $validationArray, true);
							if (strlen($key) > 0) {
								$infoColumn[$i]['validate'] = 1;
							} else {
								$infoColumn[$i]['validate'] = 0;
							}
						} else {
							$infoColumn[$i]['validate'] = 0;
						}
					} else {
						$infoColumn[$i]['validate'] = 0;
					}
                    $findme = 'varchar';
                    $findVarchar = strpos($rowFieldTable['Type'], $findme);
                    if ($findVarchar !== false) {

                        $infoColumn[$i]['formType'] = "text";
                    }
                    // this is for detail table
                    if ($this->getTargetTabOneTable()) {

                        //$infoColumn[0]['detail'] = $this->getDetailDescribe();
                    } else {
                        $infoColumn[0]['detail'] = 0;
                    }
                    $findChar = strpos($rowFieldTable['Type'], 'char');
                    if ($findChar !== false) {

                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "string";
                    }
                    $findText = strpos($rowFieldTable['Type'], 'text');
                    if ($findText !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "string";
                    }
                    $findInt = strpos($rowFieldTable['Type'], 'int');
                    if ($findInt !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "int";
                    }
                    $findDate = strpos($rowFieldTable['Type'], 'date');
                    if ($findDate !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "date";
                    }
                    $findDateTime = strpos($rowFieldTable['Type'], 'datetime');
                    if ($findDateTime !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "datetime";
                    }
                    $findTime = strpos($rowFieldTable['Type'], 'time');
                    if ($findTime !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "time";
                    }
                    $findTiny = strpos($rowFieldTable['Type'], 'tiny');
                    if ($findTiny !== false) {
                        $infoColumn[$i]['formType'] = "bool";
                        $infoColumn[$i]['field'] = "bool";
                    }

                    $findDouble = strpos($rowFieldTable['Type'], 'double');
                    if ($findDouble !== false) {
                        $infoColumn[$i]['formType'] = "string";
                        $infoColumn[$i]['field'] = "double";
                    }
                    if ($infoColumn[$i]['formType'] == '' || $infoColumn[$i]['formType'] == null) {
                        $infoColumn[$i]['formType'] = " miau Tell me this type : [" . $rowFieldTable['Type'] . "] [" . $rowFieldTable['Field'] . "]<br>";
                        $infoColumn[$i]['field'] = " miau Tell me this type : [" . $rowFieldTable['Type'] . "] [" . $rowFieldTable['Field'] . "]<br>";
                    }
                    $i++;
			}
            
		}
	
        } else {
            echo "no table provided";
        }
			return $infoColumn;
    }

    public function getGeneratedCode() {

        switch ($this->getTargetSourceCode()) {
            case 'html':
                $str = htmlspecialchars($this->generateHtml());

                break;
            case 'javascript':
                $str = htmlspecialchars($this->generateJavascript());
                break;
            case 'controller':
                $str = htmlspecialchars($this->generateController());
                break;
            case 'model':
                $str = htmlspecialchars($this->generateModel());
                break;
            case 'service':
                $str = htmlspecialchars($this->generateService());
                break;
            case 'htmlJava':
                $str = htmlspecialchars($this->generateHtmlJava());
                break;
            case 'javascriptJava':
                $str = htmlspecialchars($this->generateJavascriptJava());
                break;
            case 'controllerJava':
                $str = htmlspecialchars($this->generateControllerJava());
                break;
            case 'modelJava':
                $str = htmlspecialchars($this->generateModelJava());
                break;
            case 'serviceJava':
                $str = htmlspecialchars($this->generateServiceJava());
                break;
            case 'serviceDao':
                $str = htmlspecialchars($this->generateServiceDao());
                break;
            default:
                echo "Please Identify output type";
        }
        return $str;
    }

    /**
     * Bring information column either it was foreign key or not
	 * @param string $tableName
     * @param string $columnName
     * @return int
     */
    private function getInfoTableColumn($tableSchema,$columnName) {

        $sql = "
		SELECT	table_schema, 
			table_name, 
			column_name, 
			referenced_table_schema, 
			referenced_table_name, 
			referenced_column_name
		FROM 	information_schema.KEY_COLUMN_USAGE
		WHERE 	table_schema='" . $this->getTargetDatabase() . "'
		AND 	table_name = '" . $tableSchema
		. "'
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
     * Bring information column either it was foreign key or not
     * @param string $columnName
     * @return int
     */
    private function getInfoTable($table_name) {
        $data = array();
        $sql = "
		SELECT	table_schema, 
			table_name, 
			column_name, 
			referenced_table_schema, 
			referenced_table_name, 
			referenced_column_name
		FROM 	information_schema.KEY_COLUMN_USAGE
		WHERE 	table_schema='" . $this->getTargetDatabase() . "'
		AND 	table_name = '" . $table_name . "'";

        $result = mysql_query($sql) or die(mysql_error());
        while (($row = mysql_fetch_array($result)) == TRUE) {
            $data[] = $row;
        }
        return $data;
    }

    /**
     * Generate html Content
     * @return string
     */
    public function generateHtml() {
        // initialize dumy value
        $str = null;
        $tabCounter = 0;
        $dataTabDetail = array();
        $filterArray = array();
        $validationArray = array();
		$detailTable=array();
        foreach ($_GET as $webData => $value) {
            if (strpos($webData, strtolower($this->getTargetTable()) . "_column_") !== false) {
                $filterArray[] = str_replace(strtolower($this->getTargetTable()) . "_column_", "", $webData);
            }
            if (strpos($webData, strtolower($this->getTargetTable()) . "_validation_" !== false)) {
                $validationArray[] = str_replace(strtolower($this->getTargetTable()) . "_validation_", "", $webData);
            }
        }

        $data = $this->showCode($this->getTargetTable(), $filterArray, $validationArray);

        if (strlen($this->getTargetTabOneTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, strtolower($this->getTargetTabOneTable()) . "_column_") !== false) {
                    $filterArray[] = str_replace(strtolower($this->getTargetTabOneTable()) . "_column_", "", $webData);
                }
                if (strpos($webData, strtolower($this->getTargetTabOneTable()) . "_validation_") !== false) {
                    $validationArray[] = str_replace(strtolower($this->getTargetTabOneTable()) . "_validation_", "", $webData);
                }
				
            }
            $dataTabDetail[] = $this->showCode($this->getTargetTabOneTable(), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabOneTable();
        }
        if (strlen($this->getTargetTabTwoTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, strtolower($this->getTargetTabTwoTable()) . "_column_") !== false) {
                    $filterArray[] = str_replace($this->getTargetTabTwoTable() . "_column_", "", $webData);
                }
                if (strpos($webData, strtolower($this->getTargetTabTwoTable()) . "_validation_") !== false) {
                    $validationArray[] = str_replace(strtolower($this->getTargetTabTwoTable()) . "_validation_", "", $webData);
                }
            }
			
            $dataTabDetail[] = $this->showCode($this->getTargetTabTwoTable(), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabTwoTable();
        }
        if (strlen($this->getTargetTabThreeTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, strtolower($this->getTargetTabThreeTable()) . "_column_") !== false) {
                    $filterArray[] = str_replace(strtolower($this->getTargetTabThreeTable()) . "_column_", "", $webData);
                }
                if (strpos($webData, $this->getTargetTabThreeTable() . "_validation_") !== false) {
                    $validationArray[] = str_replace(strtolower($this->getTargetTabThreeTable()) . "_validation_", "", $webData);
                }
            }
            $dataTabDetail[] = $this->showCode(strtolower($this->getTargetTabThreeTable()), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabThreeTable();
        }
        if (strlen($this->getTargetTabFourTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, $this->getTargetTabFourTable() . "_column_") !== false){
                    $filterArray[] = str_replace($this->getTargetTabFourTable() . "_column_", "", $webData);
                }
                if (strpos($webData, strtolower($this->getTargetTabFourTable()) . "_validation_" )!== false) {
                    $validationArray[] = str_replace(strtolower($this->getTargetTabFourTable()) . "_validation_", "", $webData);
                }
            }
            $dataTabDetail[] = $this->showCode($this->getTargetTabFourTable(), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabFourTable();
        }
        if (strlen($this->getTargetTabFiveTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, strtolower($this->getTargetTabFiveTable()) . "_column_") !== false) {
                    $filterArray[] = str_replace(strtolower($this->getTargetTabFiveTable()) . "_column_", "", $webData);
                }
                if (strpos($webData, strtolower($this->getTargetTabFiveTable()) . "_validation_")!== false){
                    $validationArray[] = str_replace(strtolower($this->getTargetTabFiveTable()) . "_validation_", "", $webData);
                }
            }
            $dataTabDetail[] = $this->showCode($this->getTargetTabFiveTable(), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabFiveTable();
        }
		if(!($this->getTargetFormLayout())) {
			$this->setTargetFormLayout('form');
		}

        if ($tabCounter == 0) {
            include("htmlv2.php");
            $str = html($data);
        } else {
            if ($this->getTargetFormLayout() == 'form') {
                include("htmlv5.php");
                $str = html($data, $dataTabDetail);
            } else {
                include("htmlv4.php");
                $str = html($data,$detailTable);
            }
        }
        return $str;
    }

    /**
     * Generate Javascript Content
     * @return string
     */
    private function generateJavascript() {
        // initialize dummy value
        $tabCounter = 0;
        $dataTabDetail = array();
        $filterArray = array();
        $validationArray = array();
         foreach ($_GET as $webData => $value) {
            if (strpos($webData, strtolower($this->getTargetTable()) . "_column_") !== false) {
                $filterArray[] = str_replace(strtolower($this->getTargetTable()) . "_column_", "", $webData);
            }
            if (strpos($webData, strtolower($this->getTargetTable()) . "_validation_" !== false)) {
                $validationArray[] = str_replace(strtolower($this->getTargetTable()) . "_validation_", "", $webData);
            }
        }

        $data = $this->showCode($this->getTargetTable(), $filterArray, $validationArray);

        if (strlen($this->getTargetTabOneTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, strtolower($this->getTargetTabOneTable()) . "_column_") !== false) {
                    $filterArray[] = str_replace(strtolower($this->getTargetTabOneTable()) . "_column_", "", $webData);
                }
                if (strpos($webData, strtolower($this->getTargetTabOneTable()) . "_validation_") !== false) {
                    $validationArray[] = str_replace(strtolower($this->getTargetTabOneTable()) . "_validation_", "", $webData);
                }
				
            }
            $dataTabDetail[] = $this->showCode($this->getTargetTabOneTable(), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabOneTable();
        }
        if (strlen($this->getTargetTabTwoTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, strtolower($this->getTargetTabTwoTable()) . "_column_") !== false) {
                    $filterArray[] = str_replace($this->getTargetTabTwoTable() . "_column_", "", $webData);
                }
                if (strpos($webData, strtolower($this->getTargetTabTwoTable()) . "_validation_") !== false) {
                    $validationArray[] = str_replace(strtolower($this->getTargetTabTwoTable()) . "_validation_", "", $webData);
                }
            }
			
            $dataTabDetail[] = $this->showCode($this->getTargetTabTwoTable(), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabTwoTable();
        }
        if (strlen($this->getTargetTabThreeTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, strtolower($this->getTargetTabThreeTable()) . "_column_") !== false) {
                    $filterArray[] = str_replace(strtolower($this->getTargetTabThreeTable()) . "_column_", "", $webData);
                }
                if (strpos($webData, $this->getTargetTabThreeTable() . "_validation_") !== false) {
                    $validationArray[] = str_replace(strtolower($this->getTargetTabThreeTable()) . "_validation_", "", $webData);
                }
            }
            $dataTabDetail[] = $this->showCode(strtolower($this->getTargetTabThreeTable()), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabThreeTable();
        }
        if (strlen($this->getTargetTabFourTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, $this->getTargetTabFourTable() . "_column_") !== false){
                    $filterArray[] = str_replace($this->getTargetTabFourTable() . "_column_", "", $webData);
                }
                if (strpos($webData, strtolower($this->getTargetTabFourTable()) . "_validation_" )!== false) {
                    $validationArray[] = str_replace(strtolower($this->getTargetTabFourTable()) . "_validation_", "", $webData);
                }
            }
            $dataTabDetail[] = $this->showCode($this->getTargetTabFourTable(), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabFourTable();
        }
        if (strlen($this->getTargetTabFiveTable()) > 0) {
            foreach ($_GET as $webData => $value) {
                if (strpos($webData, strtolower($this->getTargetTabFiveTable()) . "_column_") !== false) {
                    $filterArray[] = str_replace(strtolower($this->getTargetTabFiveTable()) . "_column_", "", $webData);
                }
                if (strpos($webData, strtolower($this->getTargetTabFiveTable()) . "_validation_")!== false){
                    $validationArray[] = str_replace(strtolower($this->getTargetTabFiveTable()) . "_validation_", "", $webData);
                }
            }
            $dataTabDetail[] = $this->showCode($this->getTargetTabFiveTable(), $filterArray, $validationArray);
            $tabCounter++;
			$detailTable[] = $this->getTargetTabFiveTable();
        }
        include("javascriptv2.php");
        $str = javascriptSourceCode($data, $dataTabDetail);
        return $str;
    }

    /**
     * Generate Controller Content
     * @return string
     */
    private function generateController() {
        // initialize dumy value
        $data = $this->showCode($this->getTargetTable());
		if($this->getTargetDatabaseVendor() =='') {
			$this->setTargetDatabaseVendor('all');
		}
		if($this->getTargetDatabaseVendor()=='all') {
			include("controllerv2.php");
		} else if($this->getTargetDatabaseVendor() == 'mysql') {
			include("controllerMysql.php");
		} else if($this->getTargetDatabaseVendor() == 'mssql') {
			include("controllerMssql.php");
		} else if($this->getTargetDatabaseVendor()=='oracle') {
			include("controllerOracle.php");
		}
        $str = controllerSourceCode($data);
        return $str;
    }

    /**
     * Generate Model Content
     * @return string
     */
    private function generateModel() {
        // initialize dummy value
        $data = $this->showCode($this->getTargetTable());
        // @todo . optional can code between database.. cleaner code
        if($this->getTargetDatabaseVendor() =='') {
			$this->setTargetDatabaseVendor('all');
		}
		if($this->getTargetDatabaseVendor()=='all') {
			if($this->getTargetModelType() =='normal') {
			include("modelv2.php");
			} else {
				include("modelv3.php");
			}
		} else if($this->getTargetDatabaseVendor() == 'mysql') {
			include("modelMysql.php");
		} else if($this->getTargetDatabaseVendor() == 'mssql') {
			include("modelMssql.php");
		} else if($this->getTargetDatabaseVendor()=='oracle') {
			include("modelOracle.php");
		}
        $str = modelSourceCode($data);
		
        return $str;
    }

    /**
     * Generate Service Content.For Foreign Key Only
     * @return string
     */
    private function generateService() {
        // initialize dummy value


        $data = $this->showCode($this->getTargetTable());

        if (strlen($this->getTargetTabOneTable()) > 0) {
            $dataTabDetail[] = $this->showCode($this->getTargetTabOneTable());
            $tabCounter++;
			$detailTable[] = $this->getTargetTabOneTable();
        }
        if (strlen($this->getTargetTabTwoTable()) > 0) {
			
            $dataTabDetail[] = $this->showCode($this->getTargetTabTwoTable());
            $tabCounter++;
			$detailTable[] = $this->getTargetTabTwoTable();
        }
        if (strlen($this->getTargetTabThreeTable()) > 0) {
            $dataTabDetail[] = $this->showCode(strtolower($this->getTargetTabThreeTable()));
            $tabCounter++;
			$detailTable[] = $this->getTargetTabThreeTable();
        }
        if (strlen($this->getTargetTabFourTable()) > 0) {
            $dataTabDetail[] = $this->showCode($this->getTargetTabFourTable());
            $tabCounter++;
			$detailTable[] = $this->getTargetTabFourTable();
        }
        if (strlen($this->getTargetTabFiveTable()) > 0) {
            $dataTabDetail[] = $this->showCode($this->getTargetTabFiveTable());
            $tabCounter++;
			$detailTable[] = $this->getTargetTabFiveTable();
        }
        // @todo . optional can code between database.. cleaner code
       if($this->getTargetDatabaseVendor() =='') {
			$this->setTargetDatabaseVendor('all');
		}
		if($this->getTargetDatabaseVendor()=='all') {
			include("servicev2.php");
		} else if($this->getTargetDatabaseVendor() == 'mysql') {
			include("serviceMysql.php");
		} else if($this->getTargetDatabaseVendor() == 'mssql') {
			include("serviceMssql.php");
		} else if($this->getTargetDatabaseVendor()=='oracle') {
			include("serviceOracle.php");
		}
        $str = serviceSourceCode($data,$dataTabDetail);
        return $str;
    }

    // java thing
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
            $i++;
            if (strtoupper($alpha) == $alpha) {
                $stop[] = $i;
            }
        }
        if (count($stop) > 0) {
            $startString = substr($str, 0, $stop[0] - 1);
        } else {
            $startString = $str;
        }

        $i = 0;

        $totalStop = count($stop);
        if ($totalStop > 2) {
            $strK = null;

            foreach ($stop as $d) {

                $e = $stop[$i + 1] - $stop[$i];

                $strK .= substr($str, $d - 1, $e);
                $strK .= " ";
                $i++;
            }
            $lastString = substr($str, $stop[count($stop) - 1] - 1, $totalStr);
            return ucwords(ucfirst($startString) . " " . ucfirst($strK) . " " . ucfirst($lastString));
        } else if (count($stop) > 0) {
            $lastString = substr($str, $stop[count($stop) - 1] - 1, $totalStr);
            return ucwords(ucfirst($startString) . " " . ucfirst($lastString));
        } else {

            return ucwords($startString);
        }
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
     * Return Target Database Vendor
     * return string $targetDatabase
     */
    public function getTargetDatabaseVendor() {
        return $this->targetDatabaseVendor;
    }

    /**
     * Set Target Database Vendor
     * param string $value
     */
    public function setTargetDatabaseVendor($value) {
        $this->targetDatabaseVendor = $value;
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
     * Return Tab One Table
     * return string $targetTabOneTable
     */
    public function getTargetTabOneTable() {
        return $this->targetTabOneTable;
    }

    /**
     * Set Target Tab One Table
     * param string $value
     */
    public function setTargetTabOneTable($value) {
        $this->targetTabOneTable = $value;
        return $this;
    }

    /**
     * Return Tab Two Table
     * return string $targetTabTwoTable
     */
    public function getTargetTabTwoTable() {
        return $this->targetTabTwoTable;
    }

    /**
     * Set Target Tab Two Table
     * param string $value
     */
    public function setTargetTabTwoTable($value) {
        $this->targetTabTwoTable = $value;
        return $this;
    }

    /**
     * Return Tab Three Table
     * return string $targetTabTwoTable
     */
    public function getTargetTabThreeTable() {
        return $this->targetTabThreeTable;
    }

    /**
     * Set Target Tab Three Table
     * param string $value
     */
    public function setTargetTabThreeTable($value) {
        $this->targetTabThreeTable = $value;
        return $this;
    }

    /**
     * Return Tab Four Table
     * return string $targetTabFourTable
     */
    public function getTargetTabFourTable() {
        return $this->targetTabFourTable;
    }

    /**
     * Set Target Tab Four Table
     * param string $value
     */
    public function setTargetTabFourTable($value) {
        $this->targetTabFourTable = $value;
        return $this;
    }

    /**
     * Return Tab Five Table
     * return string $targetTabFiveTable
     */
    public function getTargetTabFiveTable() {
        return $this->targetTabFiveTable;
    }

    /**
     * Set Target Tab Five Table
     * param string $value
     */
    public function setTargetTabFiveTable($value) {
        $this->targetTabFiveTable = $value;
        return $this;
    }

    /**
     * Return Target Source Code
     * return string $sourceCode
     */
    public function getTargetSourceCode() {
        return $this->targetSourceCode;
    }

    /**
     * Set Target Source Code
     * param string $value
     */
    public function setTargetSourceCode($value) {
        $this->targetSourceCode = $value;
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
     * Return Target Form Style
     * return string $targetFormStyle
     */
    public function getTargetFormStyle() {
        return $this->targetFormStyle;
    }

    /**
     * Set Target Form Style
     * param string $value
     */
    public function setTargetFormStyle($value) {
        $this->targetFormStyle = $value;
    }

    /**
     * Return Target Form Layout
     * return string $targetFormLayout
     */
    public function getTargetFormLayout() {
        return $this->targetFormLayout;
    }

    /**
     * Set Target Form Layout
     * param string $value
     */
    public function setTargetFormLayout($value) {
        $this->targetFormLayout = $value;
    }
	
	/**
     * Return Target Form Business Flow
     * return string $targetFormLayout
     */
    public function getTargetFormBusinessFlow() {
        return $this->targetFormBusinessFlow;
    }

    /**
     * Set Target Form Business Flow
     * param string $value
     */
    public function setTargetFormBusinessFlow($value) {
        $this->targetFormBusinessFlow = $value;
    }

    /**
     * Return Target Code Block
     * return string $targetCodeBlock
     */
    public function getTargetCodeBlock() {
        return $this->targetCodeBlock;
    }

    /**
     * Set Target Code Block
     * param string $value
     */
    public function setTargetCodeBlock($value) {
        $this->targetCodeBlock = $value;
    }

    /**
     * Return Target Maximum Tab Record
     * return string $targetCodeBlock
     */
    public function getTargetMaximumTabRecord() {
        return $this->targetMaximumTabRecord;
    }

    /**
     * Set Target Maximum Tab Record
     * param string $value
     */
    public function setTargetMaximumTabRecord($value) {
        $this->targetMaximumTabRecord = $value;
    }

    /**
     * Return Page Number
     * return string $output
     */
    public function getPageNumber() {
        return $this->pageNumber;
    }

    /**
     * Set Target Page Number
     * param string $value
     */
    public function setPageNumber($value) {
        $this->pageNumber = $value;
    }
	
	/**
     * Return Target Model Type
     * return string $output
     */
    public function getTargetModelType() {
        return $this->targetModelType;
    }

    /**
     * Set Target Model Type
     * param string $value
     */
    public function setTargetModelType($value) {
        $this->targetModelType = $value;
    }

}

$generator = new generator();
if (isset($_GET['pageNumber']) && strlen($_GET['pageNumber']) > 0) {
    $generator->setPageNumber($_GET['pageNumber']);
} else {
    $generator->setPageNumber(1);
}

//page one
if (isset($_GET['targetPackage']) && strlen($_GET['targetPackage']) > 0) {
    $generator->setTargetPackage($_GET['targetPackage']);
}
if (isset($_GET['targetModule']) && strlen($_GET['targetModule']) > 0) {
    $generator->setTargetModule($_GET['targetModule']);
}


// page one

if (isset($_GET['project']) && strlen($_GET['project']) > 0) {
    $generator->setProject($_GET['project']);
}
// page 2 

if (isset($_GET['targetFormLayout']) && strlen($_GET['targetFormLayout']) > 0) {
    $generator->setTargetFormLayout($_GET['targetFormLayout']);
}
if (isset($_GET['targetSourceCode']) && strlen($_GET['targetSourceCode']) > 0) {
    $generator->setTargetSourceCode($_GET['targetSourceCode']);
}
if (isset($_GET['targetFormStyle']) && strlen($_GET['targetFormStyle']) > 0) {
    $generator->setTargetFormStyle($_GET['targetFormStyle']);
}
if (isset($_GET['targetCodeBlock']) && strlen($_GET['targetCodeBlock']) > 0) {
    $generator->setTargetCodeBlock($_GET['targetCodeBlock']);
}
if (isset($_GET['targetMaximumTabRecord']) && strlen($_GET['targetMaximumTabRecord']) > 0) {
    $generator->setTargetMaximumTabRecord($_GET['targetMaximumTabRecord']);
}
if (isset($_GET['targetFormBusinessFlow']) && strlen($_GET['targetFormBusinessFlow']) > 0) {
    $generator->setTargetFormBusinessFlow($_GET['targetFormBusinessFlow']);
}
// page 2
//page 3
if (isset($_GET['targetDatabase']) && strlen($_GET['targetDatabase']) > 0) {
    $generator->setTargetDatabase($_GET['targetDatabase']);
}
if (isset($_GET['targetDatabaseVendor']) && strlen($_GET['targetDatabaseVendor']) > 0) {
    $generator->setTargetDatabaseVendor($_GET['targetDatabaseVendor']);
}
//page 3
//page 4 and page 5
if (isset($_GET['targetTable']) && strlen($_GET['targetTable']) > 0) {
    $generator->setTargetTable($_GET['targetTable']);
}
if (isset($_GET['targetTabOneTable']) && strlen($_GET['targetTabOneTable']) > 0) {
    $generator->setTargetTabOneTable($_GET['targetTabOneTable']);
}
if (isset($_GET['targetTabTwoTable']) && strlen($_GET['targetTabTwoTable']) > 0) {
    $generator->setTargetTabTwoTable($_GET['targetTabTwoTable']);
}
if (isset($_GET['targetTabThreeTable']) && strlen($_GET['targetTabThreeTable']) > 0) {
    $generator->setTargetTabThreeTable($_GET['targetTabThreeTable']);
}
if (isset($_GET['targetTabFourTable']) && strlen($_GET['targetTabFourTable']) > 0) {
    $generator->setTargetTabFourTable($_GET['targetTabFourTable']);
}
if (isset($_GET['targetTabFiveTable']) && strlen($_GET['targetTabFiveTable']) > 0) {
    $generator->setTargetTabFiveTable($_GET['targetTabFiveTable']);
}

if (isset($_GET['targetModelType']) && strlen($_GET['targetModelType']) > 0) {
    $generator->setTargetModelType($_GET['targetModelType']);
} else {
	$generator->setTargetModelType('normal');
}

//page 4 or 5 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <link href="./css/bootstrap.min.css" rel="stylesheet">

    </head>



    <body>
        <div class="container">
            <div class="contain">
                <div class="well well-large">
                    <div class="alert alert-info">
                        <h2>IDCMSAPP Software Generator/Scalfolding</h2>
                    </div>
<?php $generator->htmlForm(); ?></div>



                <br>
                <footer>
                    <p><b>© IDCMSAPP SOFTWARE 2014/2015</b></p>
                </footer>
            </div></div>
        <!-- Le javascript =================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="./js/libs/jquery-2.0.2.min.js"></script>
        <script src="./js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="./js/plugin/chosen/chosen.jquery.min.js"></script>
        <script src="highlight.pack.js"></script>

        <script type="text/javascript">

                hljs.tabReplace = '    ';
                hljs.initHighlightingOnLoad();
                $(document).ready(function() {
                    $(document).scrollTop(0);
                    $(".chzn-select").chosen({
                        search_contains: true
                    });
                    $(".chzn-select-deselect").chosen({
                        allow_single_deselect: true
                    });

                });
                function getPreviousPage(pageNumber) {
                    var url = '<?php echo basename($_SERVER[' PHP_SELF ']); ?>?pageNumber=' + pageNumber;
                    // page 1 value
                    var targetPackage = $("#targetPackage").val();
                    var targetModule = $("#targetModule").val();
                    // end page 1 value

                    // page 2 value
                    var targetSourceCode = $("#targetSourceCode").val();
                    var targetFormLayout = $("#targetFormLayout").val();
                    var targetFormStyle = $("#targetFormStyle").val();
                    var targetCodeBlock = $("#targetCodeBlock").val();
                    var targetMaximumTabRecord = $("#targetMaximumTabRecord").val();
					var targetFormBusinessFlow = $("#targetFormBusinessFlow").val();
                    // page 2 value

                    // page 3 value
                    var targetDatabase = $("#targetDatabase").val();
                    var targetDatabaseVendor = $("#targetDatabaseVendor").val();
                    //page 3 value

                    //page 4 and page 5

                    var targetTable = $("#targetTable").val();
                    var targetTabOneTable = $("#targetTabOneTable").val();
                    var targetTabTwoTable = $("#targetTabTwoTable").val();
                    var targetTabThreeTable = $("#targetTabThreeTable").val();
                    var targetTabFourTable = $("#targetTabFourTable").val();
                    var targetTabFiveTable = $("#targetTabFiveTable").val();

                    //page 1
                    if (targetPackage) {
                        url = url + "&targetPackage=" + targetPackage;
                    }
                    if (targetModule) {
                        url = url + "&targetModule=" + targetModule;
                    }
                    //page 1
                    //page 2
                    if (targetSourceCode) {
                        url = url + "&targetSourceCode=" + targetSourceCode;
                    }
                    if (targetFormLayout) {
                        url = url + "&targetFormLayout=" + targetFormLayout;
                    }
                    if (targetFormStyle) {
                        url = url + "&targetFormStyle=" + targetFormStyle;
                    }

                    if (targetMaximumTabRecord) {
                        url = url + "&targetMaximumTabRecord=" + targetMaximumTabRecord;
                    }
					if (targetFormBusinessFlow) {
                        url = url + "&targetFormBusinessFlow=" + targetFormBusinessFlow;
                    }
                    // end page 2

                    //page 3
                    if (targetDatabase) {
                        url = url + "&targetDatabase=" + targetDatabase;
                    }
                    if (targetDatabaseVendor) {
                        url = url + "&targetDatabaseVendor=" + targetDatabaseVendor;
                    }
                    // page 3

                    //page 4 and 5 

                    if (targetTable) {
                        url = url + "&targetTable=" + targetTable;
                    }
                    if (targetTabOneTable) {
                        url = url + "&targetTabOneTable=" + targetTabOneTable;
                    }
                    if (targetTabTwoTable) {
                        url = url + "&targetTabTwoTable=" + targetTabTwoTable;
                    }
                    if (targetTabThreeTable) {
                        url = url + "&targetTabThreeTable=" + targetTabThreeTable;
                    }
                    if (targetTabFourTable) {
                        url = url + "&targetTabFourTable=" + targetTabFourTable;
                    }
                    if (targetTabFiveTable) {
                        url = url + "&targetTabFiveTable=" + targetTabFiveTable;
                    }
                    //page 3
                    // end page 3 value
                    if (pageNumber === 0) {
                        alert("Nothin' to Click Yo!");
                        return false;
                    }
                    $('input:checkbox').each(function() {
                        if ($(this).is(':checked')) {
                            url = url + "&" + $(this).attr('id') + "=true";
                        }
                    });
                    location.href = url;
                }
                function getNextPage(pageNumber) {
                    var url = '<?php echo basename($_SERVER['PHP_SELF']); ?>?pageNumber=' + pageNumber;
                    // page 1 value
                    var targetPackage = $("#targetPackage").val();
                    var targetModule = $("#targetModule").val();
                    // end page 1 value

                    // page 2 value
                    var targetSourceCode = $("#targetSourceCode").val();
                    var targetFormLayout = $("#targetFormLayout").val();
                    var targetFormStyle = $("#targetFormStyle").val();
                    var targetCodeBlock = $("#targetCodeBlock").val();
                    var targetMaximumTabRecord = $("#targetMaximumTabRecord").val();
					var targetFormBusinessFlow = $("targetFormBusinessFlow").val();
                    // page 2 value

                    // page 3 value
                    var targetDatabase = $("#targetDatabase").val();
                    var targetDatabaseVendor = $("#targetDatabaseVendor").val();
                    //page 3 value

                    //page 4 and page 5
                    var targetTable = $("#targetTable").val();
                    var targetTabOneTable = $("#targetTabOneTable").val();
                    var targetTabTwoTable = $("#targetTabTwoTable").val();
                    var targetTabThreeTable = $("#targetTabThreeTable").val();
                    var targetTabFourTable = $("#targetTabFourTable").val();
                    var targetTabFiveTable = $("#targetTabFiveTable").val();
                    // end page 3 value

                    //page 1
                    if (targetPackage) {
                        url = url + "&targetPackage=" + targetPackage;
                    }
                    if (targetModule) {
                        url = url + "&targetModule=" + targetModule;
                    }
                    //page 1

                    //page 2

                    if (targetFormLayout) {
                        url = url + "&targetFormLayout=" + targetFormLayout;
                    }
                    if (targetFormStyle) {
                        url = url + "&targetFormStyle=" + targetFormStyle;
                    }
                    if (targetSourceCode) {
                        url = url + "&targetSourceCode=" + targetSourceCode;
                    }
                    if (targetCodeBlock) {
                        url = url + "&targetCodeBlock=" + targetCodeBlock;
                    }
                    if (targetMaximumTabRecord) {
                        url = url + "&targetMaximumTabRecord=" + targetMaximumTabRecord;
                    }
					if (targetFormBusinessFlow) {
                        url = url + "&targetFormBusinessFlow=" + targetFormBusinessFlow;
                    }
                    // end page 2

                    //page 3
                    if (targetDatabase) {
                        url = url + "&targetDatabase=" + targetDatabase;
                    }
                    if (targetDatabaseVendor) {
                        url = url + "&targetDatabaseVendor=" + targetDatabaseVendor;
                    }
                    // page 3

                    //page 4 and 5 
                    if (targetTable) {
                        url = url + "&targetTable=" + targetTable;
                    }
                    if (targetTabOneTable) {
                        url = url + "&targetTabOneTable=" + targetTabOneTable;
                    }
                    if (targetTabTwoTable) {
                        url = url + "&targetTabTwoTable=" + targetTabTwoTable;
                    }
                    if (targetTabThreeTable) {
                        url = url + "&targetTabThreeTable=" + targetTabThreeTable;
                    }
                    if (targetTabFourTable) {
                        url = url + "&targetTabFourTable=" + targetTabFourTable;
                    }
                    if (targetTabFiveTable) {
                        url = url + "&targetTabFiveTable=" + targetTabFiveTable;
                    }
                    //page 3

                    if (pageNumber === 7) {
                        alert("Nothin' to Click Yo!");
                        return false;
                    } else if (pageNumber === 2) {
                        if (targetPackage === '') {
                            alert("Please fill field package ! ");
                            return false;
                        }
                        if (targetModule === '') {
                            alert("Please fill field module ! ");
                            return false;
                        }

                    }
                    $('input:checkbox').each(function() {
                        if ($(this).is(':checked')) {
                            url = url + "&" + $(this).attr('id') + "=true";
                        }
                    });
                    location.href = url;
                }
                function setRefresh(pageNumber) {

                    var targetPackage = $("#targetPackage").val();
                    var targetModule = $("#targetModule").val();

                    var targetSourceCode = $("#targetSourceCode").val();
                    var targetFormLayout = $("#targetFormLayout").val();
                    var targetFormStyle = $("#targetFormStyle").val();
                    var targetMaximumTabRecord = $("#targetMaximumTabRecord").val();
					var targetFormBusinessFlow = $("#targetFormBusinessFlow").val();
					
                    var targetDatabase = $("#targetDatabase").val();
                    var targetDatabaseVendor = $("#targetDatabaseVendor").val();

                    var targetTable = $("#targetTable").val();
                    var targetTabOneTable = $("#targetTabOneTable").val();
                    var targetTabTwoTable = $("#targetTabTwoTable").val();
                    var targetTabThreeTable = $("#targetTabThreeTable").val();
                    var targetTabFourTable = $("#targetTabFourTable").val();
                    var targetTabFiveTable = $("#targetTabFiveTable").val();



                    var url = '<?php echo basename($_SERVER['PHP_SELF']); ?>?pageNumber='+pageNumber;

                    if (targetTable) {
                        url = url + "&targetTable=" + targetTable;
                    }
                    if (targetTabOneTable) {
                        url = url + "&targetTabOneTable=" + targetTabOneTable;
                    }
                    if (targetTabTwoTable) {
                        url = url + "&targetTabTwoTable=" + targetTabTwoTable;
                    }
                    if (targetTabThreeTable) {
                        url = url + "&targetTabThreeTable=" + targetTabThreeTable;
                    }
                    if (targetTabFourTable) {
                        url = url + "&targetTabFourTable=" + targetTabFourTable;
                    }
                    if (targetTabFiveTable) {
                        url = url + "&targetTabFiveTable=" + targetTabFiveTable;
                    }


                    if (targetPackage) {
                        url = url + "&targetPackage=" + targetPackage;
                    }
                    if (targetModule) {
                        url = url + "&targetModule=" + targetModule;
                    }

                    if (targetDatabase) {
                        url = url + "&targetDatabase=" + targetDatabase;
                    }
                    if (targetDatabaseVendor) {
                        url = url + "&targetDatabaseVendor=" + targetDatabaseVendor;
                    }


                    if (targetSourceCode) {
                        url = url + "&targetSourceCode=" + targetSourceCode;
                    }
                    if (targetFormLayout) {
                        url = url + "&targetFormLayout=" + targetFormLayout;
                    }
                    if (targetFormStyle) {
                        url = url + "&targetFormStyle=" + targetFormStyle;
                    }
                    if (targetMaximumTabRecord) {
                        url = url + "&targetMaximumTabRecord=" + targetMaximumTabRecord;
                    }
					 if (targetFormBusinessFlow) {
                        url = url + "&targetFormBusinessFlow=" + targetFormBusinessFlow;
                    }

                    location.href = url;
                }
				function quickModel() {
					 var targetPackage = $("#targetPackage").val();
                    var targetModule = $("#targetModule").val();

                    var targetSourceCode = $("#targetSourceCode").val();
                    var targetFormLayout = $("#targetFormLayout").val();
                    var targetFormStyle = $("#targetFormStyle").val();
                    var targetMaximumTabRecord = $("#targetMaximumTabRecord").val();
					var targetFormBusinessFlow = $("#targetFormBusinessFlow").val();
					
                    var targetDatabase = $("#targetDatabase").val();
                    var targetDatabaseVendor = $("#targetDatabaseVendor").val();

                    var targetTable = $("#targetTable").val();
                    var targetTabOneTable = $("#targetTabOneTable").val();
                    var targetTabTwoTable = $("#targetTabTwoTable").val();
                    var targetTabThreeTable = $("#targetTabThreeTable").val();
                    var targetTabFourTable = $("#targetTabFourTable").val();
                    var targetTabFiveTable = $("#targetTabFiveTable").val();

					var targetModelType = $("#targetModelType").val();


                    var url = '<?php echo basename($_SERVER['PHP_SELF']); ?>?pageNumber=6';

                    if (targetTable) {
                        url = url + "&targetTable=" + targetTable;
                    }
                    if (targetTabOneTable) {
                        url = url + "&targetTabOneTable=" + targetTabOneTable;
                    }
                    if (targetTabTwoTable) {
                        url = url + "&targetTabTwoTable=" + targetTabTwoTable;
                    }
                    if (targetTabThreeTable) {
                        url = url + "&targetTabThreeTable=" + targetTabThreeTable;
                    }
                    if (targetTabFourTable) {
                        url = url + "&targetTabFourTable=" + targetTabFourTable;
                    }
                    if (targetTabFiveTable) {
                        url = url + "&targetTabFiveTable=" + targetTabFiveTable;
                    }


                    if (targetPackage) {
                        url = url + "&targetPackage=" + targetPackage;
                    }
                    if (targetModule) {
                        url = url + "&targetModule=" + targetModule;
                    }

                    if (targetDatabase) {
                        url = url + "&targetDatabase=" + targetDatabase;
                    }
                    if (targetDatabaseVendor) {
                        url = url + "&targetDatabaseVendor=" + targetDatabaseVendor;
                    }


                    if (targetSourceCode) {
                        url = url + "&targetSourceCode=" + targetSourceCode;
                    }
                    if (targetFormLayout) {
                        url = url + "&targetFormLayout=" + targetFormLayout;
                    }
                    if (targetFormStyle) {
                        url = url + "&targetFormStyle=" + targetFormStyle;
                    }
                    if (targetMaximumTabRecord) {
                        url = url + "&targetMaximumTabRecord=" + targetMaximumTabRecord;
                    }
					if (targetFormBusinessFlow) {
                        url = url + "&targetFormBusinessFlow=" + targetFormBusinessFlow;
                    }
					 if (targetModelType) {
                        url = url + "&targetModelType=" + targetModelType;
                    }

                    location.href = url;
				}
				
				function quickService(pageNumber) {
					 var targetPackage = $("#targetPackage").val();
                    var targetModule = $("#targetModule").val();

                    var targetSourceCode = $("#targetSourceCode").val();
                    var targetFormLayout = $("#targetFormLayout").val();
                    var targetFormStyle = $("#targetFormStyle").val();
                    var targetMaximumTabRecord = $("#targetMaximumTabRecord").val();
					var targetFormBusinessFlow = $("#targetFormBusinessFlow").val();
					
                    var targetDatabase = $("#targetDatabase").val();
                    var targetDatabaseVendor = $("#targetDatabaseVendor").val();

                    var targetTable = $("#targetTable").val();
                    var targetTabOneTable = $("#targetTabOneTable").val();
                    var targetTabTwoTable = $("#targetTabTwoTable").val();
                    var targetTabThreeTable = $("#targetTabThreeTable").val();
                    var targetTabFourTable = $("#targetTabFourTable").val();
                    var targetTabFiveTable = $("#targetTabFiveTable").val();



                    var url = '<?php echo basename($_SERVER['PHP_SELF']); ?>?pageNumber=6';

                    if (targetTable) {
                        url = url + "&targetTable=" + targetTable;
                    }
                    if (targetTabOneTable) {
                        url = url + "&targetTabOneTable=" + targetTabOneTable;
                    }
                    if (targetTabTwoTable) {
                        url = url + "&targetTabTwoTable=" + targetTabTwoTable;
                    }
                    if (targetTabThreeTable) {
                        url = url + "&targetTabThreeTable=" + targetTabThreeTable;
                    }
                    if (targetTabFourTable) {
                        url = url + "&targetTabFourTable=" + targetTabFourTable;
                    }
                    if (targetTabFiveTable) {
                        url = url + "&targetTabFiveTable=" + targetTabFiveTable;
                    }


                    if (targetPackage) {
                        url = url + "&targetPackage=" + targetPackage;
                    }
                    if (targetModule) {
                        url = url + "&targetModule=" + targetModule;
                    }

                    if (targetDatabase) {
                        url = url + "&targetDatabase=" + targetDatabase;
                    }
                    if (targetDatabaseVendor) {
                        url = url + "&targetDatabaseVendor=" + targetDatabaseVendor;
                    }


                    if (targetSourceCode) {
                        url = url + "&targetSourceCode=" + targetSourceCode;
                    }
                    if (targetFormLayout) {
                        url = url + "&targetFormLayout=" + targetFormLayout;
                    }
                    if (targetFormStyle) {
                        url = url + "&targetFormStyle=" + targetFormStyle;
                    }
                    if (targetMaximumTabRecord) {
                        url = url + "&targetMaximumTabRecord=" + targetMaximumTabRecord;
                    }
					 if (targetFormBusinessFlow) {
                        url = url + "&targetFormBusinessFlow=" + targetFormBusinessFlow;
                    }

                    location.href = url;
				}

        </script>
        <span class="label label-error">**** For Column,data will not be save have to choose again</span>
    </body>
</html>    