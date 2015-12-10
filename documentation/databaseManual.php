<?php
include 'functions.php';
page_header() ?>
<?php nav(); ?>
<section id="wiki-content" class="wiki-content">
<h1 id="markdown-header-welcome">Welcome</h1>
<p>This is a wrapper for a PHP MySQL class, which utilizes MySQLi. This is inspired from CodeIgniter php framework. Most of the functions and documentations are identical to CodeIgniter database class and user guide and are extracted from it. </p>
<p>You do not need to use CodeIgniter to use this wrapper. Simply include the class file and you are good to go.</p>
<p>PHP 5.3 + MySQLi  is required. </p>
<div class="toc">
    <ul>
        <li><a href="#markdown-header-welcome">Welcome</a><ul>
                <li><a href="#markdown-header-usage">Usage</a></li>
                <li><a href="#markdown-header-select-query">SELECT Query</a></li>
                <li><a href="#markdown-header-manual-db-query">Manual : $db-&gt;query()</a></li>
                <li><a href="#markdown-header-get-only-the-first-row-db-query_first">Get only the first row : $db-&gt;query_first()</a></li>
                <li><a href="#markdown-header-executing-query-db-execute">Executing Query : $db-&gt;execute()</a></li>
                <li><a href="#markdown-header-using-active-record-pattern">Using Active Record Pattern</a></li>
                <li><a href="#markdown-header-select-query-db-select-from">SELECT Query : $db-&gt;select()-&gt;from()</a></li>
                <li><a href="#markdown-header-distinct-db-distinct">DISTINCT : $db-&gt;distinct();</a></li>
                <li><a href="#markdown-header-from-clause-db-from">FROM clause : $db-&gt;from()</a></li>
                <li><a href="#markdown-header-where-clause-db-where">WHERE clause : $db-&gt;where()</a></li>
                <li><a href="#markdown-header-or_where-clause-db-or_where">OR_WHERE clause : $db-&gt;or_where()</a></li>
                <li><a href="#markdown-header-where-in-db-where_in">WHERE IN: $db-&gt;where_in()</a></li>
                <li><a href="#markdown-header-or-where-in-db-or_where_in">OR WHERE IN: $db-&gt;or_where_in()</a></li>
                <li><a href="#markdown-header-where-not-in-db-where_not_in">WHERE NOT IN : $db-&gt;where_not_in()</a></li>
                <li><a href="#markdown-header-or-where-not-in-db-or_where_not_in">OR WHERE NOT IN: $db-&gt;or_where_not_in()</a></li>
                <li><a href="#markdown-header-parenthesis-between-where">Parenthesis between WHERE</a></li>
                <li><a href="#markdown-header-select-from-where-execute">SELECT + FROM + WHERE + Execute</a></li>
                <li><a href="#markdown-header-fetching-the-result-db-fetch">Fetching the result : $db-&gt;fetch()</a></li>
                <li><a href="#markdown-header-fetching-the-first-row-db-fetch_first-or-db-fetch_result">Fetching the first row : $db-&gt;fetch_first() or $db-&gt;fetch_result()</a></li>
                <li><a href="#markdown-header-fetching-simple-array">Fetching as a simple array : $db-&gt;fetch_simple_array('field')</a></li>
                <li><a href="#markdown-header-limit-and-offset-db-limit">LIMIT and OFFSET : $db-&gt;limit()</a></li>
                <li><a href="#markdown-header-get-db-get-from-version-151">GET : $db-&gt;get() ( from version 1.5.1)</a></li>
                <li><a href="#markdown-header-select_max-db-select_max">SELECT_MAX : $db-&gt;select_max()</a></li>
                <li><a href="#markdown-header-select_min-db-select_min">SELECT_MIN : $db-&gt;select_min()</a></li>
                <li><a href="#markdown-header-select_avg-db-select_avg">SELECT_AVG : $db-&gt;select_avg()</a></li>
                <li><a href="#markdown-header-select_sum-db-select_sum">SELECT_SUM : $db-&gt;select_sum()</a></li>
                <li><a href="#markdown-header-inserting-data-db-insert">Inserting Data :  $db-&gt;insert()</a></li>
                <li><a href="#markdown-header-update-query-db-update">Update query : $db-&gt;update()</a></li>
                <li><a href="#markdown-header-last-query-db-last_query">Last Query : $db-&gt;last_query()</a></li>
                <li><a href="#markdown-header-dry-run-db-dryrun">Dry Run : $db-&gt;dryrun()</a></li>
                <li><a href="#markdown-header-escape-string-db-escape">Escape String : $db-&gt;escape()</a></li>
                <li><a href="#markdown-header-like-db-like">LIKE : $db-&gt;like()</a></li>
                <li><a href="#markdown-header-or-like-db-or_like">OR LIKE : $db-&gt;or_like()</a></li>
                <li><a href="#markdown-header-having-db-having">HAVING : $db-&gt;having()</a></li>
                <li><a href="#markdown-header-or-having-db-or_having">OR HAVING : $db-&gt;or_having()</a></li>
                <li><a href="#markdown-header-group-by-db-group_by">GROUP BY : $db-&gt;group_by()</a></li>
                <li><a href="#markdown-header-order-by-db-order_by">ORDER BY : $db-&gt;order_by()</a></li>
                <li><a href="#markdown-header-delete-db-delete">DELETE : $db-&gt;delete();</a></li>
                <li><a href="#markdown-header-dry-run-on-delete-query">Dry Run on DELETE query</a></li>
                <li><a href="#markdown-header-join-db-join">JOIN : $db-&gt;join();</a></li>
                <li><a href="#markdown-header-find_in_set-db-find_in_set-from-version-143">FIND_IN_SET : $db-&gt;find_in_set()   ( from version 1.4.3)</a></li>
                <li><a href="#markdown-header-between-db-between-from-version-146">BETWEEN : $db-&gt;between()   ( from version 1.4.6)</a></li>
                <li><a href="#markdown-header-log">LOG : $db-&gt;log('message')   ( from version 1.4.6)</a></li>
            </ul>
        </li>
    </ul>
