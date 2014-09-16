<?php

function javascriptSourceCode($data, $dataTabDetail = null) {
    if (!$dataTabDetail) {
        $dataTabDetail = array();
    }
    $tabCounter = count($dataTabDetail);
    $total = 0;
    for ($j = 0; $j < $tabCounter; $j++) {
        if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
            $total = count($dataTabDetail[$j]);
            $dataTabDetail[$j]['total'] = $total;
            for ($i = 0; $i < $total; $i++) {
                if ($dataTabDetail[$j][$i]['Key'] == 'PRI') {
                    $dataTabDetail[$j][0]['tableName'] = str_replace('Id', '', $dataTabDetail[$j][0]['columnName']);
                }
            }
        } else {
            $dataTabDetail[$j][$i] = array();
        }
    }
    if (isset($data) && is_array($data)) {
        $total = count($data);
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['Key'] == 'PRI') {
                $data[0]['tableName'] = str_replace('Id', '', $data[0]['columnName']);
            }
        }
        $foreignKeyYes = null;
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['columnName'] != 'companyId') {
                if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                    $foreignKeyYes = 1;
                    break;
                }
            }
        }
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['columnName'] != 'companyId') {
                if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                    $str .= "	function get" . ucfirst(str_replace("Id", "", $data[$i]['columnName'])) . "(leafId,url, securityToken) {\n";
                    $str .= "			\$.ajax({\n";
                    $str .= "				type    		: 	'GET',\n";
                    $str .= "				url     		:	url,\n";
                    $str .= "				data    		:   {\n";
                    $str .= "				offset          :   0,\n";
                    $str .= "				limit           :   99999,\n";
                    $str .= "				method          :   'read',\n";
                    $str .= "				type            :   'filter',\n";
                    $str .= "				securityToken   :   securityToken,\n";
                    $str .= "				leafId          :   leafId,\n";
                    $str .= "				filter          :   '" . (str_replace("Id", "", $data[$i]['columnName'])) . "'\n";
                    $str .= "			},\n";
                    $str .= "			beforeSend: function () {\n";
                    $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
                    $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
                    $str .= "				\$infoPanel\n";
                    $str .= "					.html('').empty()\n";
                    $str .= "					.html(\"<span class='label label-warning'><img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
                    $str .= "				if(\$infoPanel.is(':hidden')) {\n";
                    $str .= "					\$infoPanel.show();\n";
                    $str .= "				}\n";
                    $str .= "			},\n";
                    $str .= "			success: function (data) {\n";
                    $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
                    $str .= "				var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
                    $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
                    $str .= "				var success 	=	data.success;\n";
                    $str .= "				var message		=	data.message;\n";
                    $str .= "				if(success === false ) { \n";
                    $str .= "					\$infoPanel\n";
                    $str .= "						.html('').empty()\n";
                    $str .= "						.html(\"<span class='label label-important'>&nbsp;<img src='\"+smileyRoll+\"'>\" + message + \"</spam>\");\n";

                    $str .= "				} else { \n";
                    $str .= "					\$(\"#" . $data[$i]['columnName'] . "\")\n";
                    $str .= "						.html('').empty()\n";
                    $str .= "                     	.html(data.data)\n";
                    $str .= "                     	.trigger(\"chosen:updated\");\n";
                    $str .= "					\$infoPanel\n";
                    $str .= "                     	.html('').empty()\n";
                    $str .= "                       .html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'>  \"+decodeURIComponent(t['loadingCompleteTextLabel'])+\"</span>\").delay(5000).fadeOut();\n";
                    $str .= "				}\n";
                    $str .= "			},\n";
                    $str .= "			error: function (xhr) {\n";
                    $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
                    $str .= "               \$('#infoError')\n";
                    $str .= "					.html('').empty()\n";
                    $str .= "					.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
                    $str .= "               \$('#infoErrorRowFluid')\n";
                    $str .= "					.removeClass().addClass('row-fluid');\n";
                    $str .= "			}\n";
                    $str .= "		});\n";
                    $str .= "	}\n";
                }
            }
        }
        $fieldName = '';
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
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isConsolidation'
            ) {
                $fieldName .= $data[$i]['columnName'] . ",";
            }
        }
        $fieldName = substr($fieldName, 0, -1);

        $fieldNameDetail = '';
        for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < $total; $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        $fieldNameDetail .= $dataTabDetail[$j][$i]['columnName'] . ",";
                    }
                }
            }
        }
        $fieldNameDetail = substr($fieldNameDetail, 0, -1);
        // check duplicate
        $str .= "	function checkDuplicate(leafId, page, securityToken){\n";
        $str .= "		var $" . $data[0]['tableName'] . "Code = \$(\"#" . $data[0]['tableName'] . "Code\");\n";
        $str .= "	    if($" . $data[0]['tableName'] . "Code.val().length ===0 ){\n";
        $str .= "	        alert(t['oddTextLabel']);\n";
        $str .= "	        return false;\n";
        $str .= "	    }\n";
        $str .= "	    \$.ajax({\n";
        $str .= "			type: 'GET',\n";
        $str .= "	        url: page,\n";
        $str .= "	        data: {\n";
        $str .= "	            " . $data[0]['tableName'] . "Code : $" . $data[0]['tableName'] . "Code.val(),\n";
        $str .= "	            method : 'duplicate',\n";
        $str .= "	            securityToken: securityToken,\n";
        $str .= "	            leafId: leafId\n";
        $str .= "			},\n";
        $str .= "	        beforeSend: function () {\n";
        $str .= "	            var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "	            \$infoPanel\n";
        $str .= "	            	.html('').empty()\n";
        $str .= "	            	.html(\"<span class='label label-warning'><img src='\"+smileyRoll+\"'>&nbsp;\" + decodeURIComponent(t['loadingTextLabel']) + \"....</span>\");\n";
        $str .= "	            if (\$infoPanel.is(':hidden')) {\n";
        $str .= "	                \$infoPanel.show();\n";
        $str .= "	            }\n";
        $str .= "	        },\n";
        $str .= "			success: function (data) {\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				var success		=	data.success;\n";
        $str .= "				var message		=	data.message;\n";
        $str .= "				var total		=	data.total;\n";
        $str .= "				if(success === true){\n";
        $str .= "					if(total  !==0){\n";
        $str .= "						$(\"#" . $data[0]['tableName'] . "Code\")\n";
        $str .= "							.val('')\n";
        $str .= "             				.focus();\n";
        $str .= "             			$(\"#" . $data[0]['tableName'] . "CodeForm\")\n";
        $str .= "             				.removeClass().addClass(\"form-group has-error\");\n";
        $str .= "             			\$infoPanel\n";
        $str .= "							.html('').empty()\n";
        $str .= "							.html(\"<img src='\"+smileyRoll+\"'> \"+t['codeDuplicateTextLabel']).delay(5000).fadeOut();\n";
        $str .= "             		} else{\n";
        $str .= "             			\$infoPanel\n";
        $str .= "							.html('').empty()\n";
        $str .= "							.html(\"<img src='\"+smileyLol+\"'> \"+t['codeAvailableTextLabel']).delay(5000).fadeOut();\n";
        $str .= "             		}\n";
        $str .= "				}else{\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";

        $str .= "					$(\"#" . $data[0]['tableName'] . "Form\")\n";
        $str .= "             			.removeClass().addClass(\"form-group has-error\");\n";
        $str .= "				}\n";
        $str .= "				if (\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "               	.html('').empty()\n";
        $str .= "               	.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "               \$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "             }\n";
        $str .= "	    });\n";
        $str .= "	}\n";
        // show grid
        $str .= "	function showGrid(leafId,page, securityToken, offset, limit,type) {\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type    :   'POST',\n";
        $str .= "			url     :   page,\n";
        $str .= "			data    :   {\n";
        $str .= "                 offset          :   offset,\n";
        $str .= "                 limit           :   limit,\n";
        $str .= "                 method          :   'read',\n";
        $str .= "                 type            :   'list',\n";
        $str .= "                 detail          :   'body',\n";
        $str .= "                 securityToken   :   securityToken,\n";
        $str .= "                 leafId          :   leafId\n";
        $str .= "			},\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='label label-warning'><img src='\"+smileyRoll+\"'>&nbsp;\"+decodeURIComponent(t['loadingTextLabel'])+\"....</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";
        $str .= "	            var \$centerViewPort	=	\$('#centerViewport');\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
        $str .= "				var success		=	data.success;\n";
        $str .= "				var message		=	data.message;\n";
        $str .= "				if(success === false ) { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-important'>&nbsp;<img src='\"+smileyRoll+\"'> \"+message+\"</span>\");\n";
        $str .= "				} else{ \n";
        $str .= "					\$centerViewPort\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "                     	.append(data);\n";
        $str .= "				}\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty();\n";
        $str .= "				if(type===1){\n";
        $str .= "					\$infoPanel.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['loadingCompleteTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
        $str .= "				} else if (type===2) { ";
        $str .= "					\$infoPanel.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['deleteRecordTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
        $str .= "				}";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "				\$(document).scrollTop();\n";
        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "				\$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "			}\n";
        $str .= "		});\n";
        $str .= "	}\n";

        $str .= "	function ajaxQuerySearchAll(leafId,url, securityToken) {\n";
        $str .= "		\$('#clearSearch')\n";
        $str .= "         	.removeClass().addClass('btn');\n";
        $str .= "		var queryGrid =\$('#query').val();\n";
        $str .= "		var queryWidget =\$('#queryWidget').val();\n";
        $str .= "		var queryText;\n";
        $str .= "		if(queryGrid !== undefined) { \n";
        $str .= "			if(queryGrid.length > 0 ) { \n";
        $str .= "				queryText = queryGrid; \n";
        $str .= "			}  else {  \n";
        $str .= "				queryText = queryWidget; \n";
        $str .= "			} \n";
        $str .= "		} else { \n";
        $str .= "			queryText = queryWidget; \n";
        $str .= "		}\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type    :   'POST',\n";
        $str .= "			url     :   url,\n";
        $str .= "			data    :   {\n";
        $str .= "				offset          :   0,\n";
        $str .= "				limit           :   99999,\n";
        $str .= "				method          :   'read',\n";
        $str .= "				type            :   'list',\n";
        $str .= "				detail          :   'body',\n";
        $str .= "				query           :   queryText,\n";
        $str .= "				securityToken   :   securityToken,\n";
        $str .= "				leafId          :   leafId\n";
        $str .= "			},\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "	            var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "                 	.html('').empty()\n";
        $str .= "                 	.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";
        $str .= "	            var \$centerViewPort	=	\$('#centerViewport');\n";
        $str .= "				var smileyRoll 			=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var zoomIcon 			=	'./images/icons/magnifier-zoom-actual-equal.png';\n";
        $str .= "				var success				=	data.success;\n";
        $str .= "				var message				=	data.message;\n";
        $str .= "				if(success === false ) { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "                     	.html(\"<span class='label label-important'>&nbsp;<img src='\"+smileyRoll+\"'> \"+message+\"</span>\");\n";
        $str .= "				} else { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "                     	.append(data);\n";
        $str .= "				}\n";
        $str .= "	            var \$infoPanel			=	\$('#infoPanel');\n";
        $str .= "					\$infoPanel\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "					.html(\"&nbsp;<img src='\"+zoomIcon+\"'> <b>\"+decodeURIComponent(t['filterTextLabel'])+'</b>: '+queryText+\"\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "                     \$(document).scrollTop();\n";
        $str .= "             },\n";
        $str .= "             error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='alert alert-error col-xs-12 col-md-12 col-sm-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "               \$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "             }\n";
        $str .= "         });\n";
        $str .= "	}\n";

        // search all character
        $str .= "	function ajaxQuerySearchAllCharacter(leafId,url, securityToken,character) {\n";
        $str .= "		\$('#clearSearch')\n";
        $str .= "			.removeClass().addClass('btn btn-primary');\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type    : 	'POST',\n";
        $str .= "			url     :	url,\n";
        $str .= "			data    :   {\n";
        $str .= "				offset          :   0,\n";
        $str .= "				limit           :   99999,\n";
        $str .= "				method          :   'read',\n";
        $str .= "				type            :   'list',\n";
        $str .= "				detail          :   'body',\n";
        $str .= "				securityToken   :   securityToken,\n";
        $str .= "				leafId          :   leafId,\n";
        $str .= "				character       :   character\n";
        $str .= "			},\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "	            var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "             	\$infoPanel\n";
        $str .= "              		.html('').empty()\n";
        $str .= "					.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";

        $str .= "	            var \$centerViewPort	=	\$('#centerViewport');\n";
        $str .= "				var smileyRoll 			=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var zoomIcon 			=	'./images/icons/magnifier-zoom-actual-equal.png';\n";
        $str .= "				var success				=	data.success;\n";
        $str .= "				var message				=	data.message;\n";
        $str .= "				if(success === false ) { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "                     	.html(\"<span class='label label-important'>&nbsp;<img src='\"+smileyRoll+\"'> \"+message+\"</span>\");\n";
        $str .= "				} else { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "                     	.append(data);\n";
        $str .= "				}\n";
        $str .= "				var \$infoPanel			=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"&nbsp;<img src='\"+zoomIcon+\"'> <b>\"+decodeURIComponent(t['filterTextLabel'])+\"</b>: \"+character+\" \");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "				\$(document).scrollTop();\n";
        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html('').html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "               \$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "             }\n";
        $str .= "         });\n";
        $str .= "	}\n";

        // search all record date
        $str .= "	function ajaxQuerySearchAllDate(leafId,url, securityToken,dateRangeStart,dateRangeEnd,dateRangeType) {\n";
        $str .= "		// date array \n";
        $str .= "		Date.prototype.getMonthName = function() {\n";
        $str .= "			var m = [t['januaryTextLabel'],t['februaryTextLabel'],t['marchTextLabel'],t['aprilTextLabel'],t['mayTextLabel'],t['juneTextLabel'],t['julyTextLabel'],\n";
        $str .= "			t['augustTextLabel'],t['septemberTextLabel'],t['octoberTextLabel'],t['novemberTextLabel'],t['decemberTextLabel']];\n";

        $str .= "			return m[this.getMonth()];\n";
        $str .= "		};\n";

        $str .= "		Date.prototype.getDayName = function() {\n";
        $str .= "			var d = [t['sundayTextLabel'],t['mondayTextLabel'],t['tuesdayTextLabel'],t['wednesdayTextLabel'],\n";
        $str .= "				t['thursdayTextLabel'],t['fridayTextLabel'],t['saturdayTextLabel']];\n";
        $str .= "			return d[this.getDay()];\n";
        $str .= "		};\n";

        $str .= "		var calendarPng;\n";
        $str .= "		var strDate;\n";
        $str .= "		var dateStart = new Date(); \n";
        $str .= "		var partsStart = String(dateRangeStart).split('-');  \n";

        $str .= "		dateStart.setFullYear(partsStart[2]);  \n";
        $str .= "		dateStart.setMonth(partsStart[1]-1); \n";
        $str .= "		dateStart.setDate(partsStart[0]);\n";
        $str .= "		var dateEnd = new Date(); \n";

        $str .= "		if(dateRangeEnd.length >  0)    {\n";
        $str .= "			var partsEnd = String(dateRangeEnd).split('-');  \n";

        $str .= "			dateEnd.setFullYear(partsEnd[2]); \n";
        $str .= "			dateEnd.setMonth(partsEnd[1]-1);  \n";
        $str .= "			dateEnd.setDate(partsEnd[0]);\n";
        $str .= "		}\n";

        $str .= "		// unlimited for searching because  lazy paging.\n";
        $str .= "		if(dateRangeStart.length === 0)  {\n";
        $str .= "			dateRangeStart = $('#dateRangeStart').val();\n";
        $str .= "		} \n";
        $str .= "		if(dateRangeEnd.length === 0)    {\n";
        $str .= "			dateRangeEnd = $('#dateRangeEnd').val();\n";
        $str .= "		}\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type    : 	'POST',\n";
        $str .= "			url     :	url,\n";
        $str .= "			data    :   {\n";
        $str .= "                 offset              :   0,\n";
        $str .= "                 limit               :   99999,\n";
        $str .= "                 method              :   'read',\n";
        $str .= "                 type                :   'list',\n";
        $str .= "                 detail              :   'body',\n";
        $str .= "                 query               :   \$('#query').val(),\n";
        $str .= "                 securityToken       :   securityToken,\n";
        $str .= "                 leafId              :   leafId,\n";
        $str .= "                 dateRangeStart      :   dateRangeStart,\n";
        $str .= "                 dateRangeEnd        :   dateRangeEnd,\n";
        $str .= "                 dateRangeType       :   dateRangeType\n";
        $str .= "             },\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "                	.html(\"<span class='label label-warning'><img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";
        $str .= "	            var \$centerViewPort	=	\$('#centerViewport');\n";
        $str .= "				var betweenIcon = './images/icons/arrow-curve-000-left.png';";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var success		=	data.success;\n";
        $str .= "				var message		=	data.message;\n";
        $str .= "				if(success === false ) { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "                    	.html('').empty()\n";
        $str .= "                     	.html(\"<span class='label label-important'>&nbsp;<img src='\"+smileyRoll+\"'>\"+message+\"</span>\");\n";
        $str .= "				} else { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "                     	.append(data);\n";
        $str .= "  				}\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty();\n";
        $str .= "				if(dateRangeType==='day') {\n";
        $str .= "					calendarPng='calendar-select-days.png';\n";
        $str .= "				}else if(dateRangeType==='week' || dateRangeType==='between'){\n";
        $str .= "					calendarPng='calendar-select-week.png';\n";
        $str .= "				}else if(dateRangeType==='month'){\n";
        $str .= "					calendarPng='calendar-select-month.png';\n";
        $str .= "				}else if(dateRangeType==='year'){\n";
        $str .= "					calendarPng='calendar-select.png';\n";
        $str .= "				}else{\n";
        $str .= "					calendarPng='calendar-select.png';\n";
        $str .= "				}\n";
        $str .= "				switch(dateRangeType){\n";
        $str .= "					case 'day':\n";
        $str .= "						strDate = \"<b>\"+t['dayTextLabel']+\"</b> : \"+dateStart.getDayName()+\", \"+dateStart.getMonthName()+\", \"+dateStart.getDate()+\", \"+dateStart.getFullYear();\n";
        $str .= "					break;\n";
        $str .= "					case 'month':\n";
        $str .= "						strDate = \"<b>\"+t['monthTextLabel']+\"</b> : \"+dateStart.getMonthName()+\", \"+dateStart.getFullYear();\n";
        $str .= "					break;\n";
        $str .= "					case 'year':\n";
        $str .= "						strDate = \"<b>\"+t['yearTextLabel']+\"</b> : \"+dateStart.getFullYear();\n";
        $str .= "					break;\n";
        $str .= "					case 'week':\n";
        $str .= "						if(dateRangeEnd.length===0){\n";
        $str .= "							strDate = \"<b>\"+t['dayTextLabel']+\"</b> : \"+dateStart.getDayName()+\", \"+dateStart.getMonthName()+\", \"+dateStart.getDate()+\", \"+dateStart.getFullYear();\n";
        $str .= "						}else{\n";
        $str .= "							strDate = \"<b>\"+t['betweenTextLabel']+\"</b> : \"+dateStart.getDayName()+\", \"+dateStart.getMonthName()+\", \"+dateStart.getDate()+\", \"+dateStart.getFullYear()+\"&nbsp;<img src='\"+betweenIcon+\"'>&nbsp;\"+dateEnd.getDayName()+\", \"+dateEnd.getMonthName()+\", \"+dateEnd.getDate()+\", \"+dateEnd.getFullYear();\n";
        $str .= "						}  \n";
        $str .= "					break;\n";
        $str .= "					case 'between':\n";
        $str .= "						if(dateRangeEnd.length===0){\n";
        $str .= "							strDate = \"<b>\"+t['dayTextLabel']+\"</b> : \"+dateStart.getDayName()+\", \"+dateStart.getMonthName()+\", \"+dateStart.getDate()+', '+dateStart.getFullYear();\n";
        $str .= "						}else{\n";
        $str .= "							strDate = \"<b>\"+t['betweenTextLabel']+\"</b> : \"+dateStart.getDayName()+\", \"+dateStart.getMonthName()+\", \"+dateStart.getDate()+\", \"+dateStart.getFullYear()+\"&nbsp;<img src='\"+betweenIcon+\"'>&nbsp;\"+dateEnd.getDayName()+\", \"+dateEnd.getMonthName()+\", \"+dateEnd.getDate()+\", \"+dateEnd.getFullYear(); \n";
        $str .= "						}\n";
        $str .= "					break;\n";
        $str .= "				} \n";
        $str .= "				var imageCalendarPath = \"./images/icons/\"+calendarPng;\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<img src='\"+imageCalendarPath+\"'> \"+strDate+\" \");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "				\$(document).scrollTop();\n";
        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "               	.html('').empty()\n";
        $str .= "               	.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "               \$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "			}\n";
        $str .= "		});\n";
        $str .= "	}\n";
        $str .= "	function ajaxQuerySearchAllDateRange(leafId,url, securityToken) {\n";
        $str .= "		ajaxQuerySearchAllDate(leafId,url, securityToken,$('#dateRangeStart').val(),$('#dateRangeEnd').val(),'between'); \n";
        $str .= "	}\n";

        // show form
        $str .= "	function showForm(leafId,url, securityToken) {\n";
        $str .= "		sleep(500);\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type    :   'POST',\n";
        $str .= "			url     :   url,\n";
        $str .= "			data    :   {\n";
        $str .= "				method          :   'new',\n";
        $str .= "				type            :   'form',\n";
        $str .= "				securityToken   :   securityToken,\n";
        $str .= "				leafId          :   leafId\n";
        $str .= "			},\n";
        $str .= "			beforeSend  :   function () {\n";
        $str .= "	            var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "                 	.html('').empty()\n";
        $str .= "                	.html(\"<span class='label label-warning'><img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";
        $str .= "	            var \$centerViewPort	=	\$('#centerViewport');\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
        $str .= "				var success		=	data.success;\n";
        $str .= "				var message		=	data.message;\n";
        $str .= "				if(success === false ) { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "						.html('').empty()\n";
        $str .= "                     	.html(\"<span class='label label-important'>&nbsp;<img src='\"+smileyRoll+\"'> \"+message+\"</span>\");\n";
        $str .= "				} else { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "                     	.append(data);\n";
        $str .= "					var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "					\$infoPanel\n";
        $str .= "                     	.html('').empty()\n";
        $str .= "                     	.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['loadingCompleteTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
        $str .= "					if(\$infoPanel.is(':hidden')) {\n";
        $str .= "						\$infoPanel.show();\n";
        $str .= "					}\n";
        $str .= "					\$(document).scrollTop();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "               	.html('').empty()\n";
        $str .= "               	.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "               \$('#infoErrorRowFluid')\n";
        $str .= "               	.removeClass().addClass('row-fluid');\n";
        $str .= "			}\n";
        $str .= "         });\n";
        $str .= "	}\n";

        // form update
        $str .= "	function showFormUpdate(leafId,url,urlList, securityToken, " . $data[0]['primaryKeyName'] . ",updateAccess,deleteAccess) {\n";
        $str .= "		sleep(500);\n";
        $str .= "		\$('a[rel=tooltip]').tooltip('hide');\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type	:   'POST',\n";
        $str .= "    		url	:   urlList,\n";
        $str .= "			data	:   {\n";
        $str .= "				method          :   'read',\n";
        $str .= "				type            :   'form',\n";
        $str .= "				" . $data[0]['primaryKeyName'] . "  :   " . $data[0]['primaryKeyName'] . ",\n";
        $str .= "				securityToken   :   securityToken,\n";
        $str .= "				leafId          :   leafId\n";
        $str .= "			},\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='label label-warning'><img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";
        $str .= "				var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				var \$centerViewPort	=	\$('#centerViewport');\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
        $str .= "				var success		=	data.success;\n";
        $str .= "				var message		=	data.message;\n";
        $str .= "				if(success === false ) { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-important'>&nbsp;<img src='\"+smileyRoll+\"'> \"+message+\"</span>\");\n";
        $str .= "				} else { \n";
        $str .= "					\$centerViewPort\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.append(data);\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['loadingCompleteTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
        $str .= "					if(\$infoPanel.is(':hidden')) {\n";
        $str .= "						\$infoPanel.show();\n";
        $str .= "					}\n";
        $str .= "					\$('#newRecordButton1')\n";
        $str .= "						.removeClass().addClass('btn btn-success disabled'); \n";
        $str .= "					\$('#newRecordButton2')\n";
        $str .= "						.removeClass().addClass('btn  dropdown-toggle btn-success disabled'); \n";
        $str .= "					\$('#newRecordButton3').attr('onClick', ''); \n";
        $str .= "					\$('#newRecordButton4').attr('onClick', ''); \n";
        $str .= "					\$('#newRecordButton5').attr('onClick', ''); \n";
        $str .= "					\$('#newRecordButton6').attr('onClick', ''); \n";
        $str .= "					\$('#newRecordButton7').attr('onClick', ''); \n";
        $str .= "					if(updateAccess === 1) {\n";
        $str .= "						\$('#updateRecordButton1')\n";
        $str .= "							.removeClass().addClass('btn btn-info').attr('onClick', \"updateRecord(\"+leafId+\",\\\"\"+url+\"\\\",\\\"\"+urlList+\"\\\",\\\"\"+securityToken+\"\\\",1,\"+deleteAccess+\")\"); ; \n";
        $str .= "						\$('#updateRecordButton2')\n";
        $str .= "							.removeClass().addClass('btn dropdown-toggle btn-info'); \n";
        $str .= "						\$('#updateRecordButton3').attr('onClick', \"updateRecord(\"+leafId+\",\\\"\"+url+\"\\\",\\\"\"+urlList+\"\\\",\\\"\"+securityToken+\"\\\",1,\"+deleteAccess+\")\"); \n";
        $str .= "						\$('#updateRecordButton4').attr('onClick', \"updateRecord(\"+leafId+\",\\\"\"+url+\"\\\",\\\"\"+urlList+\"\\\",\\\"\"+securityToken+\"\\\",2,\"+deleteAccess+\")\"); \n";
        $str .= "						\$('#updateRecordButton5').attr('onClick', \"updateRecord(\"+leafId+\",\\\"\"+url+\"\\\",\\\"\"+urlList+\"\\\",\\\"\"+securityToken+\"\\\",3,\"+deleteAccess+\")\"); \n";
        $str .= "					} else {\n";
        $str .= "						\$('#updateRecordButton1')\n";
        $str .= "							.removeClass().addClass('btn btn-info disabled'); \n";
        $str .= "						\$('#updateRecordButton2')\n";
        $str .= "							.removeClass().addClass('btn dropdown-toggle btn-info disabled'); \n";
        $str .= "						\$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "						\$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "						\$('#updateRecordButton5').attr('onClick', ''); \n";
        $str .= "					}\n";
        $str .= "					if(deleteAccess===1) {\n";
        $str .= "						\$('#deleteRecordButton')\n";
        $str .= "							.removeClass().addClass('btn btn-danger')\n";
        $str .= "							.attr('onClick', \"deleteRecord(\"+leafId+\",\\\"\"+url+\"\\\",\\\"\"+urlList+\"\\\",\\\"\"+securityToken+\"\\\",\"+deleteAccess+\")\"); \n";
        $str .= "					} else {\n";
        $str .= "						\$('#deleteRecordButton')\n";
        $str .= "							.removeClass().addClass('btn btn-danger')\n";
        $str .= "							.attr('onClick',''); \n";

        $str .= "					}\n";
        $str .= "					\$(document).scrollTop();\n";
        $str .= "				}\n";


        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "				\$('#infoError')\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='alert alert-error col-xs-12 col-md-12 col-sm-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "				\$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "			}\n";
        $str .= "		});\n";
        $str .= "	}\n";

        // delete delete modal
        $str .= "	function showModalDelete(" . $fieldName . ") {\n";
        $str .= "		// clear first old record if exist\n";
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
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isConsolidation'
            ) {
                $str .= "		\$('#" . $data[$i]['columnName'] . "Preview').val('').val(decodeURIComponent(" . $data[$i]['columnName'] . "));\n";
            }
        }
        $str .= "		showMeModal('deletePreview', 1);\n";
        $str .= "	}\n";
        // delete grid record
        $str .= "	function deleteGridRecord(leafId,url,urlList,securityToken) {\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type    :   'POST',\n";
        $str .= "			url     :   url,\n";
        $str .= "			data    :   {\n";
        $str .= "				method          :   'delete',\n";
        $str .= "				output          :   'json',\n";
        $str .= "				" . $data[0]['primaryKeyName'] . "	:   \$('#" . $data[0]['primaryKeyName'] . "Preview').val(),\n";
        $str .= "				securityToken   :   securityToken,\n";
        $str .= "				leafId          :   leafId\n";
        $str .= "			},\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "                 	.html(\"<span class='label label-warning'><img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				var success = data.success;\n";
        $str .= "				var message = data.message;\n";
        $str .= "				if (success === true) {\n";
        $str .= "					showMeModal('deletePreview',0);\n";
        $str .= "					showGrid(leafId,urlList,securityToken,0,10,2); \n";
        $str .= "				} else if (success === false) {\n";
        $str .= "					\$infoPanel\n";
        $str .= "					 	.html('').empty()\n";
        $str .= "                     	.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "					if(\$infoPanel.is(':hidden')) {\n";
        $str .= "						\$infoPanel.show();\n";
        $str .= "					}\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "               	.html('').empty()\n";
        $str .= "              		.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "               \$('#infoErrorRowFluid')\n";
        $str .= "               	.removeClass().addClass('row-fluid');\n";
        $str .= "			}\n";
        $str .= "		});\n";
        $str .= "	}\n";


        for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                // here we append at table body.. so scrolling not much..
                $str .= "	function showFormCreate" . $j . "(leafId,url, securityToken) {\n";
                $str .= "		var \$infoPanel	=	\$('#infoPanel');\n";
                $d = 0;
                for ($i = 0; $i < $total; $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isAdmin' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'journalNumber' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != $dataTabDetail[$j][0]['primaryKeyName']
                    ) {
                        if ($i != 0) {
                            if ($dataTabDetail[$j][$i]['validate'] == 1) {
                                $str .= "		if (\$('#" . $dataTabDetail[$j][$i]['columnName'] . "9999').val().length === 0) {\n";
                                $str .= "			\$infoPanel\n";
                                $str .= "				.html('').empty()\n";
                                $str .= "				.html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+\" : \"+leafTranslation['" . $dataTabDetail[$j][$i]['columnName'] . "Label']+\"</span>\");\n";
                                $str .= "			\$('#" . $dataTabDetail[$j][$i]['columnName'] . "9999HelpMe')\n";
                                $str .= "				.html('').empty()\n";
                                $str .= "				.html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+\" : \"+leafTranslation['" . $dataTabDetail[$j][$i]['columnName'] . "Label']+\"</span>\");\n";
                                if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                                    $str .= "			\$('#" . $dataTabDetail[$j][$i]['columnName'] . "9999').data('chosen').activate_action();\n";
                                } else {
                                    $str .= "			\$('#" . $dataTabDetail[$j][$i]['columnName'] . "9999Form')\n";
                                    $str .= "				.removeClass().addClass('form-group has-error');\n";
                                    $str .= "			\$('#" . $dataTabDetail[$j][$i]['columnName'] . "9999').focus();\n";
                                }
                                $str .= "				return false;\n";
                                $str .= "		}\n";
                            }
                        }
                    }
                }
                $str .= "		\$infoPanel\n";
                $str .= "			.html('').empty()\n";
                $str .= "			.html(\"<span class='label label-success'>&nbsp;\"+decodeURIComponent(t['loadingCompleteTextLabel'])+\"</span>\");\n";
                $str .= "			if(\$infoPanel.is(':hidden')) {\n";
                $str .= "				\$infoPanel.show();\n";
                $str .= "			}\n";
                $str .= "			\$.ajax({\n";
                $str .= "				type	:   'POST',\n";
                $str .= "				url		:   url,\n";
                $str .= "				data	:   {\n";
                $str .= "					method  :   'create',\n";
                $str .= "					output  :	'json',\n";
                // main primary key  index and take from input hidden
                $str .= "					" . $data[0]['primaryKeyName'] . " : \$('#" . $data[0]['primaryKeyName'] . "').val(),\n";

                for ($i = 0; $i < $total; $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'journalNumber' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != $dataTabDetail[$j][0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        $str .= "					" . $dataTabDetail[$j][$i]['columnName'] . " :   \$('#" . $dataTabDetail[$j][$i]['columnName'] . "9999').val(),\n";
                    }
                }
                $str .= "					securityToken   :   securityToken,\n";
                $str .= "					leafId          :   leafId\n";
                $str .= "				},\n";
                $str .= "			beforeSend: function () {\n";
                $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
                $str .= "				var \$infoPanel	=	\$('#infoPanel');\n";
                $str .= "				\$infoPanel\n";
                $str .= "					.html('').empty()\n";
                $str .= "					.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
                $str .= "				\$('#miniInfoPanel9999')\n";
                $str .= "					.html('').empty()\n";
                $str .= "					.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
                $str .= "				if(\$infoPanel.is(':hidden')) {\n";
                $str .= "					\$infoPanel.show();\n";
                $str .= "				}\n";
                $str .= "			},\n";
                $str .= "			success: function (data) {\n";
                $str .= "				var success = data.success;\n";
                $str .= "				var message = data.message;\n";
                $str .= "				if (success === true) {\n";

                $str .= "					\$.ajax({\n";
                $str .= "						type	:   'POST',\n";
                $str .= "						url		:   url,\n";
                $str .= "						data	:   {\n";
                $str .= "							method  :   'read',\n";
                $str .= "							output  :	'table',\n";
                $str .= "							offset  :	'0',\n";
                $str .= "							limit   :	'9999',\n";
                // main primary key  index and take from input hidden
                $str .= "							" . $data[0]['primaryKeyName'] . " : \$('#" . $data[0]['primaryKeyName'] . "').val(),\n";
                $str .= "							securityToken   :   securityToken,\n";
                $str .= "							leafId          :   leafId\n";
                $str .= "						},\n";
                $str .= "						beforeSend: function () {\n";
                $str .= "							var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
                $str .= "							var \$infoPanel	=	\$('#infoPanel');\n";
                $str .= "							\$infoPanel\n";
                $str .= "								.html('').empty()\n";
                $str .= "								.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
                $str .= "							\$('#miniInfoPanel9999')\n";
                $str .= "								.empty().html('')\n";
                $str .= "								.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
                $str .= "							if(\$infoPanel.is(':hidden')) {\n";
                $str .= "								\$infoPanel.show();\n";
                $str .= "							}\n";
                $str .= "						},\n";
                $str .= "						success: function (data) {\n";
                $str .= "							var \$infoPanel	=	\$('#infoPanel');\n";
                $str .= "							var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
                $str .= "							var success		=   data.success;\n";
                $str .= "							if (success === true) {\n";
                $str .= "								\$('#tableBody')\n";
                $str .= "									.html('').empty()\n";
                $str .= "									.html(data.tableData);\n";

                for ($i = 0; $i < $total; $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != $dataTabDetail[$j][0]['primaryKeyName']
                    ) {
                        $str .= "							\$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "9999\")\n";
                        $str .= "								.prop(\"disabled\",\"false\")\n";
                        $str .= "								.removeAttr(\"disabled\",\"\")\n";
                        $str .= "								.val('')\n";
                        if ($dataTabDetail[$j][$i]['Key'] == 'MUL' && $dataTabDetail[$j][$i]['Key'] != 'PRI') {
                            $str .= "								.trigger(\"chosen:updated\");\n";
                        } else {
                            $str .=";\n";
                        }
                    }
                }
                $str .= "								$(\".chzn-select\").chosen();\n";
                $str .= "								\$infoPanel\n";
                $str .= "									.html('').empty()\n";
                $str .= "									.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['loadingCompleteTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
                $str .= "								if(\$infoPanel.is(':hidden')) {\n";
                $str .= "									\$infoPanel.show();\n";
                $str .= "								}\n";
                $str .= "							}\n";
                $str .= "						},\n";
                $str .= "						error: function (xhr) {\n";
                $str .= "							var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
                $str .= "							\$('#infoError')\n";
                $str .= "								.html('').empty()\n";
                $str .= "								.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
                $str .= "							\$('#infoErrorRowFluid')\n";
                $str .= "								.removeClass().addClass('row-fluid');\n";
                $str .= "						}\n";
                $str .= "					});\n";
                $str .= "					\$('#miniInfoPanel9999').html(\"<span class='label label-success'>&nbsp;<a class='close' data-dismiss='alert' href='#'>&times;</a><img src='./images/icons/smiley-lol.png'> \"+decodeURIComponent(t['newRecordTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
                $str .= "				} else if (success === false) {\n";
                $str .= "					\$('#infoPanel').html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
                $str .= "				}\n";
                $str .= "			},\n";
                $str .= "			error: function (xhr) {\n";
                $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
                $str .= "				\$('#infoError')\n";
                $str .= "					.html('').empty()\n";
                $str .= "					.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
                $str .= "				\$('#infoErrorRowFluid')\n";
                $str .= "					.removeClass().addClass('row-fluid');\n";
                $str .= "			}\n";
                $str .= "		});\n";

                $str .= "   }\n ";
            }
        }

        for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);

                $str .= "	function showFormUpdate" . $j . "(leafId,url, securityToken, " . $dataTabDetail[0]['primaryKeyName'] . ") {\n";
                $str .= "		var \$infoPanel	=	\$('#infoPanel');\n";
                $d = 0;
                for ($i = 0; $i < $total; $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != $dataTabDetail[$j][0]['primaryKeyName']
                    ) {
                        if ($i != 0) {
                            if ($dataTabDetail[$j][$i]['validate'] == 1) {
                                $str .= "             if (\$('#" . $dataTabDetail[$j][$i]['columnName'] . "'+" . $dataTabDetail[$j][0]['primaryKeyName'] . ").val().length === 0) {\n";
                                $str .= "                 \$infoPanel.html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+' :'+leafTranslation['" . $dataTabDetail[$j][$i]['columnName'] . "Label']+\"</span>\");\n";
                                $str .= "				   \$('#" . $dataTabDetail[$j][$i]['columnName'] . "'+" . $dataTabDetail[$j][0]['primaryKeyName'] . "+'HelpMe')\n";
                                $str .= "				   .html('').empty()\n";
                                $str .= "                  .html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+' :'+leafTranslation['" . $dataTabDetail[$j][$i]['columnName'] . "Label']+\"</span>\");\n";
                                if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                                    $str .= "                 \$('#" . $dataTabDetail[$j][$i]['columnName'] . "'+" . $dataTabDetail[$j][0]['primaryKeyName'] . ").data('chosen').activate_action();\n";
                                } else {
                                    $str .= "                 \$('#" . $dataTabDetail[$j][$i]['columnName'] . "'+" . $dataTabDetail[$j][0]['primaryKeyName'] . ")\n";
                                    $str .= "				  	.removeClass().addClass('form-group has-error');\n";
                                    $str .= "                 \$('#" . $dataTabDetail[$j][$i]['columnName'] . "'+" . $dataTabDetail[$j][0]['primaryKeyName'] . ").focus();\n";
                                }
                                $str .= "                 return false;\n";
                                $str .= "               }\n";
                            }
                        }
                    }
                }

                $str .= "                 \$.ajax({\n";
                $str .= "                     type	:   'POST',\n";
                $str .= "                     url	:   url,\n";
                $str .= "                     data	:   {\n";
                $str .= "                         method  :   'save',\n";
                $str .= "                         output  :	'json',\n";
                for ($i = 0; $i < $total; $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName']
                    ) {
                        $str .= "                         " . $dataTabDetail[$j][$i]['columnName'] . " :   \$('#" . $dataTabDetail[$j][$i]['columnName'] . "'+" . $dataTabDetail[$j][0]['primaryKeyName'] . ").val(),\n";
                    } else if ($dataTabDetail[$j][$i]['columnName'] == $data[0]['primaryKeyName']) {
                        $str .= "                         " . $dataTabDetail[$j][$i]['columnName'] . " :   \$('#" . $dataTabDetail[$j][$i]['columnName'] . "').val(),\n";
                    }
                }
                $str .= "					securityToken   :   securityToken,\n";
                $str .= "					leafId          :   leafId\n";
                $str .= "				},\n";
                $str .= "         		beforeSend: function () {\n";
                $str .= "	            	var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
                $str .= "	            	var \$infoPanel	=	\$('#infoPanel');\n";
                $str .= "             		\$infoPanel\n";
                $str .= "             			.html('').empty()\n";
                $str .= "             			.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
                $str .= "             		\$('#miniInfoPanel'+" . $dataTabDetail[$j][0]['primaryKeyName'] . "    )\n";
                $str .= "             			.html('').empty()\n";
                $str .= "             			.html(\"<span class='label label-warning'> <img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
                $str .= "             		if(\$infoPanel.is(':hidden')) {\n";
                $str .= "             			\$infoPanel.show();\n";
                $str .= "             		}\n";
                $str .= "         		},\n";
                $str .= "				success: function (data) {\n";
                $str .= "					var \$infoPanel	=	\$('#infoPanel');\n";
                $str .= "					var \$miniInfoPanel = \$('#miniInfoPanel'+" . $dataTabDetail[$j][0]['primaryKeyName'] . ");\n";
                $str .= "					var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
                $str .= "					var success		= 	data.success;\n";
                $str .= "					var message 	=	data.message;\n";
                $str .= "					if (success === true) {\n";
                $str .= "						\$infoPanel\n";
                $str .= "							.html('').empty()\n";
                $str .= "							.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['updateRecordTextLabel'])+\"</span>\");\n";
                $str .= "						\$miniInfoPanel\n";
                $str .= "							.html('').empty()\n";
                $str .= "							.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'><a class='close' data-dismiss='alert' href='#'>&times;</a></span>\");\n";
                $str .= "					} else if (success === false) {\n";
                $str .= "						\$infoPanel.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
                $str .= "						\$miniInfoPanel.html(\"<span class='label label-important'>&nbsp; \"+ message + \"</span>\");\n";
                $str .= "						if(\$infoPanel.is(':hidden')) {\n";
                $str .= "							\$infoPanel.show();\n";
                $str .= "						}\n";
                $str .= "					}\n";
                $str .= "				},\n";
                $str .= "				error: function (xhr) {\n";
                $str .= "					var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
                $str .= "               	\$('#infoError')\n";
                $str .= "               		.html('').empty()\n";
                $str .= "               		.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
                $str .= "					\$('#infoErrorRowFluid')\n";
                $str .= "						.removeClass().addClass('row-fluid');\n";
                $str .= "				}\n";
                $str .= "		});\n";
                $str .= "	}\n";
            }
        }


        for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                $str .= "	function showModalDelete" . $j . "(" . $dataTabDetail[$j][0]['primaryKeyName'] . ") {\n";
                for ($i = 0; $i < count($total); $i++) {
// this field is auto update by session
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($dataTabDetail[$j][$i]['Key'] === 'MUL') {
                            $str .= "		\$('#" . $dataTabDetail[$j][$i]['columnName'] . "Preview').val('').val(decodeURIComponent(\$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\"+" . $dataTabDetail[$j][0]['primaryKeyName'] . "+\" option:selected\").text()));\n\n";
                        } else {
                            $str .= "		\$('#" . $dataTabDetail[$j][$i]['columnName'] . "Preview').val('').val(decodeURIComponent(\$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\"+" . $dataTabDetail[$j][0]['primaryKeyName'] . ").val()));\n\n";
                        }
                    }
                }
                $str .= "		showMeModal('deleteDetailPreview', 1);\n";
                $str .= "	}\n";
            }
        }


        for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                $str .= "	function deleteGridRecord" . $j . "(leafId,url,urlList,securityToken) {\n";
                $str .= "		\$.ajax({\n";
                $str .= "			type    :   'POST',\n";
                $str .= "			url     :   url,\n";
                $str .= "			data    :   {\n";
                $str .= "				method          :   'delete',\n";
                $str .= "				output          :   'json',\n";
                $str .= "				" . $dataTabDetail[$j][0]['primaryKeyName'] . "	:   \$('#" . $dataTabDetail[$j][0]['primaryKeyName'] . "Preview').val(),\n";
                $str .= "				securityToken   :   securityToken,\n";
                $str .= "				leafId          :   leafId\n";
                $str .= "			},\n";
                $str .= "			beforeSend: function () {\n";
                $str .= "	            var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
                $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
                $str .= "				\$infoPanel\n";
                $str .= "                 	.html('').empty()\n";
                $str .= "                 	.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
                $str .= "				if(\$infoPanel.is(':hidden')) {\n";
                $str .= "                 	\$infoPanel.show();\n";
                $str .= "				}\n";
                $str .= "			},\n";
                $str .= "			success: function (data) {\n";
                $str .= "				var \$infoPanel	=	\$('#infoPanel');\n";
                $str .= "				var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
                $str .= "				var success 	=	 data.success;\n";
                $str .= "				var message		=	 data.message;\n";
                $str .= "				if (success === true) {\n";
                $str .= "					showMeModal('deleteDetailPreview',0);\n";
                $str .= "					\$infoPanel\n";
                $str .= "						.html('').empty()\n";
                $str .= "						.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['deleteRecordTextLabel'])+\"</span>\");\n";
                $str .= "					if(\$infoPanel.is(':hidden')) {\n";
                $str .= "						\$infoPanel.show();\n";
                $str .= "					}\n";
                $str .= "					removeMeTr(\$('#" . $dataTabDetail[$j][0]['primaryKeyName'] . "Preview').val())";
                $str .= "				} else if (success === false) {\n";
                $str .= "					\$infoPanel\n";
                $str .= "                     	.html('').empty()\n";
                $str .= "						.html(\"<span class='label label-important'> \" + message + \"</span>\");\n";
                $str .= "					if(\$infoPanel.is(':hidden')) {\n";
                $str .= "						\$infoPanel.show();\n";
                $str .= "					}\n";
                $str .= "				}\n";
                $str .= "			},\n";
                $str .= "			error: function (xhr) {\n";
                $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
                $str .= "               \$('#infoError')\n";
                $str .= "               	.html('').empty()\n";
                $str .= "               	.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
                $str .= "				\$('#infoErrorRowFluid')\n";
                $str .= "					.removeClass().addClass('row-fluid');\n";
                $str .= "			}\n";
                $str .= "		});\n";
                $str .= "	}\n";
            }
        }


