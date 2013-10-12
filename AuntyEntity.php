<?php
namespace AuntyEntity;
/**
* 
*
* AuntyEntity
* Kit for working with Entity Extraction and OpenCalais API
* ------------------------------------------------------
* http://auntyentity.com
* License: Apache License, Version 2.0
* Date: 2013-09-29
* Copyright 2013 Matt Terenzio
* http://journalab.com
* matt@journalab.com
* http://twitter.com/mterenzio
* ------------------------------------------------------
* 
*/

class OpenCalais {

	private $api = 'http://api.opencalais.com/tag/rs/enrich';
	private $key;
	private $content;	
	private $contentType  = 'text/html';
	private $outputFormat = 'Application/JSON';
	//private $reltagBaseURL;
	private $enableMetadataType = 'GenericRelations,SocialTags';
	private $calculateRelevanceScore = true;
	//private $docRDFaccessible;
	private $allowDistribution = false;
	private $allowSearch = false;
	//private $externalID;
	private $submitter = 'AuntyEntity';
	private $headers;


	public function __construct($key) {
		if (empty($key)) {
			throw new Exception('Provide an API key.');
		} else {
			$this->key = $key;
		}
	}		
	
	public function extractEntities($content) {
		$this->content = $content;
		$results = $this->apiReq();
		return $results;
	}
	
	private function Req() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->api);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->content);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'x-calais-licenseID: ' . $this->key,
					'content-type: ' . $this->contentType,
					'accept: ' . $this->outputFormat,
					'enableMetadataType', $this->enableMetadataType,
					'calculateRelevanceScore', $this->calculateRelevanceScore,
					'allowDistribution', $this->allowDistribution,
					'allowSearch', $this->allowSearch,
					'submitter', $this->submitter,
		));
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;	
	}
	
	public function __get($property) {
		if (isset($this->data[$property])) {
			return $this->data[$property];			
		} else {
			return false;
		}
	}
	
	public function __set($property, $value) {
		$this->data[$property] = $value;
	}
	
    public function __isset($property) {
        return isset($this->data[$property]);
    }
	
}
?>