</div>
<h2 id="markdown-header-usage">Usage</h2>
<p>To use this class, import it to your project</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="k">require_once</span> <span class="s1">&#39;class.database.php&#39;</span> <span class="p">;</span>
</pre></div>


<p>Once the class file is included, initialize it</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Database</span><span class="p">(</span><span class="nv">$host</span><span class="p">,</span> <span class="nv">$username</span><span class="p">,</span> <span class="nv">$password</span><span class="p">,</span> <span class="nv">$database</span><span class="p">);</span>
</pre></div>


<p>If your MySQL installation is using a non standard port, you can specify the port as </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span> <span class="o">=</span> <span class="k">new</span> <span class="nx">Database</span><span class="p">(</span><span class="nv">$host</span><span class="p">,</span> <span class="nv">$username</span><span class="p">,</span> <span class="nv">$password</span><span class="p">,</span> <span class="nv">$database</span><span class="p">,</span> <span class="nv">$port</span><span class="p">);</span>
</pre></div>


<p>If you are going to use a table prefix, you can assign it as </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">set_table_prefix</span><span class="p">(</span><span class="s1">&#39;wp_&#39;</span><span class="p">);</span> <span class="c1">// Sets wp_ as table prefix</span>
</pre></div>


<h2 id="markdown-header-select-query">SELECT Query</h2>
<p>A query string can be generated in two ways</p>
<ol>
    <li>Manual query </li>
    <li>Using active records</li>
</ol>
<h2 id="markdown-header-manual-db-query">Manual : $db-&gt;query()</h2>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$sql</span> <span class="o">=</span> <span class="s2">&quot;SELECT * FROM table&quot;</span> <span class="p">;</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">query</span><span class="p">(</span><span class="nv">$sql</span><span class="p">)</span> <span class="p">;</span>
</pre></div>


<h2 id="markdown-header-get-only-the-first-row-db-query_first">Get only the first row : $db-&gt;query_first()</h2>
<p>query_first() can be used to get the first row of the query. </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">query_first</span><span class="p">(</span><span class="s2">&quot;SELECT * FROM table&quot;</span><span class="p">)</span> <span class="p">;</span>
<span class="c1">// Produces: SELECT * FROM table LIMIT 1 ;</span>
</pre></div>


<h2 id="markdown-header-executing-query-db-execute">Executing Query : $db-&gt;execute()</h2>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$sql</span> <span class="o">=</span> <span class="s2">&quot;SELECT * FROM table&quot;</span> <span class="p">;</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">query</span><span class="p">(</span><span class="nv">$sql</span><span class="p">)</span> <span class="p">;</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>

<span class="c1">// Also using method chaining</span>

<span class="nv">$sql</span> <span class="o">=</span> <span class="s2">&quot;SELECT * FROM table&quot;</span><span class="p">;</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">query</span><span class="p">(</span><span class="nv">$sql</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">()</span> <span class="p">;</span>

<span class="k">echo</span> <span class="s2">&quot;Affected Rows : &quot;</span> <span class="o">.</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">affected_rows</span> <span class="p">;</span>  <span class="c1">// Outputs the affected rows</span>
</pre></div>


<h2 id="markdown-header-using-active-record-pattern">Using Active Record Pattern</h2>
<h2 id="markdown-header-select-query-db-select-from">SELECT Query : $db-&gt;select()-&gt;from()</h2>
<p>The following function permits you to write the SELECT portion of your query</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">(</span><span class="s1">&#39;title, content, date&#39;</span><span class="p">);</span>
<span class="c1">// Produces: SELECT title, content, date</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">(</span><span class="s1">&#39;*&#39;</span><span class="p">);</span>
<span class="c1">// Produces: SELECT *</span>
</pre></div>


<p>If you do not call the select() method, "SELECT *" will be assumed. If no parameter is given, select() will assume *</p>
<h2 id="markdown-header-distinct-db-distinct">DISTINCT : $db-&gt;distinct();</h2>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">distinct</span><span class="p">();</span>

<span class="c1">// Produces: SELECT DISTINCT</span>
</pre></div>


<h2 id="markdown-header-from-clause-db-from">FROM clause : $db-&gt;from()</h2>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span> <span class="p">;</span> <span class="c1">// Set the table name</span>
</pre></div>


<p>You can also chain the methods such as </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">(</span><span class="s2">&quot;id, email&quot;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span> <span class="p">;</span>
<span class="c1">// Produces : SELECT id, email FROM table</span>
</pre></div>


