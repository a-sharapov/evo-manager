<?php
if(IN_MANAGER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.");
$_SESSION['browser'] = (strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 1')!==false) ? 'legacy_IE' : 'modern';
$mxla = $modx_lang_attribute ? $modx_lang_attribute : 'en';
if(!isset($modx->config['manager_menu_height'])) $modx->config['manager_menu_height'] = '70';
if(!isset($modx->config['manager_tree_width']))  $modx->config['manager_tree_width']  = '260';
$modx->invokeEvent('OnManagerPreFrameLoader',array('action'=>$action));
?>
<!DOCTYPE html>
<html <?php echo (isset($modx_textdir) && $modx_textdir ? 'dir="rtl" lang="' : 'lang="').$mxla.'" xml:lang="'.$mxla.'"'; ?>>
<head>
    <title><?php echo $site_name?> - (MODX CMS Manager)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $modx_manager_charset?>" />
	<link rel="stylesheet" type="text/css" href="media/style/<?php echo $modx->config['manager_theme']; ?>/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="media/style/<?php echo $modx->config['manager_theme']; ?>/css/base.css" />
    <link rel="stylesheet" type="text/css" href="media/style/<?php echo $modx->config['manager_theme']; ?>/css/global.css" />
</head>
<body>
    <div id="resizer">
        <a id="hideMenu" onclick="mainMenu.toggleTreeFrame();"></a>
    </div>
    <div id="resizer2">
        <a id="hideTopMenu" onclick="mainMenu.toggleMenuFrame();"></a>
    </div>
    <div id="mainMenu">
        <iframe name="mainMenu" src="index.php?a=1&amp;f=menu" scrolling="no" frameborder="0" noresize="noresize"></iframe>
    </div>
    <div id="tree">
        <iframe name="tree" src="index.php?a=1&amp;f=tree" scrolling="no" frameborder="0" onresize="mainMenu.resizeTree();"></iframe>
    </div>

    <div id="main">
        <iframe name="main" src="index.php?a=2" scrolling="auto" frameborder="0" onload="if (mainMenu.stopWork()) mainMenu.stopWork();"></iframe>
    </div>
    
    <!--<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'></script>-->
    <script language="JavaScript" type="text/javascript">
        var _startY = 85;
        var _dragElement;
        var _oldZIndex = 999;
        var _left;
        var mask = document.createElement('div');
        mask.id = 'mask_resizer';
        mask.style.zIndex = _oldZIndex;

        InitDragDrop();

        function InitDragDrop() {
            document.getElementById('resizer').onmousedown = OnMouseDown;
            document.getElementById('resizer').onmouseup = OnMouseUp
        }

        function OnMouseDown(e) {
            if (e == null) e = window.event;
            _dragElement = e.target != null ? e.target : e.srcElement;
            if ((e.button == 1 && window.event != null || e.button == 0) && _dragElement.id == 'resizer') {
                _oldZIndex = _dragElement.style.zIndex;
                _dragElement.style.zIndex = 10000;
                _dragElement.style.background = '#a4b9cc';
                document.body.appendChild(mask)
                document.onmousemove = OnMouseMove;
                document.body.focus();
                document.onselectstart = function () {
                    return false
                };
                _dragElement.ondragstart = function () {
                    return false
                };
                return false
            }
        }

        function ExtractNumber(value) {
            var n = parseInt(value);
            return n == null || isNaN(n) ? 0 : n
        }

        function OnMouseMove(e) {
            if (e == null) var e = window.event;
            _dragElement.style.left = e.clientX + 'px';
            _dragElement.style.top = _startY + 'px';
            document.getElementById('tree').style.width = e.clientX + 'px';
            document.getElementById('main').style.left = e.clientX + 'px'
        }

        function OnMouseUp(e) {
            if (_dragElement != null) {
                _dragElement.style.zIndex = _oldZIndex;
                _dragElement.style.background = 'transparent';
                _dragElement.ondragstart = null;
                _dragElement = null;
                document.body.removeChild(mask);
                document.onmousemove = null;
                document.onselectstart = null
            }
        }
    </script>
    <?php
    $modx->invokeEvent('OnManagerFrameLoader',array('action'=>$action));
    ?>
</body>
</html>
<?php
