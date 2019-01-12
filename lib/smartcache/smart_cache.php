<?php

/*

Smart Cache for PHP

This is an open source cache layer developed by Alexander Romanovich for White Whale Web Services (http://www.whitewhale.net).
This cache layer may be freely distributed, but please retain this comment section.
Please see: http://technologies.whitewhale.net/cache/ for documentation.
Last Updated: 02/17/2011

*/

$GLOBALS['smart_cache']=array(); // init smart cache array
$GLOBALS['smart_cache']['dir']=dirname(__FILE__); // set path to directory containing this script

### START CONFIGURATION ###

$smart_cache['cache_dir']=$smart_cache['dir'].'/data/cache'; // required path to cache dir, writable by the web server
$GLOBALS['smart_cache']['ttl']=300; // seconds after which cache entries will be checked for freshness (recommended: 300, i.e. 5 mins.)
$GLOBALS['smart_cache']['script_limit']=30; // maximum number of GET variants of a single page that can be stored (recommended: 30)
$GLOBALS['smart_cache']['include']=''; // optional path to file to include() for uncached responses
$GLOBALS['smart_cache']['cookie_bypass']=''; // optional cookie that will bypass the cache check (unless live page unavailable)
$GLOBALS['smart_cache']['cookie_disable']=''; // option cookie that will disable the cache layer altogether

### END CONFIGURATION ###

$GLOBALS['smart_cache']['script']=hash('md5',$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_FILENAME']); // set cache script hash
$GLOBALS['smart_cache']['path']=$GLOBALS['smart_cache']['cache_dir'].'/'.$GLOBALS['smart_cache']['script']{0}.'/'.$GLOBALS['smart_cache']['script'].(!empty($_SERVER['QUERY_STRING']) ? '_'.hash('md5',$_SERVER['QUERY_STRING']) : '').(!empty($_SERVER['HTTPS']) ? '.ssl' : ''); // set path to cache file
$GLOBALS['smart_cache']['is_response_code']=isset($_GET['smart_cache_response_code']); // set flag for if this is a resonse code
$GLOBALS['smart_cache']['is_bypass']=(!empty($GLOBALS['smart_cache']['cookie_bypass']) && !empty($_COOKIE[$GLOBALS['smart_cache']['cookie_bypass']])); // set flag for if this is a cache bypass
$GLOBALS['smart_cache']['is_disable']=(!empty($GLOBALS['smart_cache']['cookie_disable']) && !empty($_COOKIE[$GLOBALS['smart_cache']['cookie_disable']])); // set flag for if this is a cache disable
$GLOBALS['smart_cache']['is_cache_request']=(!$GLOBALS['smart_cache']['is_bypass'] && empty($_POST) && !$GLOBALS['smart_cache']['is_response_code'] && !$GLOBALS['smart_cache']['is_disable']); // set flag for if this request should load from cache
if (isset($_GET['smart_cache_clean_host'])) {smartCacheCleanHost();} // if cleaning a host
else if ($GLOBALS['smart_cache']['is_disable']) { // else if running in disabled mode
	smartCacheShow('disabled'); // show the page in disabled mode
}
else if ($GLOBALS['smart_cache']['is_response_code']) { // else if this is a response code
	smartCacheShow('response_code'); // show the page in response code mode
}
else if (empty($GLOBALS['smart_cache']['is_cache_request']) || smartCacheNeedsRefresh()) { // else if not a cache request or it is but needs refresh
	smartCacheShow('uncached'); // show the page in uncached mode
}
else smartCacheShow('cached'); // else show the page in cached mode

function smartCacheShow($mode) { // shows the page content according to mode
switch($mode) { // get mode
	case 'cached': // if showing cached content
		if ($GLOBALS['smart_cache']['content']=@file_get_contents($GLOBALS['smart_cache']['path'])) { // if cache is obtainable
			if (!isset($GLOBALS['smart_cache']['mtime'])) $GLOBALS['smart_cache']['mtime']=@filemtime($GLOBALS['smart_cache']['path']); // get modification time of current cache, if not already obtained
			$etag='"'.hash('md5',$GLOBALS['smart_cache']['content']).'"'; // create etag
			if ((!empty($_SERVER['HTTP_IF_NONE_MATCH']) && str_replace('-gzip','',$_SERVER['HTTP_IF_NONE_MATCH'])==$etag) && !(!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])<$GLOBALS['smart_cache']['mtime'])) $is_etag_response=true; // flag if etag response
			header(!isset($is_etag_response) ? 'HTTP/1.1 200 OK' : 'HTTP/1.1 304 Not Modified'); // send response code
			header('Cache-Control: public, max-age='.$GLOBALS['smart_cache']['ttl']); // send cache-control header
			header('Last-Modified: '.gmdate('D, d M Y H:i:s',$GLOBALS['smart_cache']['mtime']).' GMT'); // send last-modified header
			header('Expires: '.gmdate('D, d M Y H:i:s',$_SERVER['REQUEST_TIME']+$GLOBALS['smart_cache']['ttl']).' GMT'); // send expires header
			header('X-Smart-Cache: cached'); // send custom cache header
			header('ETag: '.$etag); // send etag header
			if (isset($is_etag_response)) { // handle etag request
				header('Content-Length: 0'); // send content length header
			    exit; // terminate script
			};
			die($GLOBALS['smart_cache']['content']); // send cached content
		}
		else { // if the cache was requested but there is no cache available
			header('Cache-Control: no-cache'); // send no-cache header
			header('X-Smart-Cache: no-cache'); // send custom cache header
			if (!empty($GLOBALS['smart_cache']['include'])) include $GLOBALS['smart_cache']['include']; // include optional script, in case subrequest just met with a redirect
		};
		break;
	case 'uncached': // if showing uncached content
		if (!smartCacheHasValidResponse()) { // if there is not a valid live response from this url
			smartCacheShow('cached'); // show cached content instead
		}
		else { // else if there is a valid live response from this url
			ob_start('smartCacheBufferUncached'); // start uncached output buffer
			if (!empty($GLOBALS['smart_cache']['include'])) include $GLOBALS['smart_cache']['include']; // include optional script
		};
		break;
	case 'disabled': // if disabling cache
		header('X-Smart-Cache: disabled'); // send custom cache header
		if (!empty($GLOBALS['smart_cache']['include'])) include $GLOBALS['smart_cache']['include']; // include optional script
		break;
	case 'response_code': // if showing response coded content
		ini_set('display_errors',0); // suppress errors
		ob_start('smartCacheBufferResponseCode'); // add response code output buffer
		if (!empty($GLOBALS['smart_cache']['include'])) include $GLOBALS['smart_cache']['include']; // include optional script
		break;
};
}