// delete grid record check box
        $str .= "	function deleteGridRecordCheckbox(leafId,url,urlList,securityToken) { \n";
        $str .= "		var stringText='';\n";
        $str .= "		var counter = 0; \n";
        $str .= "		\$('input:checkbox[name=\"" . $data[0]['primaryKeyName'] . "[]\"]').each( function() {\n";
        $str .= "			stringText=stringText+\"&" . $data[0]['primaryKeyName'] . "[]=\"+$(this).val();  \n";
        $str .= "		});\n";
        $str .= "		\$('input:checkbox[name=\"isDelete[]\"]').each( function() {\n";
        $str .= "			if(\$(this).is(':checked')) {\n";
        $str .= "				stringText=stringText+\"&isDelete[]=true\";\n";
        $str .= "			}else {\n";
        $str .= "				stringText=stringText+\"&isDelete[]=false\";\n";
        $str .= "			}\n";
        $str .= "			if(\$(this).is(':checked')) {\n";
        $str .= "				counter++;\n";
        $str .= "			}\n";
        $str .= "		});\n";
        $str .= "		if(counter === 0 ) {\n";
        $str .= "			alert(decodeURIComponent(t['deleteCheckboxTextLabel']));\n";
        $str .= "			return false;\n";
        $str .= "		} else {\n";
        $str .= "			url = url + \"?\"+stringText;\n";
        $str .= "		}\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type    :   'GET',\n";
        $str .= "			url     : 	url,\n";
        $str .= "			data    :	{\n";
        $str .= "				method          :   'updateStatus',\n";
        $str .= "				output          :   'json',\n";
        $str .= "				securityToken   :   securityToken,\n";
        $str .= "				leafId          :   leafId\n";
        $str .= "			},\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "	            var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			}, \n";
        $str .= "			success: function (data) {\n";
        $str .= "				var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				var success = data.success;\n";
        $str .= "				var message = data.message;\n";
        $str .= "				if (success === true) {\n";
        $str .= "					showGrid(leafId,urlList,securityToken,0,10,2); \n";
        $str .= "				} else if (success === false) {\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "				}else {\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "				}\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "              		.html('').empty()\n";
        $str .= "               	.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "				\$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "			}\n";
        $str .= "		});\n";
        $str .= "	}\n";


// reporting 
        $str .= "	function reportRequest(leafId,url,securityToken,mode)   {\n";
        $str .= "		\$.ajax({\n";
        $str .= "			type    :   'GET',\n";
        $str .= "			url     :   url,\n";
        $str .= "			data    :   {\n";
        $str .= "				method          :   'report',\n";
        $str .= "				mode            :   mode,\n";
        $str .= "				securityToken   :   securityToken,\n";
        $str .= "				leafId          :   leafId\n";
        $str .= "			},\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";
        $str .= "	            var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				var folder = data.folder;\n";
        $str .= "				var filename = data.filename;\n";
        $str .= "				var success = data.success;\n";
        $str .= "				var message = data.message;\n";
        $str .= "				if (success === true) {\n";
        $str .= "					var path=\"./v3/" . $data[0]['package'] . "/" . $data[0]['module'] . "/document/\"+folder+\"/\"+ filename;\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-success'>\"+decodeURIComponent(t['requestFileTextLabel'])+\"</span>\");\n";
        $str .= "					window.open(path);\n";
        $str .= "				} else {\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "					if(\$infoPanel.is(':hidden')) {\n";
        $str .= "						\$infoPanel.show();\n";
        $str .= "					}\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "				\$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "             }\n";
        $str .= "     });\n";
        $str .= " } \n";
// update record
        $str .= " function auditRecord() {\n";
        $str .= "     var css = \$('#auditRecordButton').attr('class');\n";
        $str .= "     if (css.search('disabled') > 0) {\n";
        $str .= "         return false;   \n";
        $str .= "     } else { return false;    }\n";
        $str .= " }\n";

// new record
        $str .= "	function newRecord(leafId,url,urlList,securityToken, type,createAccess,updateAccess,deleteAccess) {\n";
        $str .= "		var css = \$('#newRecordButton2').attr('class');\n";
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'isConsolidation' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != $data[0]['primaryKeyName']
            ) {
                if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
                    $str .= "		var $" . $data[$i]['columnName'] . " = \$('#" . $data[$i]['columnName'] . "').is(\":checked\")?1:0;\n";
                } else {
                    $str .= "		var $" . $data[$i]['columnName'] . " = \$('#" . $data[$i]['columnName'] . "');\n";
                }
            }
        }
		for ($j = 0; $j < $tabCounter; $j++) {
		
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
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
							$data[$i]['columnName'] != 'isReview' &&
							$data[$i]['columnName'] != 'isConsolidation' &&
							$data[$i]['columnName'] != 'companyId' &&
							$data[$i]['columnName'] != $data[0]['primaryKeyName']
					) {
						if ($dataTabDetail[$j][$i]['field'] == 'tiny' || $dataTabDetail[$j][$i]['field'] == 'bool') {
							$str .= "		var $" . $data[$i]['columnName'] . " = \$('#" . $data[$i]['columnName'] . "').is(\":checked\")?1:0;\n";
						} else {
							$str .= "		var $" . $data[$i]['columnName'] . " = \$('#" . $data[$i]['columnName'] . "');\n";
						}
					}
				}
			}
		}
        $str .= "		if (css.search('disabled') > 0) {\n";
        $str .= "			return false;\n";
        $str .= "		} else {\n";
        $str .= "			if (type === 1) {\n";
        $d = 0;
        for ($i = 0; $i < $total; $i++) {
            if ($data[$i]['columnName'] != 'executeBy' &&
                    $data[$i]['columnName'] != 'executeTime' &&
                    $data[$i]['columnName'] != 'isDefault' &&
                    $data[$i]['columnName'] != 'isApproved' &&
                    $data[$i]['columnName'] != 'isPost' &&
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
                    $data[$i]['columnName'] != 'isAdmin' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != $data[0]['primaryKeyName'] &&
                    $data[$i]['columnName'] != 'documentNumber'
            ) {
                if ($i != 0) {
                    if ($data[$i]['validate'] == 1) {
                        $str .= "			if (\$" . $data[$i]['columnName'] . ".val().length === 0) {\n";
                        $str .= "				\$('#" . $data[$i]['columnName'] . "HelpMe')\n";
                        $str .= "					.html('').empty()\n";
                        $str .= "                  	.html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+\" : \"+leafTranslation['" . $data[$i]['columnName'] . "Label']+\" </span>\");\n";

                        if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                            $str .= "			\$" . $data[$i]['columnName'] . ".data('chosen').activate_action();\n";
                        } else {

                            $str .= "			\$('#" . $data[$i]['columnName'] . "Form')\n";
                            $str .= "				.removeClass().addClass('col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group has-error');\n";
                            $str .= "			\$" . $data[$i]['columnName'] . ".focus();\n";
                        }
                        $str .= "				return false ;\n";
                        $str .= "			}\n";
                    }
                }
            }
        }
		
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($dataTabDetail[$j][$i]['validate'] == 1) {
							$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".focus();\n";

							if ($dataTabDetail[$j][$i]['foreignKey'] == 1 && $dataTabDetail[$j][$i]['Key'] == 'MUL') {
								$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".data('chosen').activate_action();\n";
							} 
							$str .= "				return false ;\n";
							$str .= "			}\n";
						}
                    }
                }
            }
        }
		
        $str .= "			\$.ajax({\n";
        $str .= "                     type	:   'POST',\n";
        $str .= "                     url	:   url,\n";
        $str .= "                     data	:   {\n";
        $str .= "                         method  :   'create',\n";
        $str .= "                         output  :   'json',\n";
        for ($i = 0; $i < $total; $i++) {
// filter non field to create a new record
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'isConsolidation' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != $data[0]['primaryKeyName']
            ) {
                if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ",\n";
                } else {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ".val(),\n";
                }
            }
        }
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
// this field is auto update by session
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName'] . " :   \$" . $dataTabDetail[$j][$i]['columnName']. ",\n";
						} else {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName']. " :   \$" . $dataTabDetail[$j][$i]['columnName'] . ".val(),\n";
						}
                    }
                }
            }
        }
        $str .= "						securityToken   :   securityToken,\n";
        $str .= "						leafId          :   leafId\n";
        $str .= "					},\n";
        $str .= "					beforeSend: function () {\n";
        $str .= "						var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "	            		var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "						\$infoPanel\n";
        $str .= "                        	.html('').empty()\n";
        $str .= "                         	.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "					},\n";
        $str .= "					success: function (data) {\n";
        $str .= "						var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "						var success = data.success;\n";
        $str .= "						var message = data.message;\n";
        $str .= "						var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
        $str .= "						if (success === true) {\n";
        $str .= "							\$infoPanel\n";
        $str .= "                            	.html('').empty()\n";
        $str .= "                            	.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['newRecordTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
        $str .= "							if(\$infoPanel.is(':hidden')) {\n";
        $str .= "								\$infoPanel.show();\n";
        $str .= "							}\n";
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != $data[0]['primaryKeyName']
            ) {
                switch ($data[$i]['field']) {
                    case 'varchar':
                    case 'text':
                    case 'string':
                        $str .= "                             \$" . $data[$i]['columnName'] . ".val('');\n";
                        break;
                    case 'tiny':
                    case 'bool':
                        $str .= "                             \$(\"#" . $data[$i]['columnName'] . "\").val('');\n";
                        break;
                    default:
                        $str .= "                             \$" . $data[$i]['columnName'] . ".val('');\n";
                }
                if ($data[$i]['Key'] == 'MUL') {
                    $str .= "                         \$" . $data[$i]['columnName'] . ".trigger(\"chosen:updated\");\n";
                }
                $str .= "                             \$('#" . $data[$i]['columnName'] . "HelpMe')\n";
                $str .= "                            	.html('').empty();\n";
            }
        }
        $str .= "                         } else if (success === false) {\n";
        $str .= "							 \$infoPanel\n";
        $str .= "								.html('').empty()\n";
        $str .= "								.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "                         }\n";
        $str .= "                      },\n";
        $str .= "             error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "				\$('#infoErrorRowFluid')\n";
        $str .= "               	.removeClass().addClass('row-fluid');\n";
        $str .= "             }\n";
        $str .= "                 });\n";
        $str .= "         } else if (type === 2) {\n";
        $str .= "             // new record and update  or delete record\n";
        $d = 0;
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'isAdmin' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != $data[0]['primaryKeyName']
            ) {
                if ($i != 0) {
                    if ($data[$i]['validate'] == 1) {
                        $str .= "             if (\$" . $data[$i]['columnName'] . ".val().length === 0) {\n";
                        $str .= "				   \$('#" . $data[$i]['columnName'] . "HelpMe')\n";
                        $str .= "				   	.html('').empty()\n";
                        $str .= "                 	.html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+\" : \"+leafTranslation['" . $data[$i]['columnName'] . "Label']+\" </span>\");\n";
                        if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                            $str .= "                 \$" . $data[$i]['columnName'] . ".data('chosen').activate_action();\n";
                        } else {

                            $str .= "                 \$('#" . $data[$i]['columnName'] . "Form')\n";
                            $str .= "						.removeClass().addClass('col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group has-error');\n";
                            $str .= "                 \$" . $data[$i]['columnName'] . ".focus();\n";
                        }
                        $str .= "                 return false ;\n";
                        $str .= "               }\n";
                    }
                }
            }
        }
		
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($dataTabDetail[$j][$i]['validate'] == 1) {
							$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".focus();\n";

							if ($dataTabDetail[$j][$i]['foreignKey'] == 1 && $dataTabDetail[$j][$i]['Key'] == 'MUL') {
								$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".data('chosen').activate_action();\n";
							} 
							$str .= "				return false ;\n";
							$str .= "			}\n";
						}
                    }
                }
            }
        }
		
        $str .= "                 \$.ajax({\n";
        $str .= "                     type    :   'POST',\n";
        $str .= "                     url     :   url,\n";
        $str .= "                     data    :   {\n";
        $str .= "                         method  :   'create',\n";
        $str .= "                         output  :   'json',\n";
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != $data[0]['primaryKeyName']
            ) {
                if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ",\n";
                } else {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ".val(),\n";
                }
            }
        }
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
// this field is auto update by session
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName'] . " :   \$" . $dataTabDetail[$j][$i]['columnName']. ",\n";
						} else {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName']. " :   \$" . $dataTabDetail[$j][$i]['columnName'] . ".val(),\n";
						}
                    }
                }
            }
        }
        $str .= "                         securityToken   :	securityToken,\n";
        $str .= "                         leafId          :	leafId\n";
        $str .= "                    },\n";
        $str .= "                    beforeSend: function () {\n";
        $str .= "                         var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "                         var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "                         \$infoPanel\n";
        $str .= "                         	.html('').empty()\n";
        $str .= "                        	.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "                    },\n";
        $str .= "                    success: function (data) {\n";
        $str .= "                         // successful request; do something with the data\n";
        $str .= "                         var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "                         var success = data.success;\n";
        $str .= "                         var smileyLol 	=	'./images/icons/smiley-lol.png';\n";
        $str .= "						var message = data.message;\n";
        $str .= "                         if (success === true) {\n";
        $str .= "                             \$infoPanel\n";
        $str .= "								.html('').empty()\n";
        $str .= "								.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['newRecordTextLabel'])+\"</span>\");\n";
        $str .= "                             \$('#" . $data[0]['primaryKeyName'] . "').val(data." . $data[0]['primaryKeyName'] . "); \n";
        $str .= "                             //\$('#documentNumber').val(data.documentNumber); \n";