<h2 id="markdown-header-where-clause-db-where">WHERE clause : $db-&gt;where()</h2>
<p>The general syntax for where() is </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;a&#39;</span><span class="p">,</span> <span class="s1">&#39;b&#39;</span> <span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;c&#39;</span><span class="p">,</span> <span class="s1">&#39;d&#39;</span> <span class="p">);</span>
</pre></div>


<p>You can also feed an array as</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span> <span class="k">array</span>
          <span class="p">(</span><span class="s1">&#39;a&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;b&#39;</span><span class="p">,</span>
           <span class="s1">&#39;c&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;d&#39;</span>
<span class="p">)</span> <span class="p">;</span>
</pre></div>


<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$where</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
     <span class="s1">&#39;name&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;test&#39;</span><span class="p">,</span>
     <span class="s1">&#39;email&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;email@example.com&#39;</span>
<span class="p">);</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="nv">$where</span><span class="p">);</span>
<span class="c1">// Produces: WHERE name = &#39;test&#39; AND email = &#39;email&#39; </span>
<span class="c1">// Using method chaining</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="nv">$where</span><span class="p">)</span> <span class="p">;</span>
<span class="c1">// Produces: SELECT * FROM table WHERE name = &#39;test&#39; AND email = &#39;email&#39; </span>

<span class="c1">// You can also skip select() if you want. </span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="nv">$where</span><span class="p">)</span> <span class="p">;</span>
<span class="c1">// Produces: SELECT * FROM table WHERE name = &#39;test&#39; AND email = &#39;email&#39; </span>
</pre></div>


<h2 id="markdown-header-or_where-clause-db-or_where">OR_WHERE clause : $db-&gt;or_where()</h2>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;name !=&#39;</span><span class="p">,</span> <span class="nv">$name</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">or_where</span><span class="p">(</span><span class="s1">&#39;id &gt;&#39;</span><span class="p">,</span> <span class="nv">$id</span><span class="p">);</span>

<span class="c1">// Produces: WHERE name != &#39;Joe&#39; OR id &gt; 50</span>
</pre></div>


<h2 id="markdown-header-where-in-db-where_in">WHERE IN: $db-&gt;where_in()</h2>
<p>Generates a WHERE field IN ('item', 'item') SQL query joined with AND if appropriate</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$names</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span><span class="s1">&#39;Frank&#39;</span><span class="p">,</span> <span class="s1">&#39;Todd&#39;</span><span class="p">,</span> <span class="s1">&#39;James&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where_in</span><span class="p">(</span><span class="s1">&#39;username&#39;</span><span class="p">,</span> <span class="nv">$names</span><span class="p">);</span>
<span class="c1">// Produces: WHERE username IN (&#39;Frank&#39;, &#39;Todd&#39;, &#39;James&#39;)</span>
</pre></div>


<h2 id="markdown-header-or-where-in-db-or_where_in">OR WHERE IN: $db-&gt;or_where_in()</h2>
<p>Generates a WHERE field IN ('item', 'item') SQL query joined with OR if appropriate</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$names</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span><span class="s1">&#39;Frank&#39;</span><span class="p">,</span> <span class="s1">&#39;Todd&#39;</span><span class="p">,</span> <span class="s1">&#39;James&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">or_where_in</span><span class="p">(</span><span class="s1">&#39;username&#39;</span><span class="p">,</span> <span class="nv">$names</span><span class="p">);</span>
<span class="c1">// Produces: OR username IN (&#39;Frank&#39;, &#39;Todd&#39;, &#39;James&#39;)</span>
</pre></div>


<h2 id="markdown-header-where-not-in-db-where_not_in">WHERE NOT IN : $db-&gt;where_not_in()</h2>
<p>Generates a WHERE field NOT IN ('item', 'item') SQL query joined with AND if appropriate</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$names</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span><span class="s1">&#39;Frank&#39;</span><span class="p">,</span> <span class="s1">&#39;Todd&#39;</span><span class="p">,</span> <span class="s1">&#39;James&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where_not_in</span><span class="p">(</span><span class="s1">&#39;username&#39;</span><span class="p">,</span> <span class="nv">$names</span><span class="p">);</span>
<span class="c1">// Produces: WHERE username NOT IN (&#39;Frank&#39;, &#39;Todd&#39;, &#39;James&#39;)</span>
</pre></div>


<h2 id="markdown-header-or-where-not-in-db-or_where_not_in">OR WHERE NOT IN: $db-&gt;or_where_not_in()</h2>
<p>Generates a WHERE field NOT IN ('item', 'item') SQL query joined with OR if appropriate</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$names</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span><span class="s1">&#39;Frank&#39;</span><span class="p">,</span> <span class="s1">&#39;Todd&#39;</span><span class="p">,</span> <span class="s1">&#39;James&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">or_where_not_in</span><span class="p">(</span><span class="s1">&#39;username&#39;</span><span class="p">,</span> <span class="nv">$names</span><span class="p">);</span>
<span class="c1">// Produces: OR username NOT IN (&#39;Frank&#39;, &#39;Todd&#39;, &#39;James&#39;)</span>
</pre></div>