function smartCacheBufferResponseCode($buffer) { // adds a response code if script didn't return empty/fatal error
return !empty($buffer) ? '<!-- RESPONSE_CODE -->' : ''; // send response code if valid buffer
}

function smartCacheNeedsRefresh() { // checks if cache needs refresh
$GLOBALS['smart_cache']['mtime']=@filemtime($GLOBALS['smart_cache']['path']); // get modification time of current cache
if ($GLOBALS['smart_cache']['mtime']) if ($_SERVER['REQUEST_TIME']<$GLOBALS['smart_cache']['mtime']+$GLOBALS['smart_cache']['ttl']) if ($ts=@filemtime($_SERVER['SCRIPT_FILENAME'])) if ($ts<=$GLOBALS['smart_cache']['mtime']) return false; // if there is a previous cache, if the cache is not ttl+ mins old, if parent script hasn't been updated since last cache, mark as not needing refresh
return true; // by default mark as needing refresh
};

function smartCacheBufferUncached($buffer) { // output handler for uncached request
global $smart_cache_data_source_failed;
if (isset($smart_cache_data_source_failed)) { // if script reported that database failed
	header('Cache-Control: no-cache'); // send no-cache header
	header('X-Smart-Cache: no-cache'); // send custom cache header
	if ($contents=@file_get_contents($GLOBALS['smart_cache']['path'])) $buffer=$contents; // temporarily set buffer to last cache
}
else if (!empty($GLOBALS['smart_cache']['is_cache_request'])) { // else if this is a cache request
	$dir=dirname($GLOBALS['smart_cache']['path']); // get cache dir
	if (!is_dir($dir)) @mkdir($dir); // create cache dir if it doesn't exist
	if (!empty($buffer) && @is_writable($dir)) { // if there is content to send and directory is writable
		if ($files=@glob($GLOBALS['smart_cache']['cache_dir'].'/'.$GLOBALS['smart_cache']['script']{0}.'/'.$GLOBALS['smart_cache']['script'].'_*')) if (sizeof($files)>$GLOBALS['smart_cache']['script_limit']) foreach($files as $file) @unlink($file); // if cache files for GET variants of this script exceeds limit, purge them
		$hash_buffer=hash('md5',$buffer); // get hash of buffer
		if ($contents=@file_get_contents($GLOBALS['smart_cache']['path'])) $hash_cache=hash('md5',$contents); // get hash of cache if exists
		if (!isset($hash_cache) || $hash_cache!=$hash_buffer) { // if contents have changed
			@file_put_contents($GLOBALS['smart_cache']['path'],$buffer,LOCK_EX); // write cache to file system
			if (!file_exists($GLOBALS['smart_cache']['cache_dir'].'/'.$GLOBALS['smart_cache']['script']{0}.'/'.$GLOBALS['smart_cache']['script'].'.src')) @file_put_contents($GLOBALS['smart_cache']['cache_dir'].'/'.$GLOBALS['smart_cache']['script']{0}.'/'.$GLOBALS['smart_cache']['script'].'.src',$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_FILENAME']); // set src url of cached page if not set
		}
		else @touch($GLOBALS['smart_cache']['path']); // else just update the ts of the cache file
		header('HTTP/1.1 200 OK'); // send response code
		header('Cache-Control: public, max-age='.$GLOBALS['smart_cache']['ttl']); // send cache-control header
		header('X-Smart-Cache: cached'); // send custom cache header
		header('Last-Modified: '.gmdate('D, d M Y H:i:s',$_SERVER['REQUEST_TIME']).' GMT'); // send last-modified header
		header('Expires: '.gmdate('D, d M Y H:i:s',$_SERVER['REQUEST_TIME']+$GLOBALS['smart_cache']['ttl']).' GMT'); // send expires header
		$etag='"'.$hash_buffer.'"'; // create etag
		header('ETag: '.$etag); // send etag header
	}
	else { // else if buffer empty or dir not writable
		header('Cache-Control: no-cache'); // send no cache header
		header('X-Smart-Cache: no-cache'); // send custom cache header
	};
}
else { // else if not a cache request
	header('Cache-Control: no-cache'); // send no cache header
	header('X-Smart-Cache: no-cache'); // send custom cache header
};
return $buffer; // display the output buffer
};

function smartCacheHasValidResponse($url=false,$redirects=0) { // checks if there is a valid live response for this request
$ch=curl_init(); // test server for valid response for this request
if (!$url) $url='http'.(!empty($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].str_replace(' ','%20',$_SERVER['PHP_SELF']).'?'.http_build_query(array_merge($_GET,array('smart_cache_response_code'=>1))); // set url if not supplied
curl_setopt($ch,CURLOPT_URL,$url); // set url for this request
curl_setopt($ch,CURLOPT_HEADER,1); // include headers in output
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); // return the content to a variable
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0); // never verify SSL because it would cause a request failure
curl_setopt($ch,CURLOPT_DNS_USE_GLOBAL_CACHE,1); // use global DNS cache
curl_setopt($ch,CURLOPT_DNS_CACHE_TIMEOUT,300); // cache DNS for 5 minutes
curl_setopt($ch,CURLOPT_USERAGENT,'SmartCache (http://technologies.whitewhale.net/cache)'); // set user agent
$content=curl_exec($ch); // fetch page
curl_close($ch); // close curl
if ($redirects<2) if ($tmp=explode("\n\r",$content)) if (sizeof($tmp)>1) { // if there haven't been 2 consecutive redirects, separate headers from output
	$matches=array();
	preg_match('/Location:\s+(.+?)\n/',$tmp[0],$matches); // match location
	if (!empty($matches[1])) return smartCacheHasValidResponse($matches[1],++$redirects); // if location found, follow redirect
};
return (strpos($content,'<!-- RESPONSE_CODE -->')!==false); // return status of response availability
}

