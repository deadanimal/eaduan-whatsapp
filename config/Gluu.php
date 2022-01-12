<?php
namespace App;
use Jumbojett\OpenIDConnectClient;
class Gluu
{
    public function oidc()
    {
       
		$gluu_url=(!empty(env('gluuurl')))?env('gluuurl'):'https://mykpdnhep.kpdnhep.gov.my';
		$client_id=(!empty(env('gluuclientid')))?env('gluuclientid'):'6fdf27e0-daae-42c9-bc8d-1a4d25728200';
		$client_secret=(!empty(env('gluuclientsecret')))?env('gluuclientsecret'):"800Whd2mssEPLNL7h84kK4op";
		$index=$_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];
		$oidc=new OpenIDconnectClient($gluu_url,$client_id,$client_secret);
		$oidc->addScope("profile");
		$oidc->addScope("email");
		$oidc->addScope("user_name");
		if(!empty(env('gluuscope'))){
		$oidc->addScope(env('gluuscope'));
		}
		$oidc->setVerifyPeer(false);
		$oidc->setRedirectURL($index."/authenticate");
		$oidc->providerConfigParam(array("token_endpoint",$gluu_url."oxauth/restv1/token"));
		$oidc->providerConfigParam(array("end_session_endpoint",$gluu_url."oxauth/restv1/end_session"));
		$oidc->providerConfigParam(array("authorization_endpoint",$gluu_url."oxauth/restv1/authorize"));
		$oidc->providerConfigParam(array("userinfo_endpoint",$gluu_url."oxauth/restv1/userinfo"));
		return $oidc;

    }
}


?>