// disable new record only available upon pressing reset button
//$str.="								// resetting field value\n";
// add disabled class
        $str .= "                             \$('#newRecordButton1')\n";
        $str .= "								.removeClass().addClass('btn btn-success disabled');\n";
        $str .= "                             \$('#newRecordButton2')\n";
        $str .= "								.removeClass().addClass('btn dropdown-toggle btn-success disabled');\n";
        $str .= "                             \$('#newRecordButton3').attr('onClick', ''); \n";
        $str .= "                             \$('#newRecordButton4').attr('onClick', ''); \n";
        $str .= "                             \$('#newRecordButton5').attr('onClick', ''); \n";
        $str .= "                             \$('#newRecordButton6').attr('onClick', ''); \n";
        $str .= "                             \$('#newRecordButton7').attr('onClick', ''); \n";
// add disabled class
// check if authorized or not.hackable here . but back end will check again.
        $str .= "                             if(updateAccess === 1) {\n";
        $str .= "                             	\$('#updateRecordButton1')\n";
        $str .= "									.removeClass().addClass('btn btn-info'); \n";
        $str .= "                             	\$('#updateRecordButton2')\n";
        $str .= "									.removeClass().addClass('btn dropdown-toggle btn-info');\n";
        $str .= "                             	\$('#updateRecordButton3').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1)\"); \n";
        $str .= "                             	\$('#updateRecordButton4').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',2)\"); \n";
        $str .= "                             	\$('#updateRecordButton5').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',3)\"); \n";
        $str .= "                             } else {\n";
        $str .= "                             	\$('#updateRecordButton1')\n";
        $str .= "									.removeClass().addClass('btn btn-info disabled'); \n";