function smartCacheCleanHost() { // clean a host's cache
$ts=$GLOBALS['smart_cache']['cache_dir'].'/clean.'.$_SERVER['HTTP_HOST'].'.ts'; // get timestamp of last clean
if (!file_exists($ts) || filemtime($ts)<$_SERVER['REQUEST_TIME']-86400) { // only clean once a day at most
	touch($ts);
	foreach(scandir($GLOBALS['smart_cache']['cache_dir']) as $val) if ($val[0]!='.') if (is_dir($GLOBALS['smart_cache']['cache_dir'].'/'.$val)) foreach(scandir($GLOBALS['smart_cache']['cache_dir'].'/'.$val) as $val2) if ($val2[0]!='.') if (substr($val2,-4,4)!='.src') if (filemtime($GLOBALS['smart_cache']['cache_dir'].'/'.$val.'/'.$val2)<=$_SERVER['REQUEST_TIME']-2592000) { // for each cache file that's been stale for 30+ days
		$is_expired=false; // default to unexpired cache entry
		$token=current(explode('_',$val2)); // get cache token
		$src=$token.'.src'; // get src file name
		if (!file_exists($GLOBALS['smart_cache']['cache_dir'].'/'.$val.'/'.$src)) {$is_expired=true;} // if no src file found, flag as expired
		else { // else if there is a src file
			$src=@parse_url(file_get_contents($GLOBALS['smart_cache']['cache_dir'].'/'.$val.'/'.$src)); // get host and path for source file
			if (!empty($src['host']) && !empty($src['path'])) if ($src['host']==$_SERVER['HTTP_HOST']) if (!file_exists($src['path'])) $is_expired=true; // if src file is on this host and no longer exists, flag as expired
		};
		if ($is_expired) unlink($GLOBALS['smart_cache']['cache_dir'].'/'.$val.'/'.$val2); // if cache entry is expired, delete file
	};
};
exit;
}

?>