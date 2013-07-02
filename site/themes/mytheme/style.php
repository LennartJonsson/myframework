<?php
  header("Content-type: text/css; charset: UTF-8");

  require('../../../site/data/settings_config.php');

?>
/**
 * Description: Sample theme for site which extends the MyFrameWork grid-theme.
 */
@import url(../../../themes/grid/style.php);

html{background-color:#<?php echo $HtmlBackgroundColour; ?>;}
body{background-color:#<?php echo $BodyBackgroundColour; ?>;}
#outer-wrap-header{background-color:#<?php echo $OuterWrapHeaderBackgroundColour; ?>;border-bottom:<?php echo $OuterWrapHeaderBorderBottomWidth; ?>px solid #<?php echo $OuterWrapHeaderBorderBottomColour; ?>}
#outer-wrap-footer{background-color:#<?php echo $OuterWrapFooterBackgroundColour; ?>}
a{color:#<?php echo $AnchorColour; ?>}
#navbar ul.menu li a.selected{background-color:#<?php echo $NavigationbarSelectedBackgroundColour; ?>;border-bottom:none;}