// toggle button
        $str .= "                             	\$('#updateRecordButton2')\n";
        $str .= "									.removeClass().addClass('btn dropdown-toggle btn-info disabled'); \n";
        $str .= "                             	\$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "                             	\$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "                             	\$('#updateRecordButton5').attr('onClick', ''); \n";
        $str .= "                             }\n";
        $str .= "                             if(deleteAccess===1) {\n";
        $str .= "                             	\$('#deleteRecordButton')\n";
        $str .= "                             		.removeClass().addClass('btn btn-danger')\n";
        $str .= "                             		.attr('onClick', \"deleteRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"')\"); \n";
        $str .= "                             } else {\n";
        $str .= "                             	\$('#deleteRecordButton')\n";
        $str .= "                             		.removeClass().addClass('btn btn-danger')\n";
        $str .= "                             		.attr('onClick',''); \n";
        $str .= "                             }\n";
// end button segment

        $str .= "                         } else if (success === false) {\n";
        $str .= "							 \$infoPanel\n";
        $str .= "								.html('').empty()\n";
        $str .= "								.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "                         }\n";
        $str .= "                     },\n";
        $str .= "             error: function (xhr) {\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               \$('#infoError')\n";
        $str .= " 					.html('').empty()\n";
        $str .= "					.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "               \$('#infoErrorRowFluid')\n";
        $str .= "					.removeClass().addClass('row-fluid');\n";
        $str .= "             }\n";
        $str .= "                 });\n";
        $str .= "         } else if (type === 5) {\n";
        $d = 0;
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'isAdmin' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != $data[0]['primaryKeyName']
            ) {
                if ($i != 0) {
                    if ($data[$i]['validate'] == 1) {
                        $str .= "               if (\$" . $data[$i]['columnName'] . ".val().length === 0) {\n";
                        $str .= "				   \$('#" . $data[$i]['columnName'] . "HelpMe')\n";
                        $str .= "				   	.html('').empty()\n";
                        $str .= "					.html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+\" : \"+leafTranslation['" . $data[$i]['columnName'] . "Label']+\" </span>\");\n";
                        if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                            $str .= "                 \$" . $data[$i]['columnName'] . ".data('chosen').activate_action();\n";
                        } else {

                            $str .= "                 \$('#" . $data[$i]['columnName'] . "Form')\n";
                            $str .= "					.removeClass().addClass('col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group has-error');\n";
                            $str .= "				  \$" . $data[$i]['columnName'] . ".focus();\n";
                        }
                        $str .= "                 return false ;\n";
                        $str .= "               }\n";
                    }
                }
            }
        }
		
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($dataTabDetail[$j][$i]['validate'] == 1) {
							$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".focus();\n";

							if ($dataTabDetail[$j][$i]['foreignKey'] == 1 && $dataTabDetail[$j][$i]['Key'] == 'MUL') {
								$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".data('chosen').activate_action();\n";
							} 
							$str .= "				return false ;\n";
							$str .= "			}\n";
						}
                    }
                }
            }
        }
		
        $str .= "                 \$.ajax({\n";
        $str .= "                     type    :	'POST',\n";
        $str .= "                     url     : 	url,\n";
        $str .= "                     data    :   {\n";
        $str .= "                         method  :	'create',\n";
        $str .= "                         output  :   'json',\n";
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != $data[0]['primaryKeyName']
            ) {
                if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ",\n";
                } else {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ".val(),\n";
                }
            }
        }
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
// this field is auto update by session
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName'] . " :   \$" . $dataTabDetail[$j][$i]['columnName']. ",\n";
						} else {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName']. " :   \$" . $dataTabDetail[$j][$i]['columnName'] . ".val(),\n";
						}
                    }
                }
            }
        }
        $str .= "                         securityToken   :   securityToken,\n";
        $str .= "                         leafId          :   leafId\n";
        $str .= "                     },\n";
        $str .= "                     beforeSend: function () {\n";
        $str .= "                         var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "                         var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "                         \$infoPanel\n";
        $str .= "							.html('').empty()\n";
        $str .= "                         	.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "                         if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "                         }\n";
        $str .= "                     },\n";
        $str .= "                     success: function (data) {\n";
        $str .= "                         var success = data.success;\n";
        $str .= "                         var message = data.message;\n";
        $str .= "                         var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "                         var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "                         if (success === true) {\n";
        $str .= "                             showGrid(leafId,urlList, securityToken,0,10,1);\n";
        $str .= "                         } else {\n";
        $str .= "                             \$infoPanel\n";
        $str .= "                             	.html('').empty()\n";
        $str .= "                             	.html(\"<span class='label label-important'> <img src='\"+smileyRollSweat+\"'> \"+message+\"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "                          }\n";
        $str .= "                     },\n";
        $str .= "                     error: function (xhr) {\n";
        $str .= "                         var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "                         \$('#infoError')\n";
        $str .= "                             .html('').empty()\n";
        $str .= "                             .html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "                         \$('#infoErrorRowFluid')\n";
        $str .= "                             .removeClass().addClass('row-fluid');\n";
        $str .= "                         }\n";
        $str .= "                     });\n";
        $str .= "             }\n";
        $str .= "             showMeDiv('tableDate', 0);\n";
        $str .= "             showMeDiv('formEntry', 1);\n";
        $str .= "     }\n";
        $str .= " }\n";