<h2 id="markdown-header-parenthesis-between-where">Parenthesis between WHERE</h2>
<p>To open a parenthesis, use open_where() and to close use close_where()</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">(</span><span class="s1">&#39;column&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;foo&#39;</span><span class="p">,</span> <span class="mi">15</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">open_where</span><span class="p">();</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">or_where</span><span class="p">(</span><span class="s1">&#39;foo &lt;&#39;</span><span class="p">,</span> <span class="mi">15</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;bar &gt;=&#39;</span><span class="p">,</span> <span class="mi">15</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">close_where</span><span class="p">();</span>

<span class="c1">// Produces  SELECT `column` FROM `table` WHERE `foo` = 15 OR (`foo` &lt; 15 AND `bar` &gt;= 15) </span>
</pre></div>


<h2 id="markdown-header-select-from-where-execute">SELECT + FROM + WHERE + Execute</h2>
<p>The following example combines all the function to get the result easily</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="nv">$where</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>
<span class="nv">$affected</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">affected_rows</span> <span class="p">;</span> <span class="c1">// Gets the total number of rows selected </span>

<span class="c1">// Again, you can skip the select() method if you are selecting all fields (*)</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="nv">$where</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>
</pre></div>


<h2 id="markdown-header-fetching-the-result-db-fetch">Fetching the result : $db-&gt;fetch()</h2>
<p>The result will be output as associative array when the fetch() is called. You do not need to call execute() before you call fetch(). The functions execute() and fetch() acts like same. The former does not return data and the latter returns an array with the data. In both the cases, $db-&gt;affected_rows will be set. </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>


<span class="nv">$rows</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="nv">$where</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>
<span class="k">echo</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">affected_rows</span> <span class="p">;</span> <span class="c1">// Output the total number of selected rows </span>

<span class="k">foreach</span><span class="p">(</span><span class="nv">$rows</span> <span class="k">as</span> <span class="nv">$row</span> <span class="p">)</span>
<span class="p">{</span>
   <span class="nb">var_dump</span><span class="p">(</span><span class="nv">$row</span><span class="p">);</span>
<span class="p">}</span>

<span class="c1">// Or in short</span>

<span class="nv">$rows</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>
<span class="nb">var_dump</span><span class="p">(</span><span class="nv">$rows</span><span class="p">);</span>
<span class="c1">// Produces: SELECT * FROM table</span>
</pre></div>


<h2 id="markdown-header-fetching-the-first-row-db-fetch_first-or-db-fetch_result">Fetching the first row : $db-&gt;fetch_first() or $db-&gt;fetch_result()</h2>
<p>This function will return only the first row of the result</p>
    <div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$array</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch_first</span><span class="p">()</span> <span class="p">;</span>

<span class="c1">// Produces SELECT * FROM table LIMIT 1</span>
<span class="c1">// Returns an array</span>
</pre></div>

    <h2 id="markdown-header-fetching-simple-array">Fetching as a simple array : $db-&gt;fetch_simple_array('field')</h2>
<p>This function will return an array consisting of the id and passed field as a simple associative array</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$array</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch_simple_array</span><span class="p">('field')</span> <span class="p">;</span>

<span class="c1">// Produces SELECT id,field FROM table</span>
<span class="c1">// Returns an array</span>
 <span class="c1">// array(1=>'value1',22=>'value2',42=>'value3')</span>

</pre></div>


<h2 id="markdown-header-limit-and-offset-db-limit">LIMIT and OFFSET : $db-&gt;limit()</h2>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">limit</span><span class="p">(</span><span class="mi">1</span><span class="p">);</span>

<span class="c1">// Produces the limit part :  LIMIT 1</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">limit</span><span class="p">(</span><span class="mi">1</span><span class="p">,</span><span class="mi">2</span><span class="p">);</span>

<span class="c1">// Produces the limit and offset : LIMIT 1,2 </span>

<span class="c1">// Example</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">limit</span><span class="p">(</span><span class="mi">1</span><span class="p">,</span><span class="mi">5</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>

<span class="c1">// Produces: SELECT * FROM table LIMIT 1, 5</span>
</pre></div>


