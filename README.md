# aleph-wordpress-search
## Description
Integrate Aleph catalog searches into your WordPress search.
## Installation
Install/create a WordPress child theme and copy the parent theme's search.php.

Copy search-aleph.php and search-aleph.config.php in you child theme's folder.

Edit the child theme's search.php and add something like:
```php
<!-- #aleph search -->
<?php
  include_once 'search-aleph.php';
  // output links
  foreach($resultsArray as $result) {
    echo '<a href=', $result['url'], ' target=_blank>', $result['title'], ' - ', $result['author'], '</a></br>', PHP_EOL;
  }
?>
<!-- #/aleph search -->
```
## SOAP Requests
### Find
Search the catalog and return a set number.

https://developers.exlibrisgroup.com/aleph/apis/Aleph-X-Services/find
#### Request:
```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.aleph.exlibris.com">
  <soapenv:Header/>
  <soapenv:Body>
    <web:find soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
      <base xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</base>
      <code xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</code>
      <request xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</request>
      <adjacent xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</adjacent>
      <session xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</session>
      <client_version xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</client_version>
      <con_lng xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</con_lng>
      <translate xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</translate>
      <user_name xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</user_name>
      <user_password xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</user_password>
    </web:find>
  </soapenv:Body>
</soapenv:Envelope>
```
#### Response:
```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <soapenv:Body>
    <ns1:findResponse soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:ns1="http://webservices.aleph.exlibris.com">
      <findReturn xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"><![CDATA[<?xml version = "1.0" encoding = "UTF-8"?><find><set_number>{{XXXXXX}}</set_number><no_records>{{XXXXXXXXX}}</no_records><no_entries>{{XXXXXXXXX}}</no_entries><session-id>{{ a session identificator string }}</session-id></find>]]></findReturn>
    </ns1:findResponse>
  </soapenv:Body>
</soapenv:Envelope>```
### Present
Retrieve a list of items from a set number.

https://developers.exlibrisgroup.com/aleph/apis/Aleph-X-Services/present
#### Request
```xml
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.aleph.exlibris.com">
  <soapenv:Header/>
  <soapenv:Body>
    <web:present soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
      <set_number xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</set_number>
      <set_entry xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</set_entry>
      <format xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</format>
      <char_conv xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</char_conv>
      <session xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</session>
      <client_version xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</client_version>
      <con_lng xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</con_lng>
      <translate xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</translate>
      <user_name xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</user_name>
      <user_password xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">?</user_password>
    </web:present>
  </soapenv:Body>
</soapenv:Envelope>
```
#### Response
```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <ns1:presentResponse soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:ns1="http://webservices.aleph.exlibris.com">
         <presentReturn xsi:type="soapenc:string" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"><![CDATA[{{ a marc_xml file }}]]></presentReturn>
      </ns1:presentResponse>
   </soapenv:Body>
</soapenv:Envelope>
```
## License
See the LICENSE file.
## TODO
* Expand the README
* Use templating on the results
* Pagination
* Headings