//update record
        $str .= "	function updateRecord(leafId,url,urlList, securityToken, type,deleteAccess) {\n";
        $str .= "		var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "		var css = \$('#updateRecordButton2').attr('class');\n";
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'isConsolidation' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {
                if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
                    $str .= "		var $" . $data[$i]['columnName'] . " = \$('#" . $data[$i]['columnName'] . "').is(\":checked\")?1:0;\n";
                } else {
                    $str .= "		var $" . $data[$i]['columnName'] . " = \$('#" . $data[$i]['columnName'] . "');\n";
                }
            }
        }
        $str .= "		if (css.search('disabled') > 0) {\n";
        $str .= "         return false;\n";
        $str .= "		} else {\n";
        $str .= "			\$infoPanel\n";
        $str .= "				.empty().html('');\n";
        $str .= "			if (type === 1) {\n";
        $d = 0;
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'isAdmin' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isConsolidation'
            ) {
                if ($i != 0) {
                    if ($data[$i]['validate'] == 1) {
                        $str .= "			if (\$" . $data[$i]['columnName'] . ".val().length === 0) {\n";
                        $str .= "				\$('#" . $data[$i]['columnName'] . "HelpMe')\n";
                        $str .= "					.html('').empty()\n";
                        $str .= "                 	.html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+\" : \"+leafTranslation['" . $data[$i]['columnName'] . "Label']+\" </span>\");\n";
                        if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                            $str .= "				\$" . $data[$i]['columnName'] . ".data('chosen').activate_action();\n";
                        } else {

                            $str .= "				\$('#" . $data[$i]['columnName'] . "Form')\n";
                            $str .= "					.removeClass().addClass('col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group has-error');\n";
                            $str .= "				\$" . $data[$i]['columnName'] . ".focus();\n";
                        }
                        $str .= "				return false ;\n";
                        $str .= "			}\n";
                    }
                }
            }
        }
		
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($dataTabDetail[$j][$i]['validate'] == 1) {
							$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".focus();\n";

							if ($dataTabDetail[$j][$i]['foreignKey'] == 1 && $dataTabDetail[$j][$i]['Key'] == 'MUL') {
								$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".data('chosen').activate_action();\n";
							} 
							$str .= "				return false ;\n";
							$str .= "			}\n";
						}
                    }
                }
            }
        }
		
        $str .= "			\$infoPanel\n";
        $str .= "				.html('').empty();\n";
        $str .= "			\$.ajax({\n";
        $str .= "				type	:   'POST',\n";
        $str .= "				url		:   url,\n";
        $str .= "				data	:   {\n";
        $str .= "					method  :   'save',\n";
        $str .= "					output 	:	'json',\n";
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isConsolidation'
            ) {
                if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ",\n";
                } else {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ".val(),\n";
                }
            }
        }
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
// this field is auto update by session
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName'] . " :   \$" . $dataTabDetail[$j][$i]['columnName']. ",\n";
						} else {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName']. " :   \$" . $dataTabDetail[$j][$i]['columnName'] . ".val(),\n";
						}
                    }
                }
            }
        }
        $str .= "					securityToken   :   securityToken,\n";
        $str .= "					leafId          :   leafId\n";
        $str .= "				},\n";
        $str .= "				beforeSend: function () {\n";
        $str .= "					var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "					var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "					if(\$infoPanel.is(':hidden')) {\n";
        $str .= "						\$infoPanel.show();\n";
        $str .= "					}\n";
        $str .= "				},\n";
        $str .= "				success: function (data) {\n";
        $str .= "					var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "					var success		= 	data.success;\n";
        $str .= "					var message		= 	data.message;\n";
        $str .= "					var smileyLol	=	'./images/icons/smiley-lol.png';\n";
        $str .= "					if (success === true) {\n";
        $str .= "						\$infoPanel\n";
        $str .= "							.html('').empty()\n";
        $str .= "							.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['updateRecordTextLabel'])+\"</span>\");\n";

        $str .= "						if(deleteAccess===1) {\n";
        $str .= "							\$('#deleteRecordButton')\n";
        $str .= "								.removeClass().addClass('btn btn-danger')\n";
        $str .= "								.attr('onClick', \"deleteRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+deleteAccess+\")\"); \n";
        $str .= "						} else {\n";
        $str .= "							\$('#deleteRecordButton')\n";
        $str .= "								.removeClass().addClass('btn btn-danger')\n";
        $str .= "								.attr('onClick',''); \n";
        $str .= "						}\n";
        $str .= "					} else if (success === false) {\n";
        $str .= "						\$infoPanel.empty().html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "					}\n";
        $str .= "				},\n";
        $str .= "				error: function (xhr) {\n";
        $str .= "					var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "					\$('#infoError')\n";
        $str .= "							.html('').empty()\n";
        $str .= "							.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "					\$('#infoErrorRowFluid')\n";
        $str .= "							.removeClass().addClass('row-fluid');\n";
        $str .= "				}\n";
        $str .= "			});\n";
        $str .= "         } else if (type === 3) {\n";
        $str .= "             // update record and listing\n";
        $d = 0;
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
                    $data[$i]['columnName'] != 'isAdmin' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isConsolidation'
            ) {
                if ($i != 0) {
                    if ($data[$i]['validate'] == 1) {
                        $str .= "               if (\$" . $data[$i]['columnName'] . ".val().length === 0) {\n";
                        $str .= "				   \$('#" . $data[$i]['columnName'] . "HelpMe')\n";
                        $str .= "				   	.html('').empty()\n";
                        $str .= "                 	.html(\"<span class='label label-important'>&nbsp;\"+decodeURIComponent(t['requiredTextLabel'])+\" : \"+leafTranslation['" . $data[$i]['columnName'] . "Label']+\" </span>\");\n";
                        if ($data[$i]['foreignKey'] == 1 && $data[$i]['Key'] == 'MUL') {
                            $str .= "                 \$" . $data[$i]['columnName'] . ".data('chosen').activate_action();\n";
                        } else {

                            $str .= "                 \$('#" . $data[$i]['columnName'] . "Form').removeClass().addClass('col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group has-error');\n";
                            $str .= "                 \$" . $data[$i]['columnName'] . ".focus();\n";
                        }
                        $str .= "                 return false ;\n";
                        $str .= "               }\n";
                    }
                }
            }
        }
		
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($dataTabDetail[$j][$i]['validate'] == 1) {
							$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".focus();\n";

							if ($dataTabDetail[$j][$i]['foreignKey'] == 1 && $dataTabDetail[$j][$i]['Key'] == 'MUL') {
								$str .= "			\$" . $dataTabDetail[$j][$i]['columnName'] . ".data('chosen').activate_action();\n";
							} 
							$str .= "				return false ;\n";
							$str .= "			}\n";
						}
                    }
                }
            }
        }
		
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "                 \$.ajax({\n";
        $str .= "                     type    :   'POST',\n";
        $str .= "                     url     :   url,\n";
        $str .= "                     data    :   {\n";
        $str .= "                         method  :   'save',\n";
        $str .= "                         output  :   'json',\n";
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
            if ($data[$i]['columnName'] != 'executeBy' &&
                    $data[$i]['columnName'] != 'executeTime' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isDefault' &&
                    $data[$i]['columnName'] != 'isApproved' &&
                    $data[$i]['columnName'] != 'isPost' &&
                    $data[$i]['columnName'] != 'isNew' &&
                    $data[$i]['columnName'] != 'isDraft' &&
                    $data[$i]['columnName'] != 'isUpdate' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isActive' &&
                    $data[$i]['columnName'] != 'isSlice' &&
                    $data[$i]['columnName'] != 'isSingle' &&
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isConsolidation'
            ) {
                if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ",\n";
                } else {
                    $str .= "                         " . $data[$i]['columnName'] . " :   \$" . $data[$i]['columnName'] . ".val(),\n";
                }
            }
        }
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < count($total); $i++) {
// this field is auto update by session
                    if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSlice' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isSingle' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isReview' &&
                            $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                            $dataTabDetail[$j][$i]['columnName'] != $data[0]['primaryKeyName'] &&
                            $dataTabDetail[$j][$i]['columnName'] != 'isConsolidation'
                    ) {
                        if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName'] . " :   \$" . $dataTabDetail[$j][$i]['columnName']. ",\n";
						} else {
							$str .= "                         " . $dataTabDetail[$j][$i]['columnName']. " :   \$" . $dataTabDetail[$j][$i]['columnName'] . ".val(),\n";
						}
                    }
                }
            }
        }
        $str .= "                         securityToken   :   securityToken,\n";
        $str .= "                         leafId          :   leafId\n";
        $str .= "					},\n";
        $str .= "					beforeSend: function () {\n";
        $str .= "						var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "						var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "						\$infoPanel\n";
        $str .= "                         	.html('').empty()\n";
        $str .= "                         	.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "					},\n";
        $str .= "					success: function (data) {\n";
        $str .= "						var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "						var success		= 	data.success;\n";
        $str .= "						var message		=	data.message;\n";
        $str .= "						var smileyLol	=	'./images/icons/smiley-lol.png';\n";
        $str .= "						if (success === true) {\n";
        $str .= "							\$infoPanel.html(\"<span class='label label-success'>&nbsp;<img src='\"+smileyLol+\"'> \"+decodeURIComponent(t['loadingCompleteTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
        $str .= "							showGrid(leafId,urlList, securityToken,0,10,1);\n";
        $str .= "						} else if (success === false) {\n";
        $str .= "							\$infoPanel\n";
        $str .= "								.html('').empty()\n";
        $str .= " 								.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "						}\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "					},\n";
        $str .= "					error: function (xhr) {\n";
        $str .= "						var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "						\$('#infoError')\n";
        $str .= "							.html('').empty().html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "						\$('#infoErrorRowFluid')\n";
        $str .= "							.removeClass().addClass('row-fluid');\n";
        $str .= "					}\n";
        $str .= "				});\n";
        $str .= "			}\n";
        $str .= "		}\n";
        $str .= "	}\n";

