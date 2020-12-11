<?php

if (stristr(trim(strtolower($_SERVER['SCRIPT_NAME'])), 'page.php') !== false)
{
	die('Nothing here...');
}

/**
 * Function to get the requested page
 * @return (string) requested PHP page
*/
function getPage()
{
    $scriptName = '';
    $request  = str_replace("/app/", "", trim($_SERVER['REQUEST_URI']));

    //split the path by '/'
    $params = explode("/", $request);

    //get rid of empty index (check for double or unnessacary slashes)
    $cleans = cleansParams($params);
            
    //check if there's no or only one index
    //if so: return the homepage 'pages/main/home'
    if (empty($cleans) || (count($cleans) == 1 && strtolower($cleans[0]) == 'home'))
    {
        $scriptName = setHomePage();
    }
    else
    {
        //if no page was found as a param and the first parameter is not 'main'
        //return 404 'page not found'
        if (count($cleans) == 1)
        {
            $scriptName = setErrorPage('404');
        }

        //still no page?
        if (empty($scriptName))
        {
            //first check if a controller page was requested
            //if so: add the 'controller' map
            //if not: add the 'pages' map
            if ($cleans[0] == 'controllers')
            {
                $scriptName = $_SERVER['DOCUMENT_ROOT'] . '/' . cfg_app_path . '/controllers/' . $cleans[1] . '.php';
            }
            else
            {
                $scriptName = $_SERVER['DOCUMENT_ROOT'] . '/' . cfg_app_path . '/pages/' . $cleans[0] . '/' . $cleans[1] . '.php';
            }
        }
    }

    //check if path and filename exists
    //if not: return 404 page
    if (!file_exists($scriptName))
    {
        $scriptName = setErrorPage('404');
    }
    
    //finaly return the page to load
    return $scriptName;
}

/**
 * Get URL parameter from 'friendly' URL (e.g. /crm/customer/update/id/3)
 *	where /crm/customer is the path and update is the module
    *	URL params in the example is 'id' which has 3 as value
    *	more paramaters are supported. E.g /id/3/name/john etc.
    * @param $param (string) the parameter to get from URL
    * @return (string) empty when param was not in URL
    *	or, when requested param was empty: return all params
*/
function getUrlParam($param = null)
{
    $param = trim(strtolower($param));
    $allParams = array();
    $request  = str_replace("/app/", "", trim($_SERVER['REQUEST_URI']));

    //split the path by '/'
    $params = explode("/", $request);

    //get rid of empty index (check for double or unnessacary slashes)
    $cleans = cleansParams($params);

    if (empty($cleans) || (!empty($cleans) && count($cleans) < 2))
    {
        return '';
    }

    for ($i = 1; $i < count($cleans); $i++)
    {
        if (!empty($param))
        {
            if (trim(strtolower($cleans[$i])) == $param)
            {
                if ($i + 1 <= count($cleans) - 1)
                {
                    return $cleans[$i + 1];
                }
            }
        }
        else
        {

            if (count($cleans) > 2 && $i + 1 <= count($cleans) - 1)
            {
                $allParams[$cleans[$i]] = $cleans[$i + 1];
            }
        }
    }

    return $allParams;
}

/**
 * Returns the current path/main module such as: account, customer, profile etc. etc.
 * @return (string) the current path (if any) or false if in root (/crm)
*/
function getCurrentModule()
{
    $request  = str_replace("/app/", "", trim($_SERVER['REQUEST_URI']));

    //split the path by '/'
    $params = explode("/", $request);

    //get rid of empty index (check for double or unnessacary slashes)
    $cleans = cleansParams($params);

    if (count($cleans) == 0) return false;

    return strtolower($cleans[0]);
}

/**
 * Return the home page URL
*/
function setHomePage()
{
    return $_SERVER['DOCUMENT_ROOT'] .'/' . cfg_app_path . '/pages/main/home.php';
}

/**
 * Return error(404, 403, 500) page URL
 * @param $err (string) the error page to return
*/
function setErrorPage($err)
{
    return $_SERVER['DOCUMENT_ROOT'] .'/' . cfg_app_path . '/pages/error/error' . $err . '.php';
}

/**
 * Clean (sanitize) the complete URL string. Get ridd of spaces and make all items lowercase
 * @param $params (array)
 * @return (array) the sanitized array
*/
function cleansParams($params)
{
    $cleans = array();
    if (count($params) > 0)
    {
        foreach ($params as $key => $value) {
            if (!empty($value))
            {
                array_push($cleans, trim(strtolower($value)));
            }
        }
    }

    return $cleans;
}