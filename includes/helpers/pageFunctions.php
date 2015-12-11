<?php
/*
 * This function output any "canned" scripts that were needed as the page was put together.
 */

function includeScripts()
{
    if($GLOBALS['scripts']>0)
    {
        ?>
        <script type="text/javascript">
            $(document).ready(function(){

        <?php
        foreach($GLOBALS['scripts'] as $script)
        {
            echo $script;
        }
        ?>

            })
        </script>
        <?php
    }
}

/*
 * This function does all the clean up, closes files, discards unneeded memory, etc.
 */
function page_cleanup($redirect='')
{
    global $ajax, $post, $baseDir, $logger, $session;

    if(!$ajax && DISPLAY_DEBUG) {

        include($baseDir."/templates/partials/debugger.php");
    }
    $_SESSION = $session->close();
    if($redirect!='')
    {
        redirect($redirect);
    }
}

/* this adds a page title */
function page_title($title,$sub='')
{
    print "<h3>$title".($sub!=''? " <small>$sub</small>":"")."</h3>\n";
}

function page_link($url,$return=false)
{
    //this function just makes sure a url ends with .php, if it ends with '/' then it will add index.php, and it'll make sure that page_base is added at the start

    //see if first character is '/', if so, remove it
    if(substr($url,strlen($url)-1,1)=='#') {
        //don't add anything for hash enders
    } else {
        if (substr($url, 0, 1) == '/') {
            $url = substr($url, 1);
        }
        //see if PAGE_BASE is already there
        if (strpos($url, PAGE_BASE) == 0) {
            $url = SERVER_NAME . PAGE_BASE . '/' . $url;
        } else {
            $url .= "/";
        }
        //now check for ending
        if (substr($url, strlen($url) - 4, 4) != '.php') {
            //ok, check if last is '/'
            if (substr($url, strlen($url) - 1, 1) == '/') {
                $url .= "index.php";
            } else {
                $url .= ".php";
            }
        }
    }
    if($return)
    {
        return $url;
    }
    echo $url;
}