//delete record
        $str .= "	function deleteRecord(leafId,url,urlList,securityToken,deleteAccess) {\n";
        $str .= "		var \$infoPanel			=	\$('#infoPanel');\n";
        $str .= "		var \$" . $data[0]['primaryKeyName'] . " = \$('#" . $data[0]['primaryKeyName'] . "');\n";
        $str .= "		var css = \$('#deleteRecordButton').attr('class');\n";
        $str .= "		if (css.search('disabled') > 0) {\n";
        $str .= "			return false; \n";
        $str .= "		} else {\n";
        $str .= "			if(deleteAccess === 1 ) {\n";
        $str .= "				if(confirm(decodeURIComponent(t['deleteRecordMessageLabel']))) { \n";
        $str .= "					var value=\$" . $data[0]['primaryKeyName'] . ".val(); \n";
        $str .= "					if(!value) {\n";
        $str .= "						\$infoPanel\n";
        $str .= "							.html('').empty()\n";
        $str .= "							.html(\"<span class='label label-important'> \"+decodeURIComponent(t['loadingErrorTextLabel'])+\"<span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "                       return false ;\n";
        $str .= "					} else { \n";
        $str .= "						\$.ajax({\n";
        $str .= "							type            :	'POST',\n";
        $str .= "							url             : 	url,\n";
        $str .= "							data            : 	{\n";
        $str .= "								method          :	'delete',\n";
        $str .= "								output          :	'json',\n";
        $str .= "								" . $data[0]['primaryKeyName'] . "	: 	\$" . $data[0]['primaryKeyName'] . ".val(),\n";
        $str .= "								securityToken   :   securityToken,\n";
        $str .= "								leafId          :   leafId\n";
        $str .= "							},\n";
        $str .= "							beforeSend: function () {\n";
        $str .= "								var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "								var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "								\$infoPanel\n";
        $str .= "									.html('').empty()\n";
        $str .= "									.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "								if(\$infoPanel.is(':hidden')) {\n";
        $str .= "									\$infoPanel.show();\n";
        $str .= "								}\n";
        $str .= "							},\n";
        $str .= "							success: function (data) {\n";
        $str .= "								var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "								var success = data.success;\n";
        $str .= "								var message = data.message;\n";
        $str .= "								if (success === true) {\n";
        $str .= "									showGrid(leafId,urlList,securityToken,0,10,2); \n";
        $str .= "								} else if (success === false) {\n";
        $str .= "									\$infoPanel\n";
        $str .= "										.html('').empty()\n";
        $str .= "										.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "										if(\$infoPanel.is(':hidden')) {\n";
        $str .= "											\$infoPanel.show();\n";
        $str .= "										}\n";
        $str .= "								}\n";
        $str .= "							},\n";
        $str .= "							error: function (xhr) {\n";
        $str .= "								var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "								\$('#infoError')\n";
        $str .= "									.html('').empty()\n";
        $str .= "									.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "								\$('#infoErrorRowFluid')\n";
        $str .= "									.removeClass().addClass('row-fluid');\n";
        $str .= "							}\n";
        $str .= "						});\n";
        $str .= "					}\n";
        $str .= "				} else { \n";
        $str .= "					return false; \n";
        $str .= "			 	} \n";
        $str .= "         	}\n";
        $str .= "		}\n";
        $str .= "	}\n";

//reset record
        $str .= " 	function resetRecord(leafId,url,urlList,securityToken,createAccess,updateAccess,deleteAccess) {\n";
        $str .= "		var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "       var resetIcon = './images/icons/fruit-orange.png';\n";
        $str .= "		\$infoPanel\n";
        $str .= "			.html('').empty()\n";
        $str .= "    		.html(\"<span class='label label-important'><img src='\"+resetIcon+\"'> \"+decodeURIComponent(t['resetRecordTextLabel'])+\"</span>\").delay(1000).fadeOut();\n";
        $str .= "		if(\$infoPanel.is(':hidden')) {\n";
        $str .= "			\$infoPanel.show();\n";
        $str .= "		}\n";

// empty the  onClick field.
        $str .= "		if(createAccess===1) {\n";

        $str .= "			\$('#newRecordButton1')\n";
        $str .= "				.removeClass().addClass('btn btn-success')\n";
        $str .= "				.attr('onClick', '').attr(\"onClick\", \"newRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1)\");\n";
        $str .= "			\$('#newRecordButton2')\n";
        $str .= "				.attr('onClick', '')\n";
        $str .= "				.removeClass().addClass('btn dropdown-toggle btn-success');\n";
        $str .= "			\$('#newRecordButton3').attr(\"onClick\", \"newRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1)\"); \n";
        $str .= "			\$('#newRecordButton4').attr(\"onClick\", \"newRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',2)\"); \n";
        $str .= "			\$('#newRecordButton5').attr(\"onClick\", \"newRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',3)\"); \n";
        $str .= "			\$('#newRecordButton6').attr(\"onClick\", \"newRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',4)\"); \n";
        $str .= "			\$('#newRecordButton7').attr(\"onClick\",\"newRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',5)\"); \n";
        $str .= "		}else {\n ";
// disabled button if don't have access
// add disabled class
        $str .= "			\$('#newRecordButton1')\n";
        $str .= "				.removeClass().addClass('btn btn-success disabled').attr('onClick',''); \n";
        $str .= "			\$('#newRecordButton2')\n";
        $str .= "				.removeClass().addClass('btn dropdown-toggle btn-success disabled'); \n";
        $str .= "			\$('#newRecordButton3').attr('onClick','');\n";
        $str .= "			\$('#newRecordButton4').attr('onClick',''); \n";
        $str .= "			\$('#newRecordButton5').attr('onClick',''); \n";
        $str .= "			\$('#newRecordButton6').attr('onClick',''); \n";
        $str .= "			\$('#newRecordButton7').attr('onClick',''); \n";

        $str .= "     }";
// end new button segment
// update button segment
// add disabled class
        $str .= "		\$('#updateRecordButton1')\n";
        $str .= "			.removeClass().addClass('btn btn-info disabled')\n";
        $str .= "			.attr('onClick', '');\n";
// toggle button
        $str .= "		\$('#updateRecordButton2')\n";
        $str .= "			.removeClass().addClass('btn dropdown-toggle btn-info disabled')\n";
        $str .= "			.attr('onClick', '');\n";

        $str .= "		\$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "		\$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "		\$('#updateRecordButton5').attr('onClick', ''); \n";


// delete button segment
        $str .= "		\$('#deleteRecordButton')\n";
        $str .= "			.removeClass().addClass('btn btn-danger disabled')\n";
        $str .= "			.attr('onClick',''); \n";
// end delete button segment
// post button segment
        $str .= "		\$('#postRecordButton')\n";
        $str .= "			.removeClass().addClass('btn btn-info')\n";
        $str .= "			.attr('onClick',''); \n";
// end post button segment
// end button segment
// navigation segment
// disable move next
        $str .= "		\$('#firstRecordButton')\n";
        $str .= "			.removeClass().addClass('btn btn-default')\n";
        $str .= "			.attr('onClick', \"firstRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"',";
        if (count($dataDetail) > 0) {
            $str .= "'\"+url" . ucfirst($dataDetail[0]['tableName']) . "+\"',";
        }
        $str .= "'\"+securityToken+\"',\"+updateAccess+\",\"+deleteAccess+\")\"); \n";
// disable move previous
        $str .= "		\$('#previousRecordButton')\n";
        $str .= "			.removeClass().addClass('btn btn-default disabled')\n";
        $str .= "			.attr('onClick','');\n";
// disable the next record
        $str .= "		\$('#nextRecordButton')\n";
        $str .= "			.removeClass().addClass('btn btn-default disabled')\n";
        $str .= "			.attr('onClick','');\n";
// enable the last record
        $str .= "		\$('#endRecordButton')\n";
        $str .= "			.removeClass().addClass('btn btn-default')\n";
        $str .= "			.attr('onClick',\"endRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"',";
        if (count($dataDetail) > 0) {
            $str .= "'\"+url" . ucfirst($dataDetail[0]['tableName']) . "+\"',";
        }
        $str .= "'\"+securityToken+\"',\"+updateAccess+\")\"); \n";
// end navigation segment
// upon render remove all css foreign key master and detail
// remove master foreign key css 
        for ($i = 0; $i < $total; $i++) {

            if ($data[$i]['columnName'] != 'executeBy' &&
                    $data[$i]['columnName'] != 'executeTime' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isDefault' &&
                    $data[$i]['columnName'] != 'isApproved' &&
                    $data[$i]['columnName'] != 'isPost' &&
                    $data[$i]['columnName'] != 'isNew' &&
                    $data[$i]['columnName'] != 'isDraft' &&
                    $data[$i]['columnName'] != 'isUpdate' &&
                    $data[$i]['columnName'] != 'isDelete' &&
                    $data[$i]['columnName'] != 'isActive' &&
                    $data[$i]['columnName'] != 'isSlice' &&
                    $data[$i]['columnName'] != 'isSingle' &&
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId' &&
                    $data[$i]['columnName'] != 'isConsolidation'
            ) {


                $str .= "		\$(\"#" . $data[$i]['columnName'] . "\").val('');\n";
                $str .= "		\$(\"#" . $data[$i]['columnName'] . "HelpMe\")\n";
                $str .= "			.empty().html('');\n";
                if ($data[$i]['field'] == 'tiny' || $data[$i]['field'] == 'bool') {
                    $str .= "		\$(\"#" . $data[$i]['columnName'] . "\").removeAttr(\"checked\");\n";
                    $str .= "		\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state', false);\n";
                }
            }
            if ($data[$i]['Key'] == 'MUL') {
                if ($data[$i]['columnName'] != 'companyId') {
                    $str .= "			\$('#" . $data[$i]['columnName'] . "').trigger(\"chosen:updated\");\n";
                }
            }
        }
        for ($i = 0; $i < count($dataDetail); $i++) {
            // remove the detail grid css
            if ($dataTabDetail[$j][$i]['columnName'] != 'executeBy' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'companyId' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'executeTime' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isDefault' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isApproved' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isPost' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isNew' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isDraft' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isUpdate' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isDelete' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isActive' &&
                    $dataTabDetail[$j][$i]['columnName'] != 'isReview'
            ) {

                $str .= "		\$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "9999\")\n";
                $str .= "			.prop(\"disabled\",\"true\")\n";
                $str .= "			.attr(\"disabled\",\"disabled\")\n";
                $str .= "			.val('')\n";
                if ($dataTabDetail[$j][$i]['Key'] == 'MUL' && $dataTabDetail[$j][$i]['Key'] != 'PRI') {
                    $str .= "			.trigger(\"chosen:updated\")";
                }
                $str .= ";\n";
            }
        }

        $str .= " }\n";

//post record
        $str .= " function postRecord() {\n";
        $str .= "     var css = \$('#postRecordButton').attr('class');\n";
        $str .= "     if (css.search('disabled') > 0) {\n";
        $str .= "         return false;  \n";
        $str .= "     } else {\n";
        $str .= "         return false;  \n";
        $str .= "     }\n";

        $str .= " }\n";

// first record
        $str .= "	function firstRecord(leafId,url,urlList,securityToken,updateAccess,deleteAccess) {\n";
        $str .= "	var css = \$('#firstRecordButton').attr('class');\n";

        $str .= "	if (css.search('disabled') > 0) {\n";
        $str .= "		return false;  \n";
        $str .= "	} else {\n";

        $str .= "		\$.ajax({\n";
        $str .= "			type    :   'GET',\n";
        $str .= "			url     :   url,\n";
        $str .= "			data    :   {\n";
        $str .= "				method			:   'dataNavigationRequest',\n";
        $str .= "				dataNavigation	:   'firstRecord',\n";
        $str .= "					output			:   'json',\n";
        $str .= "					securityToken	:   securityToken,\n";
        $str .= "					leafId          :   leafId\n";
        $str .= "			},\n";
        $str .= "			beforeSend: function () {\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			},\n";
        $str .= "			success: function (data) {\n";
        $str .= "				var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "				var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "				var success = data.success;\n";
        $str .= "				var firstRecord 	= 	data.firstRecord;\n";
        $str .= "				var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "				if(firstRecord === 0 ) {\n";
        $str .= "					\$infoPanel.html('').empty().html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['recordNotFoundLabel'])+\"</span>\");\n";
        $str .= "					return false;\n";
        $str .= "				}\n";
        $str .= "				if (success === true) {\n";
        $str .= "					\$.ajax({\n";
        $str .= "						type	: 	'POST',\n";
        $str .= "						url		: 	url,\n";
        $str .= "						data	:	{\n";
        $str .= "							method  			:   'read',\n";
        $str .= "							" . $data[0]['primaryKeyName'] . "	:   firstRecord,\n";
        $str .= "							output          	:   'json',\n";
        $str .= "							securityToken   	:   securityToken,\n";
        $str .= "							leafId          	:   leafId\n";
        $str .= "						},\n";
        $str .= "						beforeSend: function () {\n";
        $str .= "							var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "							\$infoPanel\n";
        $str .= "								.html('').empty()\n";
        $str .= "								.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "							if(\$infoPanel.is(':hidden')) {\n";
        $str .= "								\$infoPanel.show();\n";
        $str .= "							}\n";
        $str .= "						},\n";
        $str .= "						success: function (data) {\n";
        $str .= "							var x,output;\n";
        $str .= "							var success			=	data.success;\n";
        $str .= "							var \$infoPanel		=	\$('#infoPanel');\n";
        $str .= "							var lastRecord 		= 	data.lastRecord;\n";
        $str .= "							var nextRecord 		= 	data.nextRecord;\n";
        $str .= "							var previousRecord	=	data.previousRecord;\n";
        $str .= "							if (success === true) {\n";

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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {
                switch ($data[$i]['field']) {
                    case 'varchar':
                    case 'text':
                    case 'string':
                        //    if (intval(str_replace(array("varchar", "(", ")"), "", $data[$i]['Type'])) == '512') {
                        //        $str .= "								\$('#" . $data[$i]['columnName'] . "').data(\"wysihtml5\").editor.setValue(data.data." . $data[$i]['columnName'] . ")";
                        //     } else {
                        $str .= "								\$('#" . $data[$i]['columnName'] . "').val(data.data." . $data[$i]['columnName'] . ")";
                        //     }
                        break;
                    case 'date':
                        $str .= "                                     x = data.data." . $data[$i]['columnName'] . ";\n";
                        $str .= "                                     x = x.split(\"-\");\n";
                        $str .= "									  output = 	x[2]+\"-\"+x[1]+\"-\"+x[0];\n";
                        $str .= "                                     output  = output.toString();\n";
                        $str .= "                                     \$('#" . $data[$i]['columnName'] . "').val(output)";
                        break;
                    case 'datetime':
                        $str .= "                                     x = data.data." . $data[$i]['columnName'] . ";\n";
                        $str .= "									  x = x.split(\" \");\n";
                        $str .= "									  var d  = x[0].split(\"-\");\n";
                        $str .= "									  output = 	y[2]+\"-\"+y[1]+\"-\"+y[0]+\" \"+x[1];\n";
                        $str .= "                                     output  = output.toString();\n";
                        $str .= "                                     \$('#" . $data[$i]['columnName'] . "').val()";
                        break;
                    case 'bool':
                    case 'tiny':
                        $str .= "                                     if(data.data." . $data[$i]['columnName'] . " == true || data.data." . $data[$i]['columnName'] . " ==1) { \n";
                        $str .= "                                     	\$(\"#" . $data[$i]['columnName'] . "\").attr(\"checked\",\"checked\");\n";
                        $str .= "                                     	\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state',true);\n";
                        $str .= "                                     } else { \n";
                        $str .= "                                     \$(\"#" . $data[$i]['columnName'] . "\").removeAttr(\"checked\");\n";
                        $str .= "                                     \$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state', false);\n";
                        $str .= "                                     }\n";
                        $str .= "                                     \$(\"#" . $data[$i]['columnName'] . "\").val(data.data." . $data[$i]['columnName'] . ");\n";

                        break;
                    default:
                        $str .= "                                     \$('#" . $data[$i]['columnName'] . "').val(data.data." . $data[$i]['columnName'] . ")";
                }
                if ($data[$i]['Key'] == 'MUL') {
                    $str .= ".trigger(\"chosen:updated\")";
                }
                $str.=";\n";
            }
        }

        for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < $total; $i++) {
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {
				for($l =0;$l<$data[0]['targetMaximumTabRecord'];$l++) { 
					switch ($data[$i]['field']) {
						case 'varchar':
						case 'text':
						case 'string':

							$str .= "								\$('#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."').val(data.data." . $dataTabDetail[$j][$i]['columnName'] . "_".$l.")";
							//     }
							break;
						case 'date':
							$str .= "                                     x = data.data." . $dataTabDetail[$j][$i]['columnName'] . ";\n";
							$str .= "                                     x = x.split(\"-\");\n";
							$str .= "									  output = 	x[2]+\"-\"+x[1]+\"-\"+x[0];\n";
							$str .= "                                     output  = output.toString();\n";
							$str .= "                                     \$('#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."').val(output)";
							break;
						case 'datetime':
							$str .= "                                     x = data.data." . $data[$i]['columnName'] . "_".$l.";\n";
							$str .= "									  x = x.split(\" \");\n";
							$str .= "									  var d  = x[0].split(\"-\");\n";
							$str .= "									  output = 	y[2]+\"-\"+y[1]+\"-\"+y[0]+\" \"+x[1];\n";
							$str .= "                                     output  = output.toString();\n";
							$str .= "                                     \$('#" .$dataTabDetail[$j][$i]['columnName']. "_".$l."').val()";
							break;
						case 'bool':
						case 'tiny':
							$str .= "                                     if(data.data." . $dataTabDetail[$j][$i]['columnName'] . " == true || data.data." . $dataTabDetail[$j][$i]['columnName']. "_".$l."==1) { \n";
							$str .= "                                     	\$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\").attr(\"checked\",\"checked\");\n";
							$str .= "                                     	\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state',true);\n";
							$str .= "                                     } else { \n";
							$str .= "                                     \$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\").removeAttr(\"checked\");\n";
							$str .= "                                     \$('input[name=\"" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."\"]').bootstrapSwitch('state', false);\n";
							$str .= "                                     }\n";
							$str .= "                                     \$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."\").val(data.data." . $data[$i]['columnName']. "_".$l.");\n";

							break;
						default:
							$str .= "                                     \$('#" . $dataTabDetail[$j][$i]['columnName']. "_".$l."').val(data.data." . $dataTabDetail[$j][$i]['columnName']. "_".$l.")";
						}
						if ($data[$i]['Key'] == 'MUL') {
							$str .= ".trigger(\"chosen:updated\")";
						}
						$str.=";\n";
					}
				}
			}
				}
			}
		}

        $str .= "									if (nextRecord > 0) {\n";
        $str .= "										\$('#previousRecordButton')\n";
        $str .= "											.removeClass().addClass('btn btn-default disabled')\n";
        $str .= "											.attr('onClick','');\n";
        $str .= "										\$('#nextRecordButton')\n";
        $str .= "											.removeClass().addClass('btn btn-default')\n";
        $str .= "											.attr('onClick','')\n";
		$str .= "											.attr('onClick', \"nextRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+updateAccess+\",\"+deleteAccess+\")\"); \n";
        $str .= "										\$('#firstRecordCounter').val(firstRecord);\n";
        $str .= "										\$('#previousRecordCounter').val(previousRecord);\n";
        $str .= "										\$('#nextRecordCounter').val(nextRecord);\n";
        $str .= "										\$('#lastRecordCounter').val(lastRecord);\n";
        $str .= "										\$('#newRecordButton1')\n";
        $str .= "											.removeClass().addClass('btn btn-success disabled').attr('onClick', ''); \n";
        $str .= "										\$('#newRecordButton2')\n";
        $str .= "											.removeClass().addClass('btn dropdown-toggle btn-success disabled'); \n";
        $str .= "										\$('#newRecordButton3').attr('onClick', ''); \n";
        $str .= "										\$('#newRecordButton4').attr('onClick', ''); \n";
        $str .= "										\$('#newRecordButton5').attr('onClick', ''); \n";
        $str .= "										\$('#newRecordButton6').attr('onClick', ''); \n";
        $str .= "										\$('#newRecordButton7').attr('onClick', ''); \n";
        $str .= "										if(updateAccess === 1) {\n";
        $str .= "											\$('#updateRecordButton1')\n";
        $str .= "												.removeClass().addClass('btn btn-info').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1,\"+deleteAccess+\")\"); \n";
        $str .= "											\$('#updateRecordButton2')\n";
        $str .= "												.removeClass().addClass('btn dropdown-toggle btn-info'); \n";
        $str .= "											\$('#updateRecordButton3').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1,\"+deleteAccess+\")\");\n";
        $str .= "											\$('#updateRecordButton4').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',2,\"+deleteAccess+\")\");\n";
        $str .= "											\$('#updateRecordButton5').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',3,\"+deleteAccess+\")\");\n";
        $str .= "										} else {\n";
        $str .= "											\$('#updateRecordButton1')\n";
        $str .= "												.removeClass().addClass('btn btn-info disabled').attr('onClick', '');\n";
        $str .= "											\$('#updateRecordButton2')\n";
        $str .= "												.removeClass().addClass('btn dropdown-toggle btn-info disabled');\n";
        $str .= "											\$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "											\$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "											\$('#updateRecordButton5').attr('onClick', ''); \n";
        $str .= "										}\n";
        $str .= "										if(deleteAccess===1) {\n";
        $str .= "											\$('#deleteRecordButton')\n";
        $str .= "                                             	.removeClass().addClass('btn btn-danger')\n";
        $str .= "                                             	.attr('onClick','').attr('onClick', \"deleteRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+deleteAccess+\")\"); \n";
        $str .= "										} else {\n";
        $str .= "											\$('#deleteRecordButton')\n";
        $str .= "												.removeClass().addClass('btn btn-danger')\n";
        $str .= "												.attr('onClick',''); \n";
        $str .= "										}\n";
        $str .= "									}\n";
        $str .= "									var startIcon='./images/icons/control-stop.png';\n";
        $str .= "									\$infoPanel\n";
        $str .= "										.html('').empty()\n";
        $str .= "										.html(\"&nbsp;<img src='\"+startIcon+\"'> \"+decodeURIComponent(t['firstButtonLabel'])+\" \");\n";
        $str .= "									if(\$infoPanel.is(':hidden')) {\n";
        $str .= "										\$infoPanel.show();\n";
        $str .= "									}\n";
        $str .= "								}\n";
        $str .= "							},\n";
        $str .= "							error: function (xhr) {\n";
        $str .= "								var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "								\$('#infoError')\n";
        $str .= "									.html('').empty()\n";
        $str .= "									.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "								\$('#infoErrorRowFluid')\n";
        $str .= "									.removeClass().addClass('row-fluid');\n";
        $str .= "							}\n";
        $str .= "						});\n";
        $str .= "					} else {\n";
        $str .= "						\$infoPanel\n";
        $str .= "							.html('').empty()\n";
        $str .= "							.html(\"<span class='label label-important'>&nbsp;<img src='\"+smileyRollSweat+\"'> \"+decodeURIComponent(t['loadingErrorTextLabel'])+\"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "					}\n";
        $str .= "				},\n";
        $str .= "				error: function (xhr) {\n";
        $str .= "					var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "               	\$('#infoError')\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "					\$('#infoErrorRowFluid')\n";
        $str .= "						.removeClass().addClass('row-fluid');\n";
        $str .= "				}\n";
        $str .= "			});\n";
        $str .= "		}\n";
        $str .= "	}\n";
