<?php
  header("Content-type: text/css; charset: UTF-8");

  require('../../site/data/settings_config.php');

?>
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
  margin:0;
  padding:0;
  border:0;
  font-size:100.01%;
  font:inherit;
  vertical-align:baseline;
}
body { line-height:1; }
ol, ul { list-style:none; }
blockquote, q { quotes:none; }
blockquote:before, blockquote:after, q:before, q:after {
  content:'';
  content:none;
}
table {
  border-collapse:collapse;
  border-spacing:0;
}
article, aside, details, figcaption, figure, footer, header, hgroup, nav, section { display:block; }
audio, canvas, video {
  display:inline-block;
  *display:inline;
  *zoom:1;
}
audio:not([controls]) { display:none; }
[hidden] { display:none; }
body {
  width:100%;
  *zoom:1;
}
body:before, body:after {
  content:"";
  display:table;
}
body:after { clear:both; }
body {
  color:#222222;
  font:100.01% / 1.375 "<?php echo $BodyFont; ?>", Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;
}
h1 {
  font-weight:normal;
  color:#111111;
  margin-bottom:22px;
  font-family:'<?php echo $HeaderFont; ?>', Arial, Cambria, Georgia, Times, 'Times New Roman', serif;
  font-size:2.375em;
  line-height:1.1579;
  border-bottom:1px solid #cccccc;
  margin-bottom:21px;
}
h2 {
  font-weight:normal;
  color:#111111;
  margin-bottom:22px;
  font-family:'<?php echo $HeaderFont; ?>', Arial, Cambria, Georgia, Times, 'Times New Roman', serif;
  font-size:1.875em;
  line-height:1.4667;
}
h3 {
  font-weight:normal;
  color:#111111;
  margin-bottom:22px;
  font-family:'<?php echo $HeaderFont; ?>', Arial, Cambria, Georgia, Times, 'Times New Roman', serif;
  font-size:1.375em;
  line-height:1;
}
h4 {
  font-weight:normal;
  color:#111111;
  margin-bottom:22px;
  font-family:'<?php echo $HeaderFont; ?>', Arial, Cambria, Georgia, Times, 'Times New Roman', serif;
  font-size:1.25em;
  line-height:1.1;
}
h5 {
  font-weight:normal;
  color:#111111;
  margin-bottom:22px;
  font-family:'<?php echo $HeaderFont; ?>', Arial, Cambria, Georgia, Times, 'Times New Roman', serif;
  font-size:1em;
  font-weight:bold;
}
h6 {
  font-weight:normal;
  color:#111111;
  margin-bottom:22px;
  font-family:'<?php echo $HeaderFont; ?>', Arial, Cambria, Georgia, Times, 'Times New Roman', serif;
  font-size:1em;
  font-weight:bold;
  margin-bottom:0;
}
h1 img, h2 img, h3 img, h4 img, h5 img, h6 img { margin:0; }
p { margin-bottom:1.375em; }
a {
  color:#660000;
  text-decoration:underline;
}
a:focus, a:hover {
  color:#990000;
  text-decoration:none;
}
blockquote {
  margin-left:1em;
  margin-bottom:1.375em;
}
strong, dfn { font-weight:bold; }
em, dfn { font-style:italic; }
pre {
  margin-bottom:1.375em;
  white-space:pre;
}
pre, code, tt, .code { font:1em / 1.375 "Courier New", Courier, monospace; }
li ul, li ol { margin:0; }
ul, ol {
  margin:0.6875em 1.5em 1.375em 0;
  padding-left:1.5em;
}
ul { list-style-type:disc; }
ol { list-style-type:decimal; }
dl { margin:0 0 1.375em 0; }
dl dt { font-weight:bold; }
dd { margin-left:1.5em; }
table {
  margin-bottom:1.375em;
  width:100%;
}
caption {
  text-align:left;
  font-style:italic;
}
thead { border-bottom:2px solid #222222; }
th {
  vertical-align:bottom;
  font-weight:bold;
  text-align:left;
}
th, td { padding:5px 10px 5px 5px; }
tbody tr { border-bottom:1px solid #eeeeee; }
tbody tr:hover { color:#000000; }
tfoot { font-style:italic; }
input, textarea { font:inherit; }
input[readonly] { color:#666666; }
label { font-size:smaller; }
.validation-failed { border:2px solid red; }
.validation-message {
  color:red;
  font-size:smaller;
}
.form-action-link { font-size:smaller; }
textarea {
  width:100%;
  height:8em;
}
.content-edit input[type=text] { width:30em; }
.content-edit textarea {
  width:40em;
  height:15em;
}
.setting-edit input[type=text] { width:30em; }
.setting-edit textarea {
  width:40em;
  height:15em;
}
html {
  background-color:#eeeeee;
  overflow:-moz-scrollbars-vertical;
  overflow-y:scroll;
}
body {
  margin:0;
  padding:0;
  color:#333333;
  background-color:#ffffff;
}
#outer-wrap-header {
  padding-top:11px;
  margin-bottom:11px;
}
#inner-wrap-header {
  width:960px;
  margin:0 auto;
  *zoom:1;
}
#inner-wrap-header:before, #inner-wrap-header:after {
  content:"";
  display:table;
}
#inner-wrap-header:after { clear:both; }
#header {
  display:inline;
  float:left;
  width:940px;
  margin:0 10px;
}
#login-menu {
  float:right;
  font-size:0.95em;
}
#login-menu img.gravatar { vertical-align:middle; }
#login-menu a { text-decoration:none; }
#login-menu a:hover { text-decoration:underline; }
#banner {
  display:table;
  margin-bottom:11px;
}
#banner #site-logo {
  display:table-cell;
  vertical-align:middle;
  text-align:center;
}
#banner #site-title {
  display:table-cell;
  vertical-align:middle;
  text-align:center;
  font-size:2.5em;
  padding-left:0.2em;
  text-shadow:#cccccc 2px -2px 2px;
}
#banner #site-title a { text-decoration:none; }
#banner #site-slogan {
  display:table-cell;
  vertical-align:middle;
  text-align:center;
  font-size:1.5em;
  padding-left:10px;
}
#navbar ul.menu {
  list-style-type:none;
  padding:2px 8px;
  margin:0;
}
#navbar ul.menu li {
  padding:0;
  margin:0;
  display:inline;
}
#navbar ul.menu li a {
  padding:6px 8px;
  text-decoration:none;
  border:2px solid transparent;
}
#navbar ul.menu li a:hover {
  background:#<?php echo $NavigationbarHoverBackgroundColour; ?>;
  border:2px solid #999999;
}
#navbar ul.menu li a.selected {
  background:#cccccc;
  border:2px solid #999999;
}
#inner-wrap-flash {
  width:960px;
  margin:0 auto;
  *zoom:1;
  height:66px;
  margin-bottom:22px;
}
#inner-wrap-flash:before, #inner-wrap-flash:after {
  content:"";
  display:table;
}
#inner-wrap-flash:after { clear:both; }
#flash {
  display:inline;
  float:left;
  width:940px;
  margin:0 10px;
  height:100%;
}
#inner-wrap-featured {
  width:960px;
  margin:0 auto;
  *zoom:1;
  height:110px;
  margin-bottom:22px;
}
#inner-wrap-featured:before, #inner-wrap-featured:after {
  content:"";
  display:table;
}
#inner-wrap-featured:after { clear:both; }
#featured-first, #featured-middle, #featured-last {
  display:inline;
  float:left;
  width:300px;
  margin:0 10px;
  height:100%;
}
#inner-wrap-main {
  width:960px;
  margin:0 auto;
  *zoom:1;
  margin-bottom:22px;
}
#inner-wrap-main:before, #inner-wrap-main:after {
  content:"";
  display:table;
}
#inner-wrap-main:after { clear:both; }
#primary {
  display:inline;
  float:left;
  width:920px;
  margin:0 10px;
}
#sidebar {
  display:inline;
  float:left;
  width:300px;
  margin:0 10px;
}
#sidebar .box {
  border-top:4px double #cccccc;
  padding-top:11px;
  margin-bottom:51px;
}
#inner-wrap-triptych {
  width:960px;
  margin:0 auto;
  *zoom:1;
  height:110px;
  margin-bottom:22px;
}
#inner-wrap-triptych:before, #inner-wrap-triptych:after {
  content:"";
  display:table;
}
#inner-wrap-triptych:after { clear:both; }
#triptych { height:inherit; }
#triptych-first, #triptych-middle, #triptych-last {
  display:inline;
  float:left;
  width:300px;
  margin:0 10px;
  height:100%;
}
#inner-wrap-footer-column {
  width:960px;
  margin:0 auto;
  *zoom:1;
  height:110px;
  padding-bottom:22px;
}
#inner-wrap-footer-column:before, #inner-wrap-footer-column:after {
  content:"";
  display:table;
}
#inner-wrap-footer-column:after { clear:both; }
#footer { height:inherit; }
#footer-column-one, #footer-column-two, #footer-column-three, #footer-column-four {
  display:inline;
  float:left;
  width:220px;
  margin:0 10px;
  margin-top:1em;
  height:100%;
  background-color:rgba(255,255,255,0.5);
}
#outer-wrap-footer {
  background-color:#eeeeee;
  border-top:1px solid #bbbbbb;
}
#inner-wrap-footer {
  width:960px;
  margin:0 auto;
  *zoom:1;
  padding-top:22px;
  padding-bottom:22px;
}
#inner-wrap-footer:before, #inner-wrap-footer:after {
  content:"";
  display:table;
}
#inner-wrap-footer:after { clear:both; }
#footer {
  display:inline;
  float:left;
  width:940px;
  margin:0 10px;
  color:#666666;
}
a { color:inherit; }
a:hover {
  text-decoration:none;
  color:#5c0a0a;
}
a:focus {
  text-decoration:none;
  color:#5c0a0a;
}
.error, .alert, .warning, .notice, .success, .info {
  padding:0.8em;
  margin-bottom:1em;
  border:2px solid #dddddd;
}
.error, .alert {
  background:#fbe3e4;
  color:#8a1f11;
  border-color:#fbc2c4;
}
.notice, .warning {
  background:#fff6bf;
  color:#514721;
  border-color:#ffd324;
}
.success {
  background:#e6efc2;
  color:#264409;
  border-color:#c6d880;
}
.info {
  background:#d5edf8;
  color:#205791;
  border-color:#92cae4;
}
.error a, .alert a { color:#8a1f11; }
.notice a, .warning a { color:#514721; }
.success a { color:#264409; }
.info a { color:#205791; }
.smaller-text { font-size:smaller; }
.silent { color:#999999; }
