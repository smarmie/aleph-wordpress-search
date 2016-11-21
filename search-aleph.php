<?php
  include_once 'search-aleph.config.php';

  $requestFind = implode('+', explode(' ', get_search_query()));

  // do Find call
  // retrieve a set number of the results
  // retrieve number of resulst in the set
  // retrieve a session-id
  $wsdlFind = $alephHost . ':' . $alephApiPort . '/AlephWebServices/services/Find?wsdl';
  // initialize SOAP client
  $paramsFindConn = [];
  $soapFind = new SoapClient($wsdlFind, $paramsFindConn);
  $paramsFind = [
    'base' => $catalog,
    'code' => 'WRD',
    'request' => $requestFind,
  ];
  // do the SOAP request
  try {
    $responseFind = $soapFind->__soapCall('find', $paramsFind);
  }
  catch (\SoapFault $e) {
    var_dump($e);
    $responseFind = null;
  }
  // parse the results into XML
  $resultsFind = simplexml_load_string($responseFind);

  $resultsArray = array();
  // check that we have results in the set
  if ((string)$resultsFind->{'error'} !== 'empty set') {
    // check set size
    if ((int)$resultsFind->{'no_records'} < 10) {
       $setentry = '1-' . (int)$resultsFind->{'no_records'};
     }
    else {
       $setentry = '1-10';
    }
    $session = (string)$resultsFind->{'session-id'};

    // do Present call
    // retrieve the list of results
    $wsdlPresent = $alephHost . ':' . $alephApiPort . '/AlephWebServices/services/Present?wsdl';
    // initialize SOAP client
    $paramsPresentConn = [];
    $soapPresent = new SoapClient($wsdlPresent, $paramsPresentConn);
    $paramsPresent = [
      'set_number' => (string)$resultsFind->{'set_number'},
      'set_entry' => $setentry,
      'format' => '',
      'char_conv' => 'UTF_TO_8859_1',
      'session' => $session,
    ];
    // do the SOAP request
    try {
      $responsePresent = $soapPresent->__soapCall('present', $paramsPresent);
    }
    catch (\SoapFault $e) {
      var_dump($e);
      $responsePresent = null;
    }
    // parse the results into XML
    $resultsPresent = simplexml_load_string($responsePresent);

    // parse the XML and create the final results array
    foreach($resultsPresent->xpath('//present/record') as $record) {
      $record = simplexml_load_string($record->asXML());
      $title = $record->xpath('/record/metadata/oai_marc/varfield[@id="200"]/subfield[@label="a"]');
      $author = $record->xpath('/record/metadata/oai_marc/varfield[@id="200"]/subfield[@label="f"]');
      $doc_number = $record->doc_number;
      // checking if any of the results are empty
      if (empty($title)) { $title = ''; } else { $title = $title[0]->__toString(); }
      if (empty($author)) { $author = ''; } else { $author = $author[0]->__toString(); }
      $url = $alephHost . ':' . $alephOpacPort . '/F/?func=direct&local_base=' . $catalog . '&doc_number=' . $doc_number;
      $resultsArray[] = [
        'title' => $title,
        'author' => $author,
        'url' => $url,
      ];
    }
  }
?>