//update last record
        $str .= "	function endRecord(leafId,url,urlList,securityToken,updateAccess,deleteAccess) {\n";
        $str .= "		var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "		var css = \$('#endRecordButton').attr('class');\n";
        $str .= "		if (css.search('disabled') > 0) {\n";
        $str .= "			return false;\n";
        $str .= "		} else {\n";
        $str .= "			\$.ajax({\n";
        $str .= "				type    :   'GET',\n";
        $str .= "				url     :   url,\n";
        $str .= "				data    :   {\n";
        $str .= "					method          :   'dataNavigationRequest',\n";
        $str .= "					dataNavigation  :   'lastRecord',\n";
        $str .= "					output          :   'json',\n";
        $str .= "					securityToken   :   securityToken,\n";
        $str .= "					leafId          :   leafId\n";
        $str .= "				},\n";
        $str .= "				beforeSend: function () {\n";
        $str .= "					var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "					var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "					if(\$infoPanel.is(':hidden')) {\n";
        $str .= "						\$infoPanel.show();\n";
        $str .= "					}\n";
        $str .= "				},\n";
        $str .= "				success: function (data) {\n";
        $str .= "					var smileyRoll = './images/icons/smiley-roll.png';\n";
        $str .= "					var success = data.success;\n";
        $str .= "					var message = data.message;\n";
        $str .= "					var lastRecord 		= 	data.lastRecord;\n";
        $str .= "					if(lastRecord === 0 ) {\n";
        $str .= "						\$infoPanel.html('').empty().html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['recordNotFoundLabel'])+\"</span>\");\n";
        $str .= "						return false;\n";
        $str .= "					}\n";
        $str .= "					if (success === true) {\n";
        $str .= "						\$.ajax({\n";
        $str .= "							type    		:   'POST',\n";
        $str .= "							url     		:   url,\n";
        $str .= "							data    		:   {\n";
        $str .= "								method          :   'read',\n";
        $str .= "								" . $data[0]['primaryKeyName'] . "  :   lastRecord,\n";
        $str .= "								output          :   'json',\n";
        $str .= "								securityToken   :   securityToken,\n";
        $str .= "								leafId          :   leafId\n";
        $str .= "							},\n";
        $str .= "							beforeSend: function () {\n";
        $str .= "								var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "								\$infoPanel\n";
        $str .= "									.html('').empty()\n";
        $str .= "									.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "								if(\$infoPanel.is(':hidden')) {\n";
        $str .= "									\$infoPanel.show();\n";
        $str .= "								}\n";
        $str .= "							},\n";
        $str .= "							success: function (data) {\n";
        $str .= "								var x,output;\n";
        $str .= "								var success = data.success;\n";
        $str .= "								var firstRecord 	= 	data.firstRecord;\n";
        $str .= "								var lastRecord 		= 	data.lastRecord;\n";
        $str .= "								var nextRecord 		= 	data.nextRecord;\n";
        $str .= "								var previousRecord	=	data.previousRecord;\n";
        $str .= "								if (success ===true) {\n";
        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'isSingle' &&
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {
                switch ($data[$i]['field']) {
                    case 'varchar':
                    case 'text':
                    case 'string':
                        //   if (intval(str_replace(array("varchar", "(", ")"), "", $data[$i]['Type'])) == '512') {
                        //       $str .= "                                     \$('#" . $data[$i]['columnName'] . "').data(\"wysihtml5\").editor.setValue(data.data." . $data[$i]['columnName'] . ")";
                        //    } else {
                        $str .= "                                     \$('#" . $data[$i]['columnName'] . "').val(data.data." . $data[$i]['columnName'] . ")";
                        //   }
                        break;
                    case 'date':
                        $str .= "                                     x = data.data." . $data[$i]['columnName'] . ";\n";
                        $str .= "                                     x = x.split(\"-\");";
                        $str .= "									  output = 	x[2]+\"-\"+x[1]+\"-\"+x[0];\n";
                        $str .= "                                     output  = output.toString();\n";
                        $str .= "                                     \$('#" . $data[$i]['columnName'] . "').val(output)";
                        break;
                    case 'datetime':
                        $str .= "                                     x = data.data." . $data[$i]['columnName'] . ";\n";
                        $str .= "									  x = x.split(\" \");\n";
                        $str .= "									  d  = x[0].split(\"-\");\n";
                        $str .= "									  output = 	y[2]+\"-\"+y[1]+\"-\"+y[0]+\" \"+x[1];\n";
                        $str .= "                                     output  = output.toString();\n";
                        $str .= "                                     \$('#" . $data[$i]['columnName'] . "').val()";
                        break;
                    case 'bool':
                    case 'tiny':
                        $str .= "                                     if(data.data." . $data[$i]['columnName'] . " == true || data.data." . $data[$i]['columnName'] . " ==1) { \n";
                        $str .= "                                     	\$(\"#" . $data[$i]['columnName'] . "\").attr(\"checked\",\"checked\");\n";
                        $str .= "                                     	\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state',true);\n";
                        $str .= "                                     } else { \n";
                        $str .= "                                     \$(\"#" . $data[$i]['columnName'] . "\").removeAttr(\"checked\");\n";
                        $str .= "                                     \$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state', false);\n";
                        $str .= "                                     }\n";
                        $str .= "                                     \$(\"#" . $data[$i]['columnName'] . "\").val(data.data." . $data[$i]['columnName'] . ");\n";

                        break;
                    default:
                        $str .= "                                     \$('#" . $data[$i]['columnName'] . "').val(data.data." . $data[$i]['columnName'] . ")";
                }
                if ($data[$i]['Key'] == 'MUL') {
                    $str .= ".trigger(\"chosen:updated\")";
                }
                $str.=";\n";
            }
        }

        for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < $total; $i++) {
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {
				for($l =0;$l<$data[0]['targetMaximumTabRecord'];$l++) { 
					switch ($data[$i]['field']) {
						case 'varchar':
						case 'text':
						case 'string':

							$str .= "								\$('#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."').val(data.data." . $dataTabDetail[$j][$i]['columnName'] . "_".$l.")";
							//     }
							break;
						case 'date':
							$str .= "                                     x = data.data." . $dataTabDetail[$j][$i]['columnName'] . ";\n";
							$str .= "                                     x = x.split(\"-\");\n";
							$str .= "									  output = 	x[2]+\"-\"+x[1]+\"-\"+x[0];\n";
							$str .= "                                     output  = output.toString();\n";
							$str .= "                                     \$('#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."').val(output)";
							break;
						case 'datetime':
							$str .= "                                     x = data.data." . $data[$i]['columnName'] . "_".$l.";\n";
							$str .= "									  x = x.split(\" \");\n";
							$str .= "									  var d  = x[0].split(\"-\");\n";
							$str .= "									  output = 	y[2]+\"-\"+y[1]+\"-\"+y[0]+\" \"+x[1];\n";
							$str .= "                                     output  = output.toString();\n";
							$str .= "                                     \$('#" .$dataTabDetail[$j][$i]['columnName']. "_".$l."').val()";
							break;
						case 'bool':
						case 'tiny':
							$str .= "                                     if(data.data." . $dataTabDetail[$j][$i]['columnName'] . " == true || data.data." . $dataTabDetail[$j][$i]['columnName']. "_".$l."==1) { \n";
							$str .= "                                     	\$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\").attr(\"checked\",\"checked\");\n";
							$str .= "                                     	\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state',true);\n";
							$str .= "                                     } else { \n";
							$str .= "                                     \$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\").removeAttr(\"checked\");\n";
							$str .= "                                     \$('input[name=\"" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."\"]').bootstrapSwitch('state', false);\n";
							$str .= "                                     }\n";
							$str .= "                                     \$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."\").val(data.data." . $data[$i]['columnName']. "_".$l.");\n";

							break;
						default:
							$str .= "                                     \$('#" . $dataTabDetail[$j][$i]['columnName']. "_".$l."').val(data.data." . $dataTabDetail[$j][$i]['columnName']. "_".$l.")";
						}
						if ($data[$i]['Key'] == 'MUL') {
							$str .= ".trigger(\"chosen:updated\")";
						}
						$str.=";\n";
					}
				}
			}
				}
			}
		}

        $str .= "                                 	if (lastRecord !== 0) {\n";
        $str .= "                                     	\$('#previousRecordButton')\n";
        $str .= "											.removeClass().addClass('btn btn-default')\n";
        $str .= "											.attr('onClick', \"previousRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+updateAccess+\",\"+deleteAccess+\")\"); \n";
        $str .= "                                     	\$('#nextRecordButton')\n";
        $str .= "											.removeClass().addClass('btn btn-default disabled').attr('onClick','');\n";
        $str .= "                                     	\$('#firstRecordCounter').val(firstRecord);\n";
        $str .= "                                     	\$('#previousRecordCounter').val(previousRecord);\n";
        $str .= "                                     	\$('#nextRecordCounter').val(nextRecord);\n";
        $str .= "                                     	\$('#lastRecordCounter').val(lastRecord);\n";
        $str .= "                                     	\$('#newRecordButton1')\n";
        $str .= "											.removeClass().addClass('btn btn-success disabled').attr('onClick', ''); \n";
        $str .= "                                     	\$('#newRecordButton2')\n";
        $str .= "											.removeClass().addClass('btn dropdown-toggle btn-success disabled'); \n";
        $str .= "                                     	\$('#newRecordButton3').attr('onClick', ''); \n";
        $str .= "                                     	\$('#newRecordButton4').attr('onClick', ''); \n";
        $str .= "                                     	\$('#newRecordButton5').attr('onClick', ''); \n";
        $str .= "                                     	\$('#newRecordButton6').attr('onClick', ''); \n";
        $str .= "                                     	\$('#newRecordButton7').attr('onClick', ''); \n";
        $str .= "                                     	if(updateAccess === 1) {\n";
        $str .= "                                       	\$('#updateRecordButton1')\n";
        $str .= "												.removeClass().addClass('btn btn-info')\n";
        $str .= "												.attr('onClick', '').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1,\"+deleteAccess+\")\");  \n";
        $str .= "                                         	\$('#updateRecordButton2')\n";
        $str .= "												.removeClass().addClass('btn dropdown-toggle btn-info')\n";
        $str .= "												.attr('onClick', '');  \n";
        $str .= "                                         	\$('#updateRecordButton3').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1,\"+deleteAccess+\")\"); \n";
        $str .= "                                         	\$('#updateRecordButton4').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',2,\"+deleteAccess+\")\"); \n";
        $str .= "                                         	\$('#updateRecordButton5').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',3,\"+deleteAccess+\")\"); \n";
        $str .= "                                     	} else {\n";
        $str .= "                                         	\$('#updateRecordButton1')\n";
        $str .= "												.removeClass().addClass('btn btn-info disabled')\n";
        $str .= "												.attr('onClick', '');  \n";
        $str .= "                                         	\$('#updateRecordButton2')\n";
        $str .= "												.removeClass().addClass('btn dropdown-toggle btn-info disabled')\n";
        $str .= "												.attr('onClick', '');  \n";
        $str .= "                                         	\$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "                                         	\$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "                                         	\$('#updateRecordButton5').attr('onClick', ''); \n";
        $str .= "                                     	}\n";
        $str .= "                                     	if(deleteAccess===1) {\n";
        $str .= "                                         	\$('#deleteRecordButton')\n";
        $str .= "                                         		.removeClass().addClass('btn btn-danger') \n";
        $str .= "                                         		.attr('onClick', \"deleteRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+deleteAccess+\")\");\n";
        $str .= "                                     	} else {\n";
        $str .= "                                         	\$('#deleteRecordButton')\n";
        $str .= "                                         		.removeClass().addClass('btn btn-danger') \n";
        $str .= "                                         		.attr('onClick',''); \n";
        $str .= "                                     	}\n";
        $str .= "                                 	}\n";
        $str .= "                             	}\n";
        $str .= "                         	},\n";
        $str .= "							error: function (xhr) {\n";
        $str .= "								var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "								\$('#infoError')\n";
        $str .= "									.html('').empty()\n";
        $str .= "									.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "								\$('#infoErrorRowFluid')\n";
        $str .= "									.removeClass().addClass('row-fluid');\n";
        $str .= "							}\n";
        $str .= "						});\n";
        $str .= "					} else {\n";
        $str .= "						\$infoPanel.html(\"<span class='label label-important'>&nbsp;\" + message + \"</span>\");\n";
        $str .= "					}\n";
        $str .= "					var endIcon='./images/icons/control-stop-180.png';\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"&nbsp;<img src='\"+endIcon+\"'> \"+decodeURIComponent(t['endButtonLabel'])+\" \");\n";
        $str .= "				},\n";
        $str .= "				error: function (xhr) {\n";
        $str .= "					var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "					\$('#infoError')\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "					\$('#infoErrorRowFluid')\n";
        $str .= "						.removeClass().addClass('row-fluid');\n";
        $str .= "				}\n";
        $str .= "			});\n";
        $str .= "		}\n";
        $str .= "	}\n";

