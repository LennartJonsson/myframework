<h1><?=startpagetitle()?></h1>
<p>Welcome to MyFrameWork index controller.</p>

<h2>Download</h2>
<p>You can download MyFrameWork from github.</p>
<blockquote>
<code>git clone git://github.com/LennartJonsson/myframework.git</code>
</blockquote>
<p>You can review its source directly on github: <a href='https://github.com/LennartJonsson/myframework'>https://github.com/LennartJonsson/myframework</a></p>

<h2>Installation</h2>
<p>First you have to make the data-directory writable. This is the place where MyFrameWork needs
to be able to write and create files:</p>
<blockquote>
<code>cd myframework; chmod 777 site/data</code>
</blockquote>

<p>Second, you have to change the value for RewriteBase in the <strong>.htaccess</strong> file in the root directory myframework to the url path value with an text editor that handles unix line endings and UTF8 character encoding, e.g. <a href='http://www.jedit.org/'>jEdit</a>:<br/>
<blockquote>
Replace<br/>"RewriteBase /"<br/>with<br/>"RewriteBase <?php echo MFW_URL_PATH; ?>".
</blockquote>
<p>Third, MyFrameWork has some modules that needs to be initialised. You can do this through a 
controller. Point your browser to the following link:</p>
<blockquote>
<a href='<?=create_url('module/install')?>'>module/install</a>
</blockquote>
