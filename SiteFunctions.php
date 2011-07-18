<?php
/***************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter
 * wp@punkypond.com
 ***************************************************************************/
function emailCheck($string,$domain)
{
	if(stristr($string, $domain) == FALSE) 
	{
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}

function logout()
{
	setrawcookie("mu_id", "blank", time()-3600);	
	setrawcookie("mu_user", "blank", time()-3600);
	setrawcookie("mu_artist", "blank", time()-3600);
	setrawcookie("mu_artistid", "blank", time()-3600);
	setrawcookie("mu_admin", "true", time()-3600);
}
?>