// update previousRecord
        $str .= "	function previousRecord(leafId,url,urlList,securityToken,updateAccess,deleteAccess) {\n";
        $str .= "		var \$previousRecordCounter =  \$('#previousRecordCounter');\n";
        $str .= "		var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "		var css = \$('#previousRecordButton').attr('class');\n";
        $str .= "		if (css.search('disabled') > 0) {\n";
        $str .= "			return false;\n";
        $str .= "		} else {\n";
        $str .= "			\$('#newButton').removeClass();\n";
        $str .= "			if (\$previousRecordCounter.val() === '' || \$previousRecordCounter.val() === undefined) {\n";
        $str .= " 				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='label label-important'>\"+decodeURIComponent(t['loadingErrorTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			}\n";
        $str .= "			if (parseFloat(\$previousRecordCounter.val()) > 0 && parseFloat(\$previousRecordCounter.val()) < parseFloat(\$('#lastRecordCounter').val())) {\n";
        $str .= "				\$.ajax({\n";
        $str .= "					type	:   'POST',\n";
        $str .= "					url	:   url,\n";
        $str .= "					data    :   {\n";
        $str .= "						method          : 	'read',\n";
        $str .= "						" . $data[0]['primaryKeyName'] . "  :   \$previousRecordCounter.val(),\n";
        $str .= "						output          :   'json',\n";
        $str .= "						securityToken   :   securityToken,\n";
        $str .= "						leafId          :   leafId\n";
        $str .= "					},\n";
        $str .= "					beforeSend: function () {\n";
        $str .= "						var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "						var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "						\$infoPanel\n";
        $str .= "							.html('').empty()\n";
        $str .= "							.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "						if(\$infoPanel.is(':hidden')) {\n";
        $str .= "							\$infoPanel.show();\n";
        $str .= "						}\n";
        $str .= "					},\n";
        $str .= "					success: function (data) {\n";
        $str .= "						var x,output;\n";
        $str .= "						var success 		= 	data.success;\n";
        $str .= "						var firstRecord 	= 	data.firstRecord;\n";
        $str .= "						var lastRecord 		= 	data.lastRecord;\n";
        $str .= "						var nextRecord 		= 	data.nextRecord;\n";
        $str .= "						var previousRecord	=	data.previousRecord;\n";
        $str .= "						var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "						if (success === true) {\n";

        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {
                switch ($data[$i]['field']) {
                    case 'varchar':
                    case 'text':
                    case 'string':
                        //    if (intval(str_replace(array("varchar", "(", ")"), "", $data[$i]['Type'])) == '512') {
                        //        $str .= "							\$('#" . $data[$i]['columnName'] . "').data(\"wysihtml5\").editor.setValue(data.data." . $data[$i]['columnName'] . ")";
                        //    } else {
                        $str .= "							\$('#" . $data[$i]['columnName'] . "').val(data.data." . $data[$i]['columnName'] . ")";
                        //    }
                        break;
                    case 'date':
                        $str .= "							x = data.data." . $data[$i]['columnName'] . ";\n";
                        $str .= "							x = x.split(\"-\");\n";
                        $str .= "							output = 	x[2]+\"-\"+x[1]+\"-\"+x[0];\n";
                        $str .= "							output  = output.toString();\n";
                        $str .= "							\$('#" . $data[$i]['columnName'] . "').val(output)";
                        break;
                    case 'datetime':
                        $str .= "							x = data.data." . $data[$i]['columnName'] . ";\n";
                        $str .= "							x = x.split(\" \");\n";
                        $str .= "							d  = x[0].split(\"-\");\n";
                        $str .= "							output = 	y[2]+\"-\"+y[1]+\"-\"+y[0]+\" \"+x[1];\n";
                        $str .= "							output  = output.toString();\n";
                        $str .= "							\$('#" . $data[$i]['columnName'] . "').val()";
                        break;
                    case 'bool':
                    case 'tiny':
                        $str .= "                                     if(data.data." . $data[$i]['columnName'] . " == true || data.data." . $data[$i]['columnName'] . " ==1) { \n";
                        $str .= "                                     	\$(\"#" . $data[$i]['columnName'] . "\").attr(\"checked\",\"checked\");\n";
                        $str .= "                                     	\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state',true);\n";
                        $str .= "                                     } else { \n";
                        $str .= "                                     \$(\"#" . $data[$i]['columnName'] . "\").removeAttr(\"checked\");\n";
                        $str .= "                                     \$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state', false);\n";
                        $str .= "                                     }\n";
                        $str .= "                                     \$(\"#" . $data[$i]['columnName'] . "\").val(data.data." . $data[$i]['columnName'] . ");\n";

                        break;
                    default:
                        $str .= "							\$('#" . $data[$i]['columnName'] . "').val(data.data." . $data[$i]['columnName'] . ")";
                }
                if ($data[$i]['Key'] == 'MUL') {
                    $str .= ".trigger(\"chosen:updated\")";
                }
                $str.=";\n";
            }
        }
		
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < $total; $i++) {
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {
				for($l =0;$l<$data[0]['targetMaximumTabRecord'];$l++) { 
					switch ($data[$i]['field']) {
						case 'varchar':
						case 'text':
						case 'string':

							$str .= "								\$('#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."').val(data.data." . $dataTabDetail[$j][$i]['columnName'] . "_".$l.")";
							//     }
							break;
						case 'date':
							$str .= "                                     x = data.data." . $dataTabDetail[$j][$i]['columnName'] . ";\n";
							$str .= "                                     x = x.split(\"-\");\n";
							$str .= "									  output = 	x[2]+\"-\"+x[1]+\"-\"+x[0];\n";
							$str .= "                                     output  = output.toString();\n";
							$str .= "                                     \$('#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."').val(output)";
							break;
						case 'datetime':
							$str .= "                                     x = data.data." . $data[$i]['columnName'] . "_".$l.";\n";
							$str .= "									  x = x.split(\" \");\n";
							$str .= "									  var d  = x[0].split(\"-\");\n";
							$str .= "									  output = 	y[2]+\"-\"+y[1]+\"-\"+y[0]+\" \"+x[1];\n";
							$str .= "                                     output  = output.toString();\n";
							$str .= "                                     \$('#" .$dataTabDetail[$j][$i]['columnName']. "_".$l."').val()";
							break;
						case 'bool':
						case 'tiny':
							$str .= "                                     if(data.data." . $dataTabDetail[$j][$i]['columnName'] . " == true || data.data." . $dataTabDetail[$j][$i]['columnName']. "_".$l."==1) { \n";
							$str .= "                                     	\$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\").attr(\"checked\",\"checked\");\n";
							$str .= "                                     	\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state',true);\n";
							$str .= "                                     } else { \n";
							$str .= "                                     \$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\").removeAttr(\"checked\");\n";
							$str .= "                                     \$('input[name=\"" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."\"]').bootstrapSwitch('state', false);\n";
							$str .= "                                     }\n";
							$str .= "                                     \$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."\").val(data.data." . $data[$i]['columnName']. "_".$l.");\n";

							break;
						default:
							$str .= "                                     \$('#" . $dataTabDetail[$j][$i]['columnName']. "_".$l."').val(data.data." . $dataTabDetail[$j][$i]['columnName']. "_".$l.")";
						}
						if ($data[$i]['Key'] == 'MUL') {
							$str .= ".trigger(\"chosen:updated\")";
						}
						$str.=";\n";
					}
				}
			}
				}
			}
		}

        $str .= "                         \$('#newRecordButton1')\n";
        $str .= "							.removeClass().addClass('btn btn-success disabled').attr('onClick', ''); \n";
        $str .= "                         \$('#newRecordButton2')\n";
        $str .= "							.removeClass().addClass('btn dropdown-toggle btn-success disabled').attr('onClick', ''); \n";
        $str .= "                         \$('#newRecordButton3').attr('onClick', ''); \n";
        $str .= "                         \$('#newRecordButton4').attr('onClick', ''); \n";
        $str .= "                         \$('#newRecordButton5').attr('onClick', ''); \n";
        $str .= "                         \$('#newRecordButton6').attr('onClick', ''); \n";
        $str .= "                         \$('#newRecordButton7').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton1').removeClass().addClass('btn btn-info').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1,\"+deleteAccess+\")\"); \n";
        $str .= "                             \$('#updateRecordButton2').removeClass().addClass('btn dropdown-toggle btn-info').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton3').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1,\"+deleteAccess+\")\"); \n";
        $str .= "                             \$('#updateRecordButton4').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',2,\"+deleteAccess+\")\"); \n";
        $str .= "                             \$('#updateRecordButton5').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',3,\"+deleteAccess+\")\"); \n";
        $str .= "                         } else {\n";
        $str .= "                             \$('#updateRecordButton1')\n";
        $str .= "								.removeClass().addClass('btn btn-info disabled').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton2')\n";
        $str .= "								.removeClass().addClass('btn dropdown-toggle btn-info disabled'); \n";
        $str .= "                             \$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton5').attr('onClick', ''); \n";
        $str .= "                         }\n";
        $str .= "                         if(deleteAccess===1) {\n";
        $str .= "                             \$('#deleteRecordButton')\n";
        $str .= "                             	.removeClass().addClass('btn btn-danger')\n";
        $str .= "                             	.attr('onClick', \"deleteRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+deleteAccess+\")\"); \n";
        $str .= "                         } else {\n";
        $str .= "                             \$('#deleteRecordButton').removeClass().addClass('btn btn-danger').attr('onClick',''); \n";
        $str .= "                         }\n";
        $str .= "                         \$('#firstRecordCounter').val(firstRecord);\n";
        $str .= "                         \$('#previousRecordCounter').val(previousRecord);\n";
        $str .= "                         \$('#nextRecordCounter').val(nextRecord);\n";
        $str .= "                         \$('#lastRecordCounter').val(lastRecord);\n";
        $str .= "                         if (parseFloat(nextRecord) <= parseFloat(lastRecord)) {\n";

        $str .= "                             \$('#nextRecordButton')\n";
        $str .= "                             	.removeClass().addClass('btn btn-default')\n";
        $str .= "                             	.attr('onClick','').attr('onClick', \"nextRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+updateAccess+\",\"+deleteAccess+\")\"); \n";
        $str .= "                         } else {\n";
        $str .= "							\$('#nextRecordButton')\n";
        $str .= "								.removeClass().addClass('btn btn-default disabled')\n";
        $str .= "								.attr('onClick','');\n";
        $str .= "                         }\n";
        $str .= "                         if (parseFloat(previousRecord) === 0) {\n";
        $str .= "							 var exclamationIcon = './images/icons/exclamation.png';\n";
        $str .= "                             \$infoPanel\n";
        $str .= "								.html('').empty()\n";
        $str .= "								.html(\"&nbsp;<img src='\"+exclamationIcon+\"'> \"+decodeURIComponent(t['firstButtonLabel'])+\" \");\n";
        $str .= "                             \$('#previousRecordButton').removeClass().addClass('btn btn-default disabled').attr('onClick','');\n";
        $str .= "                         }else{\n";
        $str .= "							 var control = './images/icons/control-180.png';\n";
        $str .= "                            \$infoPanel\n";
        $str .= "								.html('').empty()\n";
        $str .= "								.html(\"&nbsp;<img src='\"+control+\"'> \"+decodeURIComponent(t['previousButtonLabel'])+\" \");\n";
        $str .= "                             if(\$infoPanel.is(':hidden')) {\n";
        $str .= "								\$infoPanel.show();\n";
        $str .= "                             }\n";
        $str .= "                     	}\n";
        $str .= "					},\n";
        $str .= "					error: function (xhr) {\n";
        $str .= "						var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "						\$('#infoError')\n";
        $str .= "							.empty().html('')\n";
        $str .= "							.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "						\$('#infoErrorRowFluid')\n";
        $str .= "							.removeClass().addClass('row-fluid');\n";
        $str .= "					}\n";
        $str .= "				});\n";
        $str .= "			}\n";
        $str .= "		}\n";
        $str .= "	}\n";
        $str .= "	function nextRecord(leafId,url,urlList,securityToken,updateAccess,deleteAccess) {\n";
        $str .= "		var \$infoPanel			=	\$('#infoPanel');\n";
        $str .= "		var \$nextRecordCounter	=	\$('#nextRecordCounter');\n";
        $str .= "		var css = \$('#nextRecordButton').attr('class');\n";
        $str .= "		if (css.search('disabled') > 0) {\n";
        $str .= "			return false;  \n";
        $str .= "		} else {\n";
        $str .= "			\$('#newButton').removeClass();\n";
        $str .= "			if (\$nextRecordCounter.val() === '' || \$nextRecordCounter.val() === undefined) {\n";
        $str .= "				\$infoPanel\n";
        $str .= "					.html('').empty()\n";
        $str .= "					.html(\"<span class='label label-important'> \"+decodeURIComponent(t['loadingErrorTextLabel'])+\"</span>\");\n";
        $str .= "				if(\$infoPanel.is(':hidden')) {\n";
        $str .= "					\$infoPanel.show();\n";
        $str .= "				}\n";
        $str .= "			}\n";
        $str .= "			if (parseFloat(\$nextRecordCounter.val()) <= parseFloat(\$('#lastRecordCounter').val())) {\n";
        $str .= "				\$.ajax({\n";
        $str .= "					type	:   'POST',\n";
        $str .= "					url	:   url,\n";
        $str .= "					data	:   {\n";
        $str .= "					method          : 	'read',\n";
        $str .= "					" . $data[0]['primaryKeyName'] . "  :   \$nextRecordCounter.val(),\n";
        $str .= "					output          : 	'json',\n";
        $str .= "					securityToken   :   securityToken,\n";
        $str .= "					leafId          :   leafId\n";
        $str .= "				},\n";
        $str .= "				beforeSend: function () {\n";
        $str .= "					var smileyRoll 	=	'./images/icons/smiley-roll.png';\n";
        $str .= "					var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "					\$infoPanel\n";
        $str .= "						.html('').empty()\n";
        $str .= "						.html(\"<span class='label label-warning'>&nbsp;<img src='\"+smileyRoll+\"'> \"+decodeURIComponent(t['loadingTextLabel'])+\"</span>\");\n";
        $str .= "					if(\$infoPanel.is(':hidden')) {\n";
        $str .= "						\$infoPanel.show();\n";
        $str .= "					}\n";
        $str .= "				},\n";
        $str .= "				success: function (data) {\n";
        $str .= "					var \$infoPanel	=	\$('#infoPanel');\n";
        $str .= "					var x,output;\n";
        $str .= "					var success 		= 	data.success;\n";
        $str .= "					var firstRecord 	= 	data.firstRecord;\n";
        $str .= "					var lastRecord 		= 	data.lastRecord;\n";
        $str .= "					var nextRecord 		= 	data.nextRecord;\n";
        $str .= "					var previousRecord	=	data.previousRecord;\n";
        $str .= "					if (success === true) {\n";

        for ($i = 0; $i < $total; $i++) {
// this field is auto update by session
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {

                switch ($data[$i]['field']) {
                    case 'varchar':
                    case 'text':
                    case 'string':
                        $str .= "						\$('#" . $data[$i]['columnName'] . "').val(data.data." . $data[$i]['columnName'] . ")";
                        break;
                    case 'date':
                        $str .= "					x = data.data." . $data[$i]['columnName'] . ";\n";
                        $str .= "					x = x.split(\"-\");";
                        $str .= "					output = 	x[2]+\"-\"+x[1]+\"-\"+x[0];\n";
                        $str .= "					output  = output.toString();\n";
                        $str .= "					\$('#" . $data[$i]['columnName'] . "').val(output)";
                        break;
                    case 'datetime':
                        $str .= "					x = data.data." . $data[$i]['columnName'] . ";\n";
                        $str .= "					x = x.split(\" \");\n";
                        $str .= "					d  = x[0].split(\"-\");\n";
                        $str .= "					output = 	y[2]+\"-\"+y[1]+\"-\"+y[0]+\" \"+x[1];\n";
                        $str .= "					output  = output.toString();\n";
                        $str .= "					\$('#" . $data[$i]['columnName'] . "').val()";
                        break;
                    case 'bool':
                    case 'tiny':
                        $str .= "                                     if(data.data." . $data[$i]['columnName'] . " == true || data.data." . $data[$i]['columnName'] . " ==1) { \n";
                        $str .= "                                     	\$(\"#" . $data[$i]['columnName'] . "\").attr(\"checked\",\"checked\");\n";
                        $str .= "                                     	\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state',true);\n";
                        $str .= "                                     } else { \n";
                        $str .= "                                     \$(\"#" . $data[$i]['columnName'] . "\").removeAttr(\"checked\");\n";
                        $str .= "                                     \$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state', false);\n";
                        $str .= "                                     }\n";
                        $str .= "                                     \$(\"#" . $data[$i]['columnName'] . "\").val(data.data." . $data[$i]['columnName'] . ");\n";

                        break;
                    default:
                        $str .= "					\$('#" . $data[$i]['columnName'] . "').val(data.data." . $data[$i]['columnName'] . ")";
                }
                if ($data[$i]['Key'] == 'MUL') {
                    $str .= ".trigger(\"chosen:updated\")";
                }
                $str.=";\n";
            }
        }
		
		for ($j = 0; $j < $tabCounter; $j++) {
            if (isset($dataTabDetail[$j]) && count($dataTabDetail[$j]) > 0) {
                $total = count($dataTabDetail[$j]);
                for ($i = 0; $i < $total; $i++) {
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
                    $data[$i]['columnName'] != 'isReview' &&
                    $data[$i]['columnName'] != 'companyId'
            ) {
				for($l =0;$l<$data[0]['targetMaximumTabRecord'];$l++) { 
					switch ($data[$i]['field']) {
						case 'varchar':
						case 'text':
						case 'string':

							$str .= "								\$('#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."').val(data.data." . $dataTabDetail[$j][$i]['columnName'] . "_".$l.")";
							//     }
							break;
						case 'date':
							$str .= "                                     x = data.data." . $dataTabDetail[$j][$i]['columnName'] . ";\n";
							$str .= "                                     x = x.split(\"-\");\n";
							$str .= "									  output = 	x[2]+\"-\"+x[1]+\"-\"+x[0];\n";
							$str .= "                                     output  = output.toString();\n";
							$str .= "                                     \$('#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."').val(output)";
							break;
						case 'datetime':
							$str .= "                                     x = data.data." . $data[$i]['columnName'] . "_".$l.";\n";
							$str .= "									  x = x.split(\" \");\n";
							$str .= "									  var d  = x[0].split(\"-\");\n";
							$str .= "									  output = 	y[2]+\"-\"+y[1]+\"-\"+y[0]+\" \"+x[1];\n";
							$str .= "                                     output  = output.toString();\n";
							$str .= "                                     \$('#" .$dataTabDetail[$j][$i]['columnName']. "_".$l."').val()";
							break;
						case 'bool':
						case 'tiny':
							$str .= "                                     if(data.data." . $dataTabDetail[$j][$i]['columnName'] . " == true || data.data." . $dataTabDetail[$j][$i]['columnName']. "_".$l."==1) { \n";
							$str .= "                                     	\$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\").attr(\"checked\",\"checked\");\n";
							$str .= "                                     	\$('input[name=\"" . $data[$i]['columnName'] . "\"]').bootstrapSwitch('state',true);\n";
							$str .= "                                     } else { \n";
							$str .= "                                     \$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "\").removeAttr(\"checked\");\n";
							$str .= "                                     \$('input[name=\"" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."\"]').bootstrapSwitch('state', false);\n";
							$str .= "                                     }\n";
							$str .= "                                     \$(\"#" . $dataTabDetail[$j][$i]['columnName'] . "_".$l."\").val(data.data." . $data[$i]['columnName']. "_".$l.");\n";

							break;
						default:
							$str .= "                                     \$('#" . $dataTabDetail[$j][$i]['columnName']. "_".$l."').val(data.data." . $dataTabDetail[$j][$i]['columnName']. "_".$l.")";
						}
						if ($data[$i]['Key'] == 'MUL') {
							$str .= ".trigger(\"chosen:updated\")";
						}
						$str.=";\n";
					}
				}
			}
				}
			}
		}
		
		
		
        $str .= "						\$('#newRecordButton1')\n";
        $str .= "							.removeClass().addClass('btn btn-success disabled'); \n";
        $str .= "						\$('#newRecordButton2')\n";
        $str .= "							.removeClass().addClass('btn dropdown-toggle btn-success disabled'); \n";
        $str .= "						\$('#newRecordButton3').attr('onClick', ''); \n";
        $str .= "						\$('#newRecordButton4').attr('onClick', ''); \n";
        $str .= "						\$('#newRecordButton5').attr('onClick', ''); \n";
        $str .= "						\$('#newRecordButton6').attr('onClick', ''); \n";
        $str .= "						\$('#newRecordButton7').attr('onClick', ''); \n";
        $str .= "                         if(updateAccess === 1) {\n";
        $str .= "                             \$('#updateRecordButton1')\n";
        $str .= "								.removeClass().addClass('btn btn-info').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1,'\"+deleteAccess+\")\"); \n";
        $str .= "                             \$('#updateRecordButton2')\n";
        $str .= "								.removeClass().addClass('btn dropdown-toggle btn-info').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton3').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',1,'\"+deleteAccess+\")\"); \n";
        $str .= "                             \$('#updateRecordButton4').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',2,'\"+deleteAccess+\")\"); \n";
        $str .= "                             \$('#updateRecordButton5').attr('onClick', \"updateRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',3,'\"+deleteAccess+\")\"); \n";
        $str .= "                         } else {\n";
        $str .= "                             \$('#updateRecordButton1')\n";
        $str .= "								.removeClass().addClass('btn btn-info disabled').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton2')\n";
        $str .= "								.removeClass().addClass('btn dropdown-toggle btn-info disabled'); \n";
        $str .= "                             \$('#updateRecordButton3').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton4').attr('onClick', ''); \n";
        $str .= "                             \$('#updateRecordButton5').attr('onClick', ''); \n";
        $str .= "                         }\n";
        $str .= "                         if(deleteAccess===1) {\n";
        $str .= "                             \$('#deleteRecordButton')\n";
        $str .= "                             	.removeClass().addClass('btn btn-danger') \n";
        $str .= "                             	.attr('onClick', \"deleteRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+deleteAccess+\")\"); \n";
        $str .= "                         } else {\n";
        $str .= "                             \$('#deleteRecordButton')\n";
        $str .= "                             	.removeClass().addClass('btn btn-danger')\n";
        $str .= "                             	.attr('onClick',''); \n";
        $str .= "                         }\n";


        $str .= "						\$('#firstRecordCounter').val(firstRecord);\n";
        $str .= "						\$('#previousRecordCounter').val(previousRecord);\n";
        $str .= "						\$('#nextRecordCounter').val(nextRecord);\n";
        $str .= "						\$('#lastRecordCounter').val(lastRecord);\n";
        $str .= "						if (parseFloat(previousRecord) > 0) {\n";
        $str .= "							\$('#previousRecordButton')\n";
        $str .= "                             	.removeClass().addClass('btn btn-default')\n";
        $str .= "                             	.attr('onClick', \"previousRecord(\"+leafId+\",'\"+url+\"','\"+urlList+\"','\"+securityToken+\"',\"+updateAccess+\",\"+deleteAccess+\")\"); \n";
        $str .= "						} else {\n";
        $str .= "							\$('#previousRecordButton')\n";
        $str .= "								.removeClass().addClass('btn btn-default disabled')\n";
        $str .= "								.attr('onClick','');\n";
        $str .= "							}\n";
        $str .= "							if (parseFloat(nextRecord) === 0) {\n";
        $str .= "								var exclamationIcon='./images/icons/exclamation.png';\n";
        $str .= "								\$('#nextRecordButton')\n";
        $str .= "									.removeClass().addClass('btn btn-default disabled')\n";
        $str .= "									.attr('onClick','');\n";
        $str .= "								\$infoPanel\n";
        $str .= "									.html('').empty()\n";
        $str .= "									.html(\"&nbsp;<img src='\"+exclamationIcon+\"'> \"+decodeURIComponent(t['endButtonLabel'])+\" \");\n";
        $str .= "							}else {\n";
        $str .= "								var controlIcon='./images/icons/control.png';\n";
        $str .= "								\$infoPanel\n";
        $str .= "									.html('').empty()\n";
        $str .= "									.html(\"&nbsp;<img src='\"+controlIcon+\"'> \"+decodeURIComponent(t['nextButtonLabel'])+\" \");\n";

        $str .= "							}\n";
        $str .= "							if(\$infoPanel.is(':hidden')) {\n";
        $str .= "								\$infoPanel.show();\n";
        $str .= "							}\n";
        $str .= "						}\n";
        $str .= "					},\n";
        $str .= "					error: function (xhr) {\n";
        $str .= "						var smileyRollSweat 	=	'./images/icons/smiley-roll-sweat.png';\n";
        $str .= "						\$('#infoError')\n";
        $str .= "							.html('').empty()\n";
        $str .= "							.html(\"<span class='alert alert-error col-xs-12 col-sm-12 col-md-12'><img src='\"+smileyRollSweat+\"'><strong>\" + xhr.status+ \"</strong> : \" + decodeURIComponent(t['loadingErrorTextLabel']) + \"</span>\");\n";
        $str .= "						\$('#infoErrorRowFluid')\n";
        $str .= "							.removeClass().addClass('row-fluid');\n";
        $str .= "					}\n";
        $str .= "				});\n";
        $str .= "			}\n";
        $str .= "		}\n";
        $str .= "	}\n";
    }
	return $str;
}

?>