<h2 id="markdown-header-get-db-get-from-version-151">GET : $db-&gt;get() ( from version 1.5.1)</h2>
<p>Get  function saves time by calling multiple functions at once.</p>
<div class="codehilite"><pre><span class="p">$</span><span class="nv">db</span><span class="x">-&gt;select(&#39;*&#39;)-&gt;from(&#39;table&#39;)-&gt;fetch();</span>
</pre></div>


<p>The same code can be expressed using </p>
<div class="codehilite"><pre><span class="p">$</span><span class="nv">db</span><span class="x">-&gt;get(&#39;table&#39;);</span>
</pre></div>


<p>Get also takes Limit as the second parameter and Offset as the third parameter. These parameters are optional.</p>
<p><code>$db-&gt;select('*')-&gt;from('table')-&gt;limit(1,2)-&gt;fetch();</code></p>
<p>is equivalent to </p>
<div class="codehilite"><pre><span class="p">$</span><span class="nv">db</span><span class="x">-&gt;get(&#39;table&#39;, 1, 2);</span>
</pre></div>


<h2 id="markdown-header-select_max-db-select_max">SELECT_MAX : $db-&gt;select_max()</h2>
<p>Writes a "SELECT MAX(field)" portion for your query. You can optionally include a second parameter to rename the resulting field.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$result</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select_max</span><span class="p">(</span><span class="s1">&#39;age&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>

<span class="c1">// Produces: SELECT MAX(age) AS age FROM members</span>

<span class="nv">$result</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select_max</span><span class="p">(</span><span class="s1">&#39;age&#39;</span><span class="p">,</span> <span class="s1">&#39;member_age&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();;</span>

<span class="c1">// Produces: SELECT MAX(age) AS member_age FROM members</span>
</pre></div>


<h2 id="markdown-header-select_min-db-select_min">SELECT_MIN : $db-&gt;select_min()</h2>
<p>Writes a "SELECT MIN(field)" portion for your query. As with select_max(), You can optionally include a second parameter to rename the resulting field.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$result</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select_min</span><span class="p">(</span><span class="s1">&#39;age&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>

<span class="c1">// Produces: SELECT MIN(age) AS age FROM members</span>

<span class="nv">$result</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select_min</span><span class="p">(</span><span class="s1">&#39;age&#39;</span><span class="p">,</span> <span class="s1">&#39;member_age&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();;</span>

<span class="c1">// Produces: SELECT MIN(age) AS member_age FROM members</span>
</pre></div>


<h2 id="markdown-header-select_avg-db-select_avg">SELECT_AVG : $db-&gt;select_avg()</h2>
<p>Writes a "SELECT AVG(field)" portion for your query. As with select_max(), You can optionally include a second parameter to rename the resulting field.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$result</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select_avg</span><span class="p">(</span><span class="s1">&#39;age&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>

<span class="c1">// Produces: SELECT AVG(age) AS age FROM members</span>

<span class="nv">$result</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select_avg</span><span class="p">(</span><span class="s1">&#39;age&#39;</span><span class="p">,</span> <span class="s1">&#39;member_age&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();;</span>

<span class="c1">// Produces: SELECT AVG(age) AS member_age FROM members</span>
</pre></div>


<h2 id="markdown-header-select_sum-db-select_sum">SELECT_SUM : $db-&gt;select_sum()</h2>
<p>Writes a "SELECT SUM(field)" portion for your query. As with select_max(), You can optionally include a second parameter to rename the resulting field.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$result</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select_sum</span><span class="p">(</span><span class="s1">&#39;age&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>

<span class="c1">// Produces: SELECT SUM(age) AS age FROM members</span>

<span class="nv">$result</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select_sum</span><span class="p">(</span><span class="s1">&#39;age&#39;</span><span class="p">,</span> <span class="s1">&#39;member_age&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();;</span>

<span class="c1">// Produces: SELECT SUM(age) AS member_age FROM members</span>
</pre></div>


<h2 id="markdown-header-inserting-data-db-insert">Inserting Data :  $db-&gt;insert()</h2>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$data</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">&#39;title&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;Some title&#39;</span><span class="p">,</span>
    <span class="s1">&#39;email&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;email@example.com&#39;</span><span class="p">,</span>
    <span class="s1">&#39;created&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;NOW()&#39;</span>

<span class="p">);</span>

<span class="nv">$id</span> <span class="o">=</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">insert</span><span class="p">(</span><span class="s1">&#39;tableName&#39;</span><span class="p">,</span> <span class="nv">$data</span><span class="p">)</span> <span class="p">;</span> <span class="c1">// $id will have the auto-increment </span>

<span class="k">echo</span> <span class="s2">&quot;Data inserted. ID:&quot;</span> <span class="o">.</span> <span class="nv">$id</span> <span class="p">;</span>
</pre></div>


<h2 id="markdown-header-update-query-db-update">Update query : $db-&gt;update()</h2>
<p>update() method can be used to update a table with the data. Update() expects that you already set the WHERE clause and LIMIT before calling update().</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$where</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
         <span class="s1">&#39;email&#39;</span> <span class="o">=</span> <span class="o">&gt;</span> <span class="s1">&#39;test@test.com&#39;</span><span class="p">,</span>
         <span class="s1">&#39;id&#39;</span> <span class="o">=&gt;</span> <span class="mi">14</span>
<span class="p">);</span>

<span class="nv">$data</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span>
         <span class="s1">&#39;email&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;new@example.com&#39;</span><span class="p">,</span>
         <span class="s1">&#39;password&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;pass1&#39;</span>
<span class="p">);</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="nv">$where</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">update</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">,</span> <span class="nv">$data</span><span class="p">);</span>

<span class="c1">// Produces: UPDATE table SET email = &#39;new@example.com&#39;, password = &#39;pass1&#39; WHERE email = &#39;test@test.com&#39; AND id = &#39;14&#39; ;</span>

<span class="c1">// NOTE: where() should be called BEFORE update(), otherwise it will be ignored. </span>

<span class="c1">// You can also use or_where()</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">or_where</span><span class="p">(</span><span class="nv">$where</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">update</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">,</span> <span class="nv">$data</span><span class="p">);</span>
<span class="c1">// Produces: UPDATE table SET email = &#39;new@example.com&#39;, password = &#39;pass1&#39; WHERE email = &#39;test@test.com&#39; OR id = &#39;14&#39; ;</span>
</pre></div>


<h2 id="markdown-header-last-query-db-last_query">Last Query : $db-&gt;last_query()</h2>
<p>This function will return the last generated query string. Useful for debugging purpose.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$this</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">(</span><span class="s1">&#39;id&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;name&#39;</span><span class="p">,</span> <span class="s1">&#39;test&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>
<span class="k">echo</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">last_query</span><span class="p">();</span>

<span class="c1">// Produces: SELECT id FROM table where name = &#39;test&#39; ;</span>
</pre></div>


<h2 id="markdown-header-dry-run-db-dryrun">Dry Run : $db-&gt;dryrun()</h2>
<p>Dry run will output the query string which is ready to be executed. If you call dryrun() then the query will not be executed. And the last_query() will output the query which is ready to be executed.</p>
<p>This function is often useful in case of calling DELETE or UPDATE function. The developer can view the DELETE or UPDATE query generated, before executing it.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$data</span><span class="p">[</span><span class="s1">&#39;email&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="s1">&#39;db@example.com&#39;</span><span class="p">;</span>

<span class="k">echo</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">dryrun</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">update</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">,</span> <span class="nv">$data</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">last_query</span><span class="p">();</span>

<span class="c1">// Produces: UPDATE table SET email = &#39;db@example.com&#39; , and the query is NOT executed. </span>
</pre></div>


<h2 id="markdown-header-escape-string-db-escape">Escape String : $db-&gt;escape()</h2>
<p>This function returns sanitized data for mysql operation</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$string</span> <span class="o">=</span> <span class="s2">&quot;where &#39;s a and &#39;s&quot;</span> <span class="p">;</span>
<span class="k">echo</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">escape</span><span class="p">(</span><span class="nv">$string</span><span class="p">);</span>

<span class="c1">// Produces: where \&#39;s a and \&#39;s</span>
</pre></div>


<h2 id="markdown-header-like-db-like">LIKE : $db-&gt;like()</h2>
<p>This function enables you to generate LIKE clauses, useful for doing searches.</p>
<p>Simple key/value method:</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="s1">&#39;title&#39;</span><span class="p">,</span> <span class="s1">&#39;match&#39;</span><span class="p">);</span>

<span class="c1">// Produces: WHERE title LIKE &#39;%match%&#39; </span>
</pre></div>


<p>If you use multiple function calls they will be chained together with AND between them:</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="s1">&#39;title&#39;</span><span class="p">,</span> <span class="s1">&#39;match&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="s1">&#39;body&#39;</span><span class="p">,</span> <span class="s1">&#39;match&#39;</span><span class="p">);</span>

<span class="c1">// WHERE title LIKE &#39;%match%&#39; AND body LIKE &#39;%match%</span>
</pre></div>


<p>If you want to control where the wildcard (%) is placed, you can use an optional third argument. Your options are 'before', 'after' and 'both' (which is the default). </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="s1">&#39;title&#39;</span><span class="p">,</span> <span class="s1">&#39;match&#39;</span><span class="p">,</span> <span class="s1">&#39;before&#39;</span><span class="p">);</span>
<span class="c1">// Produces: WHERE title LIKE &#39;%match&#39;</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="s1">&#39;title&#39;</span><span class="p">,</span> <span class="s1">&#39;match&#39;</span><span class="p">,</span> <span class="s1">&#39;after&#39;</span><span class="p">);</span>
<span class="c1">// Produces: WHERE title LIKE &#39;match%&#39;</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="s1">&#39;title&#39;</span><span class="p">,</span> <span class="s1">&#39;match&#39;</span><span class="p">,</span> <span class="s1">&#39;both&#39;</span><span class="p">);</span>
<span class="c1">// Produces: WHERE title LIKE &#39;%match%&#39; </span>
</pre></div>


<p>If you do not want to use the wildcard (%) you can pass to the optional third argument the option 'none'. </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="s1">&#39;title&#39;</span><span class="p">,</span> <span class="s1">&#39;match&#39;</span><span class="p">,</span> <span class="s1">&#39;none&#39;</span><span class="p">);</span>
<span class="c1">// Produces: WHERE title LIKE &#39;match&#39; </span>
</pre></div>


<p>Associative array method</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$array</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span><span class="s1">&#39;title&#39;</span> <span class="o">=&gt;</span> <span class="nv">$match</span><span class="p">,</span> <span class="s1">&#39;page1&#39;</span> <span class="o">=&gt;</span> <span class="nv">$match</span><span class="p">,</span> <span class="s1">&#39;page2&#39;</span> <span class="o">=&gt;</span> <span class="nv">$match</span><span class="p">);</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="nv">$array</span><span class="p">);</span>

<span class="c1">// WHERE title LIKE &#39;%match%&#39; AND page1 LIKE &#39;%match%&#39; AND page2 LIKE &#39;%match%&#39;</span>
</pre></div>


<h2 id="markdown-header-or-like-db-or_like">OR LIKE : $db-&gt;or_like()</h2>
<p>This function is identical to the one above, except that multiple instances are joined by OR:</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">like</span><span class="p">(</span><span class="s1">&#39;title&#39;</span><span class="p">,</span> <span class="s1">&#39;match&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">or_like</span><span class="p">(</span><span class="s1">&#39;body&#39;</span><span class="p">,</span> <span class="nv">$match</span><span class="p">);</span>

<span class="c1">// WHERE title LIKE &#39;%match%&#39; OR body LIKE &#39;%match%&#39;</span>
</pre></div>


<h2 id="markdown-header-having-db-having">HAVING : $db-&gt;having()</h2>
<p>Permits you to write the HAVING portion of your query. There are 2 possible syntaxes, 1 argument or 2:</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">having</span><span class="p">(</span><span class="s1">&#39;user_id = 45&#39;</span><span class="p">);</span>
<span class="c1">// Produces: HAVING user_id = 45</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">having</span><span class="p">(</span><span class="s1">&#39;user_id&#39;</span><span class="p">,</span> <span class="mi">45</span><span class="p">);</span>
<span class="c1">// Produces: HAVING user_id = 45</span>
</pre></div>


<p>You can also pass an array of multiple values as well:</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">having</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s1">&#39;title =&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;My Title&#39;</span><span class="p">,</span> <span class="s1">&#39;id &lt;&#39;</span> <span class="o">=&gt;</span> <span class="nv">$id</span><span class="p">));</span>

<span class="c1">// Produces: HAVING title = &#39;My Title&#39;, id &lt; 45</span>
</pre></div>


<h2 id="markdown-header-or-having-db-or_having">OR HAVING : $db-&gt;or_having()</h2>
<p>Identical to having(), only separates multiple clauses with "OR".</p>
<h2 id="markdown-header-group-by-db-group_by">GROUP BY : $db-&gt;group_by()</h2>
<p>Permits you to write the GROUP BY portion of your query:</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">group_by</span><span class="p">(</span><span class="s2">&quot;title&quot;</span><span class="p">);</span>

<span class="c1">// Produces: GROUP BY title </span>
</pre></div>


<p>You can also pass an array of multiple values as well:</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">group_by</span><span class="p">(</span><span class="k">array</span><span class="p">(</span><span class="s2">&quot;title&quot;</span><span class="p">,</span> <span class="s2">&quot;date&quot;</span><span class="p">));</span>

<span class="c1">// Produces: GROUP BY title, date</span>
</pre></div>


<h2 id="markdown-header-order-by-db-order_by">ORDER BY : $db-&gt;order_by()</h2>
<p>Lets you set an ORDER BY clause. The first parameter contains the name of the column you would like to order by. The second parameter lets you set the direction of the result. Options are asc or desc ( case insensitive) </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">order_by</span><span class="p">(</span><span class="s2">&quot;title&quot;</span><span class="p">,</span> <span class="s2">&quot;desc&quot;</span><span class="p">);</span>

<span class="c1">// Produces: ORDER BY title DESC </span>
</pre></div>


<p>You can also pass your own string in the first parameter:</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">order_by</span><span class="p">(</span><span class="s1">&#39;title desc, name asc&#39;</span><span class="p">);</span>

<span class="c1">// Produces: ORDER BY title desc, name asc</span>
</pre></div>


<p>Or multiple function calls can be made if you need multiple fields.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">order_by</span><span class="p">(</span><span class="s2">&quot;title&quot;</span><span class="p">,</span> <span class="s2">&quot;desc&quot;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">order_by</span><span class="p">(</span><span class="s2">&quot;name&quot;</span><span class="p">,</span> <span class="s2">&quot;asc&quot;</span><span class="p">);</span>

<span class="c1">// Produces: ORDER BY title DESC, name ASC </span>
</pre></div>


<p>In addition to this, you can also use an array for multiple calls</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$order_by</span> <span class="o">=</span> <span class="k">array</span><span class="p">(</span><span class="s1">&#39;title&#39;</span> <span class="o">=&gt;</span> <span class="s1">&#39;desc&#39;</span><span class="p">,</span>
                  <span class="s1">&#39;name&#39;</span>  <span class="o">=&gt;</span> <span class="s1">&#39;asc&#39;</span>
<span class="p">);</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">order_by</span><span class="p">(</span><span class="nv">$order_by</span><span class="p">);</span>

<span class="c1">// Produces: ORDER BY title DESC, name ASC </span>
</pre></div>


<h2 id="markdown-header-delete-db-delete">DELETE : $db-&gt;delete();</h2>
<p>Permits you to write DELETE statement. Delete function takes one optional argument - table. Also note that delete() requires that you call execute() at the end to execute the query</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">delete</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>

<span class="c1">// Produces: DELETE FROM table</span>
</pre></div>


<p>If table is not provided, it will take the table name set by '$db-&gt;from()' method</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;-&gt;</span><span class="nx">delete</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>

<span class="c1">// Produces: DELETE FROM table</span>
</pre></div>


<p>You can also use where(), limit(), having(), like() etc with delete method</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">delete</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;email&#39;</span><span class="p">,</span> <span class="s1">&#39;test@example.com&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">limit</span><span class="p">(</span><span class="mi">1</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>

<span class="c1">// Produces: DELETE FROM table WHERE email = &#39;test@example.com&#39; LIMIT 1</span>
</pre></div>


<p>delete() will also gives you the total number of rows deleted.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">delete</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">execute</span><span class="p">();</span>
<span class="k">echo</span> <span class="s2">&quot;Deleted Rows: &quot;</span> <span class="o">.</span> <span class="nv">$db</span><span class="o">-&gt;</span><span class="na">affected_rows</span> <span class="p">;</span>
</pre></div>


<h2 id="markdown-header-dry-run-on-delete-query">Dry Run on DELETE query</h2>
<p>Delete is a dangerous query which will irreversibly delete your data from the table. If you are not sure how the delete query will be generated, you can run dryrun() and it will give you the generated query which is ready to be executed.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">dryrun</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">delete</span><span class="p">(</span><span class="s1">&#39;table&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">exexute</span><span class="p">()</span><span class="o">-&gt;</span><span class="na">last_query</span><span class="p">();</span>
<span class="c1">// Outputs DELETE FROM table , but does not execute the query </span>
</pre></div>


<h2 id="markdown-header-join-db-join">JOIN : $db-&gt;join();</h2>
<p>Permits you to write JOIN statement. </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">select</span><span class="p">(</span><span class="s1">&#39;*&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;blogs&#39;</span><span class="p">);</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">join</span><span class="p">(</span><span class="s1">&#39;comments&#39;</span><span class="p">,</span> <span class="s1">&#39;comments.id = blogs.id&#39;</span><span class="p">);</span>


<span class="c1">// Produces:</span>
<span class="c1">// SELECT * FROM blogs</span>
<span class="c1">// JOIN comments ON comments.id = blogs.id</span>
</pre></div>


<p>Multiple function calls can be made if you need several joins in one query. If you need a specific type of JOIN you can specify it via the third parameter of the function. Options are: left, right, outer, inner, left outer, and right outer.</p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">join</span><span class="p">(</span><span class="s1">&#39;comments&#39;</span><span class="p">,</span> <span class="s1">&#39;comments.id = blogs.id&#39;</span><span class="p">,</span> <span class="s1">&#39;left&#39;</span><span class="p">);</span>

<span class="c1">// Produces: LEFT JOIN comments ON comments.id = blogs.id</span>
</pre></div>


<h2 id="markdown-header-find_in_set-db-find_in_set-from-version-143">FIND_IN_SET : $db-&gt;find_in_set()   ( from version 1.4.3)</h2>
<p>Generates a FIND_IN_SET query. Takes 3 parameters. First parameter is the string to find. Second parameter is the column name to search, and third parameter which is optional, will take an operator AND or OR to join multiple WHERE clauses. </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">find_in_set</span><span class="p">(</span><span class="s1">&#39;503&#39;</span><span class="p">,</span> <span class="s1">&#39;orders&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;tblinvoices&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>
<span class="c1">// Produces: SELECT *  FROM tblinvoices  WHERE  FIND_IN_SET (&#39;305&#39;, orders) </span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;id&#39;</span><span class="p">,</span> <span class="mi">5</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">find_in_set</span><span class="p">(</span><span class="s1">&#39;503&#39;</span><span class="p">,</span> <span class="s1">&#39;orders&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;tblinvoices&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>
<span class="c1">// Produces: SELECT *  FROM tblinvoices WHERE id=&#39;5&#39; AND  FIND_IN_SET (&#39;305&#39;, orders) </span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;id&#39;</span><span class="p">,</span> <span class="mi">5</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">find_in_set</span><span class="p">(</span><span class="s1">&#39;503&#39;</span><span class="p">,</span> <span class="s1">&#39;orders&#39;</span><span class="p">,</span> <span class="s1">&#39;OR&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;tblinvoices&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>
<span class="c1">// Produces: SELECT *  FROM tblinvoices WHERE id=&#39;5&#39; OR  FIND_IN_SET (&#39;305&#39;, orders) </span>
</pre></div>


<h2 id="markdown-header-between-db-between-from-version-146">BETWEEN : $db-&gt;between()   ( from version 1.4.6)</h2>
<p>Generates a BETWEEN condition. </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">between</span><span class="p">(</span><span class="s1">&#39;created&#39;</span><span class="p">,</span> <span class="s1">&#39;2014-05-05&#39;</span><span class="p">,</span> <span class="s1">&#39;2014-05-10&#39;</span><span class="p">);</span>

<span class="c1">// Produces: created BETWEEN &#39;2014-05-05&#39; AND &#39;2014-05-10&#39;</span>

<span class="nv">$db</span><span class="o">-&gt;</span><span class="na">from</span><span class="p">(</span><span class="s1">&#39;tblinvoices&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">where</span><span class="p">(</span><span class="s1">&#39;clientid&#39;</span><span class="p">,</span> <span class="s1">&#39;12&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">between</span><span class="p">(</span><span class="s1">&#39;created&#39;</span><span class="p">,</span> <span class="s1">&#39;2014-05-05&#39;</span> <span class="p">,</span> <span class="s1">&#39;2014-05-10&#39;</span><span class="p">)</span><span class="o">-&gt;</span><span class="na">fetch</span><span class="p">();</span>

<span class="c1">// Produces: SELECT * FROM tblinvoices WHERE clientid = &#39;12&#39; AND created BETWEEN &#39;2014-05-05&#39; AND &#39;2014-05-10&#39;</span>
</pre></div>

<h2 id="markdown-header-log">LOG : $db-&gt;log('message') (added by Joe)</h2>
<p>Adds a logging mechanism to log queries. </p>
<div class="codehilite"><pre><span class="cp">&lt;?php</span>
    <span class="nv">$db-&gt;log('message');</span>

    <span class="c1">// Produces: new $db->insert statement contain calling script, user information, date/time, sql generated, and passed message.</span>
</div>

</section>

<?php page_footer() ?>