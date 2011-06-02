<?php
class FrotelRouter
{
	public function route()
	{
		$reader=Request::getInstance();
		$subdomain=trim($reader->getString('subdomain'));
		$responseReg=ResponseRegistery::getInstance();
                
		if(empty($subdomain))
		{
			$responseReg->controller='main';
			return ;
		}
		
		if(!$this->validSubDomain($subdomain))
		{
			$responseReg->controller ='main';
			$responseReg->page='WebLogNotFound';
			return;
		}
		
		$site_id=$this->getSiteId($subdomain);
                $responseReg->site_id=$site_id;
		if(!$site_id)
		{
			$responseReg->controller='main';
			$responseReg->page='WebLogNotFound';
			return;
		}
		else
		{
			$responseReg->controller='site';
			
			return;
		}
		
	}
	
	private function validSubDomain($sub)
	{
		if(preg_match('#^(\d|\w)+$#',$sub))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	private function getSiteId($sub)
	{
		$db=Factory::getDBO();
		$sql="SELECT
					site.id as id,
					site.active
				FROM ge_sites as site
				JOIN ge_subdomains as subdomain
					ON(site.id=subdomain.site_id)
					
				WHERE
					sub_domain=".$db->valueQuote($db->getEscaped($sub));

		$res=$db->query($sql)->fetch();
		if($res->active==0)
		{
		    throw new InActiveException;
		}
		if($res)
		{
			return $res->id;
		}
		else
		{
			return false;
		}
	}
}